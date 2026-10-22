<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    private function guardCustomer(): void
    {
        abort_unless(Auth::check() && Auth::user()->role === 'customer', 403);
    }

    public function dashboard()
    {
        $this->guardCustomer();
        $products = DB::table('products')->where('stock', '>', 0)->latest()->limit(4)->get();
        $categories = DB::table('categories')->orderBy('name')->get();
        $ordersCount = DB::table('customer_orders')->where('user_id', Auth::id())->count();
        $pendingCount = DB::table('customer_orders')->where('user_id', Auth::id())->whereIn('status', ['pending','processing'])->count();
        $latestOrders = DB::table('customer_orders')->where('user_id', Auth::id())->latest()->limit(5)->get();
        return view('customer.dashboard', compact('products','categories','ordersCount','pendingCount','latestOrders'));
    }

    public function catalog(Request $request)
    {
        $this->guardCustomer();
        $query = DB::table('products')->leftJoin('categories','products.category_id','=','categories.id')
            ->select('products.*','categories.name as category_name')->where('products.stock','>',0);
        if ($request->filled('q')) {
            $term = trim($request->input('q'));
            $query->where(fn($q) => $q->where('products.name','like',"%{$term}%")
                ->orWhere('products.sku','like',"%{$term}%")->orWhere('products.description','like',"%{$term}%"));
        }
        if ($request->filled('category')) $query->where('products.category_id',$request->integer('category'));
        $products = $query->orderBy('products.name')->paginate(9)->withQueryString();
        $categories = DB::table('categories')->orderBy('name')->get();
        return view('customer.catalog', compact('products','categories'));
    }

    public function product(int $id)
    {
        $this->guardCustomer();
        $product = DB::table('products')->leftJoin('categories','products.category_id','=','categories.id')
            ->select('products.*','categories.name as category_name')->where('products.id',$id)->first();
        abort_unless($product,404);
        return view('customer.product',compact('product'));
    }

    public function addToCart(Request $request, int $id)
    {
        $this->guardCustomer();
        $data = $request->validate(['quantity'=>['required','integer','min:1','max:99']]);
        $product = DB::table('products')->where('id',$id)->first();
        abort_unless($product,404);
        $cart = session('veloura_cart',[]);
        $newQty = (int)($cart[$id]['quantity'] ?? 0) + (int)$data['quantity'];
        if ($product->stock < $newQty) return back()->withErrors(['quantity'=>'Jumlah melebihi stok tersedia.']);
        $cart[$id] = ['quantity'=>$newQty];
        session(['veloura_cart'=>$cart]);
        return redirect()->route('customer.cart')->with('success',$product->name.' ditambahkan ke keranjang.');
    }

    public function cart()
    {
        $this->guardCustomer();
        $items=[]; $subtotal=0;
        foreach(session('veloura_cart',[]) as $id=>$line) {
            $product=DB::table('products')->where('id',$id)->first();
            if(!$product) continue;
            $qty=(int)$line['quantity']; $lineTotal=(float)$product->selling_price*$qty;
            $items[]=(object)['product'=>$product,'quantity'=>$qty,'line_total'=>$lineTotal];
            $subtotal += $lineTotal;
        }
        return view('customer.cart',compact('items','subtotal'));
    }

    public function updateCart(Request $request,int $id)
    {
        $this->guardCustomer();
        $data=$request->validate(['quantity'=>['required','integer','min:1','max:99']]);
        $product=DB::table('products')->where('id',$id)->first(); abort_unless($product,404);
        if($data['quantity']>$product->stock) return back()->withErrors(['quantity'=>'Jumlah melebihi stok tersedia.']);
        $cart=session('veloura_cart',[]);
        if(isset($cart[$id])) { $cart[$id]['quantity']=(int)$data['quantity']; session(['veloura_cart'=>$cart]); }
        return redirect()->route('customer.cart')->with('success','Keranjang diperbarui.');
    }

    public function removeFromCart(int $id)
    {
        $this->guardCustomer(); $cart=session('veloura_cart',[]); unset($cart[$id]); session(['veloura_cart'=>$cart]);
        return redirect()->route('customer.cart')->with('success','Produk dihapus dari keranjang.');
    }

    public function checkout()
    {
        $this->guardCustomer(); $cart=session('veloura_cart',[]);
        if(!$cart) return redirect()->route('customer.cart')->with('error','Keranjang masih kosong.');
        $items=[]; $subtotal=0;
        foreach($cart as $id=>$line) {
            $product=DB::table('products')->where('id',$id)->first();
            if(!$product) continue;
            $qty=(int)$line['quantity']; $items[]=['product'=>$product,'quantity'=>$qty];
            $subtotal += (float)$product->selling_price*$qty;
        }
        if(!$items) return redirect()->route('customer.cart')->with('error','Produk tidak tersedia.');
        return view('customer.checkout',compact('items','subtotal'));
    }

    public function placeOrder(Request $request)
    {
        $this->guardCustomer();
        $data=$request->validate([
            'phone'=>['nullable','string','max:30'],
            'shipping_address'=>['required','string','min:10','max:2000'],
            'customer_note'=>['nullable','string','max:1000'],
        ]);
        $cart=session('veloura_cart',[]);
        if(!$cart) return redirect()->route('customer.cart')->with('error','Keranjang masih kosong.');
        try {
            $orderId=DB::transaction(function() use($cart,$data) {
                $lines=[]; $subtotal=0;
                foreach($cart as $id=>$line) {
                    $product=DB::table('products')->where('id',$id)->lockForUpdate()->first();
                    $qty=(int)$line['quantity'];
                    if(!$product || $qty<1 || $product->stock<$qty) throw new \RuntimeException('Stok produk tidak mencukupi. Silakan periksa keranjang.');
                    $price=(float)$product->selling_price; $lineTotal=$price*$qty;
                    $lines[]=['product'=>$product,'quantity'=>$qty,'price'=>$price,'total'=>$lineTotal]; $subtotal += $lineTotal;
                }
                $orderId=DB::table('customer_orders')->insertGetId([
                    'user_id'=>Auth::id(),'order_number'=>'VLR-'.now()->format('ymd').'-'.Str::upper(Str::random(6)),
                    'customer_name'=>Auth::user()->name,'customer_email'=>Auth::user()->email,'phone'=>$data['phone']??null,
                    'shipping_address'=>$data['shipping_address'],'payment_method'=>'transfer_manual','payment_status'=>'unpaid',
                    'status'=>'pending','subtotal'=>$subtotal,'shipping_cost'=>0,'total'=>$subtotal,
                    'customer_note'=>$data['customer_note']??null,'created_at'=>now(),'updated_at'=>now()
                ]);
                foreach($lines as $line) {
                    DB::table('customer_order_items')->insert([
                        'customer_order_id'=>$orderId,'product_id'=>$line['product']->id,'product_name'=>$line['product']->name,
                        'sku'=>$line['product']->sku,'quantity'=>$line['quantity'],'unit_price'=>$line['price'],'line_total'=>$line['total'],
                        'created_at'=>now(),'updated_at'=>now()
                    ]);
                    DB::table('products')->where('id',$line['product']->id)->decrement('stock',$line['quantity']);
                }
                return $orderId;
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('customer.cart')->with('error',$e->getMessage());
        }
        session()->forget('veloura_cart');
        return redirect()->route('customer.order.show',$orderId)->with('success','Pesanan berhasil dibuat.');
    }

    public function orders()
    {
        $this->guardCustomer();
        $orders=DB::table('customer_orders')->where('user_id',Auth::id())->latest()->paginate(10);
        return view('customer.orders',compact('orders'));
    }

    public function orderDetail(int $id)
    {
        $this->guardCustomer();
        $order=DB::table('customer_orders')->where('user_id',Auth::id())->where('id',$id)->first(); abort_unless($order,404);
        $items=DB::table('customer_order_items')->where('customer_order_id',$id)->get();
        return view('customer.order-detail',compact('order','items'));
    }

    public function transactions()
    {
        $this->guardCustomer();
        $orders=DB::table('customer_orders')->where('user_id',Auth::id())->whereIn('status',['completed','delivered'])->latest()->paginate(10);
        return view('customer.transactions',compact('orders'));
    }

    public function profile()
    {
        $this->guardCustomer(); return view('customer.profile',['user'=>Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $this->guardCustomer(); $user=Auth::user();
        $data=$request->validate([
            'name'=>['required','string','max:255'],
            'email'=>['required','email','max:255',Rule::unique('users','email')->ignore($user->id)],
            'password'=>['nullable','string','min:8','confirmed'],
        ]);
        $update=['name'=>$data['name'],'email'=>$data['email'],'updated_at'=>now()];
        if(!empty($data['password'])) $update['password']=Hash::make($data['password']);
        DB::table('users')->where('id',$user->id)->update($update);
        return redirect()->route('customer.profile')->with('success','Profil berhasil diperbarui.');
    }
}
