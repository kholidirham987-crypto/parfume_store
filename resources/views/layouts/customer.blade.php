<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Parfum Store')
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        /* =====================================================
           GLOBAL
        ===================================================== */

        body {
            background: #f8f1e7;
            font-family: "Segoe UI", Arial, sans-serif;
            color: #3f3429;
        }


        /* =====================================================
           CUSTOMER NAVBAR
        ===================================================== */

        .store-navbar {
            background: #fffaf3;
            border-bottom: 1px solid #eadfce;

            position: sticky;
            top: 0;

            z-index: 1000;
        }

        .store-navbar .container {
            min-height: 75px;
        }


        /* =====================================================
           NAVBAR INNER
        ===================================================== */

        .store-navbar-inner {
            min-height: 75px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 25px;
        }


        /* =====================================================
           LOGO
        ===================================================== */

        .store-logo {
            color: #5a4633;

            text-decoration: none;

            font-size: 24px;
            font-weight: 800;

            white-space: nowrap;

            transition: color .2s ease;
        }

        .store-logo:hover {
            color: #198754;
        }


        /* =====================================================
           BAGIAN KANAN NAVBAR
        ===================================================== */

        .store-navbar-right {
            flex: 1;

            display: flex;
            align-items: center;
            justify-content: flex-end;

            gap: 24px;

            min-width: 0;
        }


        /* =====================================================
           SEARCH
           HANYA MUNCUL DI BERANDA
        ===================================================== */

        .store-search {
            width: 380px;
            max-width: 100%;
        }

        .store-search .input-group {
            height: 44px;

            overflow: hidden;

            background: #f7f1e8;

            border: 1px solid #eadfce;
            border-radius: 30px;
        }

        .store-search input {
            border: none;

            background: transparent;

            padding: 10px 17px;

            color: #3f3429;

            font-size: 14px;
        }

        .store-search input:focus {
            border: none;

            box-shadow: none;

            background: transparent;
        }

        .store-search input::placeholder {
            color: #8d8276;
        }

        .store-search button {
            border: none;

            background: #198754;

            color: #ffffff;

            padding: 0 20px;

            font-size: 14px;

            font-weight: 600;

            transition: background .2s ease;
        }

        .store-search button:hover {
            background: #146c43;
        }


        /* =====================================================
           MENU BERANDA
        ===================================================== */

        .store-menu {
            display: flex;
            align-items: center;

            gap: 22px;

            white-space: nowrap;
        }

        .store-nav-link {
            position: relative;

            display: inline-flex;
            align-items: center;

            color: #5a4633;

            text-decoration: none;

            font-size: 15px;

            font-weight: 600;

            line-height: 1.4;

            white-space: nowrap;

            transition: color .2s ease;
        }

        .store-nav-link:hover {
            color: #198754;
        }


        /* =====================================================
           CART
        ===================================================== */

        .cart-link {
            position: relative;
        }

        .cart-badge {
            position: absolute;

            top: -10px;
            right: -14px;

            min-width: 18px;
            height: 18px;

            padding: 0 5px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #dc3545;

            color: #ffffff;

            border-radius: 20px;

            font-size: 10px;

            font-weight: 700;

            line-height: 1;
        }


        /* =====================================================
           USER DROPDOWN
        ===================================================== */

        .user-dropdown {
            position: relative;
        }

        .user-button {
            border: none;

            padding: 0;

            background: transparent;

            color: #5a4633;

            font-size: 15px;

            font-weight: 600;

            line-height: 1.4;

            white-space: nowrap;
        }

        .user-button:hover {
            color: #198754;
        }

        .user-button:focus {
            box-shadow: none;
        }


        /* =====================================================
           DROPDOWN
        ===================================================== */

        .dropdown-menu {
            min-width: 210px;

            margin-top: 12px !important;

            padding: 7px;

            background: #fffdf9;

            border: 1px solid #eadfce;

            border-radius: 12px;

            box-shadow: 0 10px 30px rgba(63, 52, 41, .10);
        }

        .dropdown-item {
            padding: 9px 12px;

            border-radius: 7px;

            color: #4f4439;

            font-size: 14px;

            font-weight: 500;
        }

        .dropdown-item:hover {
            background: #f8f1e7;

            color: #198754;
        }

        .dropdown-divider {
            border-color: #eadfce;
        }


        /* =====================================================
           LOGOUT
        ===================================================== */

        .logout-item {
            width: 100%;

            border: none;

            background: transparent;

            color: #8f3f3f;

            text-align: left;
        }

        .logout-item:hover {
            background: #fbeeee;

            color: #a52828;
        }


        /* =====================================================
           LOGIN / REGISTER
        ===================================================== */

        .guest-menu {
            display: flex;
            align-items: center;

            gap: 16px;
        }

        .login-button {
            color: #198754;

            text-decoration: none;

            font-size: 15px;

            font-weight: 600;

            white-space: nowrap;
        }

        .login-button:hover {
            color: #146c43;
        }

        .register-button {
            padding: 8px 16px;

            background: #198754;

            color: #ffffff;

            text-decoration: none;

            border-radius: 8px;

            font-size: 14px;

            font-weight: 600;

            white-space: nowrap;

            transition: background .2s ease;
        }

        .register-button:hover {
            background: #146c43;

            color: #ffffff;
        }


        /* =====================================================
           CONTENT
        ===================================================== */

        .store-content {
            min-height: calc(100vh - 150px);
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .store-footer {
            margin-top: 50px;

            padding: 30px 0;

            background: #5a4633;

            color: #ffffff;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1200px) {

            .store-search {
                width: 300px;
            }

            .store-navbar-right {
                gap: 18px;
            }

            .store-menu {
                gap: 16px;
            }

        }


        @media (max-width: 992px) {

            .store-navbar .container {
                padding-top: 15px;
                padding-bottom: 15px;
            }

            .store-navbar-inner {
                flex-wrap: wrap;

                gap: 15px;
            }

            .store-navbar-right {
                width: 100%;

                flex-wrap: wrap;

                justify-content: flex-end;
            }

            .store-search {
                order: 1;

                width: 100%;
                max-width: 100%;
            }

            .store-menu {
                order: 2;
            }

            .user-dropdown {
                order: 3;
            }

            .guest-menu {
                order: 3;
            }

        }


        @media (max-width: 768px) {

            .store-logo {
                font-size: 20px;
            }

            .store-navbar-inner {
                gap: 12px;
            }

            .store-navbar-right {
                gap: 14px;
            }

            .store-menu {
                width: 100%;

                justify-content: center;

                gap: 18px;
            }

            .store-nav-link {
                font-size: 14px;
            }

            .user-button {
                font-size: 14px;
            }

            .guest-menu {
                width: 100%;

                justify-content: center;
            }

        }


        @media (max-width: 480px) {

            .store-navbar .container {
                padding-left: 12px;
                padding-right: 12px;
            }

            .store-navbar-inner {
                justify-content: center;
            }

            .store-logo {
                width: 100%;

                text-align: center;

                font-size: 20px;
            }

            .store-navbar-right {
                justify-content: center;
            }

            .store-menu {
                gap: 12px;
            }

            .store-nav-link {
                font-size: 13px;
            }

            .user-dropdown {
                margin: 0 auto;
            }

            .guest-menu {
                justify-content: center;
            }

            .store-search button {
                padding-left: 15px;
                padding-right: 15px;
            }

        }

    </style>

    @stack('styles')

</head>


<body>


{{-- =====================================================
     CEK HALAMAN
===================================================== --}}

@php

    /*
     * BERANDA
     *
     * Search + Kategori + Chat + Keranjang
     */
    $isStoreHome = request()->routeIs('store.home');


    /*
     * CHAT CUSTOMER
     */
    $isCustomerChat = request()->routeIs('customer.chat');


    /*
     * PESANAN CUSTOMER
     *
     * Termasuk halaman:
     * /pesanan
     * /pesanan/{order}
     */
    $isCustomerOrders =
        request()->routeIs('customer.orders') ||
        request()->routeIs('customer.orders.show');

@endphp



{{-- =====================================================
     CUSTOMER NAVBAR
===================================================== --}}

<header class="store-navbar">

    <div class="container">

        <div class="store-navbar-inner">


            {{-- =================================================
                 LOGO
            ================================================== --}}

            <a
                href="{{ route('store.home') }}"
                class="store-logo"
            >
                Parfum Store
            </a>



            {{-- =================================================
                 NAVBAR RIGHT
            ================================================== --}}

            <div class="store-navbar-right">


                {{-- =================================================
                     SEARCH

                     HANYA BERANDA
                ================================================== --}}

                @if($isStoreHome)

                    <form
                        action="{{ route('store.home') }}"
                        method="GET"
                        class="store-search"
                    >

                        <div class="input-group">

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari parfum..."
                                value="{{ request('search') }}"
                            >

                            <button type="submit">
                                Cari
                            </button>

                        </div>

                    </form>

                @endif



                {{-- =================================================
                     MENU UTAMA

                     HANYA BERANDA
                ================================================== --}}

                @if($isStoreHome)

                    <nav class="store-menu">


                        {{-- =================================================
                             KATEGORI
                        ================================================== --}}

                        <a
                            href="{{ route('store.home') }}"
                            class="store-nav-link"
                        >
                            Kategori
                        </a>



                        {{-- =================================================
                             CHAT
                        ================================================== --}}

                        @auth

                            @if(auth()->user()->role === 'customer')

                                <a
                                    href="{{ route('customer.chat') }}"
                                    class="store-nav-link"
                                >
                                    Chat
                                </a>

                            @endif

                        @endauth



                        {{-- =================================================
                             KERANJANG
                        ================================================== --}}

                        @auth

                            @if(auth()->user()->role === 'customer')

                                @php

                                    $cartCount = auth()
                                        ->user()
                                        ->carts()
                                        ->sum('jumlah');

                                @endphp


                                <a
                                    href="{{ route('cart.index') }}"
                                    class="store-nav-link cart-link"
                                >

                                    Keranjang


                                    @if($cartCount > 0)

                                        <span class="cart-badge">
                                            {{ $cartCount }}
                                        </span>

                                    @endif

                                </a>

                            @endif

                        @endauth

                    </nav>

                @endif



                {{-- =================================================
                     GUEST

                     LOGIN / REGISTER
                ================================================== --}}

                @guest

                    <div class="guest-menu">

                        <a
                            href="{{ route('login') }}"
                            class="login-button"
                        >
                            Login
                        </a>


                        <a
                            href="{{ route('register') }}"
                            class="register-button"
                        >
                            Register
                        </a>

                    </div>

                @endguest



                {{-- =================================================
                     CUSTOMER ACCOUNT

                     TETAP MUNCUL DI:

                     - BERANDA
                     - CHAT
                     - PESANAN
                     - DETAIL PESANAN
                ================================================== --}}

                @auth

                    @if(auth()->user()->role === 'customer')

                        <div class="dropdown user-dropdown">


                            {{-- =================================================
                                 NAMA CUSTOMER
                            ================================================== --}}

                            <button
                                type="button"
                                class="user-button dropdown-toggle"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                {{ auth()->user()->name }}
                            </button>



                            {{-- =================================================
                                 DROPDOWN
                            ================================================== --}}

                            <ul class="dropdown-menu dropdown-menu-end">


                                {{-- =================================================
                                     PESANAN SAYA
                                ================================================== --}}

                                <li>

                                    <a
                                        href="{{ route('customer.orders') }}"
                                        class="dropdown-item"
                                    >
                                        Pesanan Saya
                                    </a>

                                </li>



                                {{-- =================================================
                                     CHAT DENGAN ADMIN
                                ================================================== --}}

                                <li>

                                    <a
                                        href="{{ route('customer.chat') }}"
                                        class="dropdown-item"
                                    >
                                        Chat dengan Admin
                                    </a>

                                </li>



                                {{-- =================================================
                                     PEMISAH
                                ================================================== --}}

                                <li>

                                    <hr class="dropdown-divider">

                                </li>



                                {{-- =================================================
                                     LOGOUT
                                ================================================== --}}

                                <li>

                                    <form
                                        action="{{ route('logout') }}"
                                        method="POST"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="dropdown-item logout-item"
                                        >
                                            Logout
                                        </button>

                                    </form>

                                </li>

                            </ul>

                        </div>

                    @endif

                @endauth


            </div>

        </div>

    </div>

</header>



{{-- =====================================================
     CONTENT
===================================================== --}}

<main class="store-content">

    @yield('content')

</main>



{{-- =====================================================
     FOOTER
===================================================== --}}

<footer class="store-footer">

    <div class="container text-center">

        <p class="mb-1 fw-bold">
            Parfum Store
        </p>

        <small>
            Temukan aroma yang sesuai dengan karakter Anda.
        </small>

    </div>

</footer>



{{-- =====================================================
     BOOTSTRAP JAVASCRIPT
===================================================== --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')


</body>

</html>