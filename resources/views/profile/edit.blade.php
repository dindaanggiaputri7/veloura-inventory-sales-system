
@extends('admin.layout')

@section('content')
<style>
    .profile-page {
        max-width: 1100px;
        margin: 0 auto;
        color: #39242a;
    }

    .profile-heading {
        margin-bottom: 28px;
    }

    .profile-heading h1 {
        margin: 0 0 8px;
        font-size: 30px;
        line-height: 1.3;
        font-weight: 750;
        letter-spacing: -0.6px;
    }

    .profile-heading p {
        margin: 0;
        color: #837078;
        font-size: 14px;
        line-height: 1.7;
    }

    .profile-card {
        margin-bottom: 24px;
        padding: 30px;
        background: #fff;
        border: 1px solid #eee1dc;
        border-radius: 18px;
        box-shadow: 0 5px 18px rgba(65, 35, 43, .035);
    }

    .profile-card:last-child {
        margin-bottom: 0;
    }

    .profile-card h2 {
        margin: 0 0 8px;
        color: #4f2530;
        font-size: 20px;
        font-weight: 700;
        line-height: 1.5;
    }

    .profile-card h3 {
        margin: 0 0 8px;
        color: #4f2530;
        font-size: 17px;
        font-weight: 650;
    }

    .profile-card p {
        color: #796a70;
        font-size: 14px;
        line-height: 1.7;
    }

    .profile-card label {
        display: block;
        margin: 0 0 8px;
        color: #49363c;
        font-size: 13px;
        font-weight: 650;
    }

    .profile-card input:not([type="checkbox"]):not([type="radio"]),
    .profile-card select,
    .profile-card textarea {
        display: block;
        box-sizing: border-box;
        width: 100%;
        min-height: 46px;
        padding: 11px 14px;
        color: #39242a;
        background: #fffdfb;
        border: 1px solid #e6d8d3;
        border-radius: 10px;
        font: inherit;
        font-size: 14px;
        transition: border-color .2s, box-shadow .2s;
    }

    .profile-card textarea {
        min-height: 110px;
        resize: vertical;
    }

    .profile-card input:focus,
    .profile-card select:focus,
    .profile-card textarea:focus {
        outline: none;
        border-color: #7a3443;
        box-shadow: 0 0 0 3px rgba(122, 52, 67, .12);
    }

    .profile-card form > div {
        margin-bottom: 18px;
    }

    .profile-card button,
    .profile-card [type="submit"] {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 10px 20px;
        color: #fff;
        background: #5b2632;
        border: 1px solid #5b2632;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 650;
        cursor: pointer;
        transition: background .2s, transform .2s;
    }

    .profile-card button:hover,
    .profile-card [type="submit"]:hover {
        background: #763746;
    }

    .profile-card button:active,
    .profile-card [type="submit"]:active {
        transform: translateY(1px);
    }

    .profile-card .text-sm {
        font-size: 13px;
    }

    .profile-card .text-red-600,
    .profile-card .text-red-500 {
        color: #b42335;
    }

    .profile-card .text-green-600,
    .profile-card .text-green-500 {
        color: #237a52;
    }

    .profile-card section {
        max-width: none;
    }

    @media (max-width: 640px) {
        .profile-heading h1 {
            font-size: 25px;
        }

        .profile-card {
            padding: 20px 16px;
            border-radius: 14px;
        }
    }
</style>

<div class="profile-page">
    <div class="profile-heading">
        <h1>Profil Saya</h1>
        <p>Kelola informasi pribadi dan keamanan akun Veloura.</p>
    </div>

    <div class="profile-card">
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="profile-card">
        @include('profile.partials.update-password-form')
    </div>

    <div class="profile-card">
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
