<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Parfum Store')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #faf8f3;
            color: #252525;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            background: #fffdf8;
            border-bottom: 1px solid #e8e2d8;
        }

        .brand-logo {
            color: #198754;
            font-size: 22px;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
        }

        .brand-logo:hover {
            color: #146c43;
        }

        .nav-link {
            color: #333 !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #198754 !important;
        }

        /* =========================
           SEARCH
        ========================= */

        .search-box {
            border: 1px solid #ddd6ca;
            border-radius: 10px;
            overflow: hidden;
            background: white;
        }

        .search-box input {
            border: none;
            box-shadow: none !important;
        }

        .search-box button {
            border: none;
            background: #198754;
            color: white;
            padding-left: 20px;
            padding-right: 20px;
        }

        .search-box button:hover {
            background: #146c43;
        }

        /* =========================
           CHAT
        ========================= */

        .chat-link {
            position: relative;
            text-decoration: none;
            color: #333;
            font-size: 15px;
            font-weight: 500;
            transition: .2s;
        }

        .chat-link:hover {
            color: #198754;
        }

        /* =========================
           CART
        ========================= */

        .cart-link {
            position: relative;
            text-decoration: none;
            color: #333;
            font-size: 15px;
            font-weight: 500;
            transition: .2s;
        }

        .cart-link:hover {
            color: #198754;
        }

        .cart-badge {
            position: absolute;
            top: -10px;
            right: -18px;
            font-size: 10px;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* =========================
           BUTTON
        ========================= */

        .btn-green {
            background: #198754;
            color: white;
            border-radius: 8px;
            border: none;
            padding: 9px 18px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-green:hover {
            background: #146c43;
            color: white;
        }

        /* =========================
           DROPDOWN
        ========================= */

        .dropdown-menu {
            border: 1px solid #e8e2d8;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
            padding: 8px;
        }

        .dropdown-item {
            border-radius: 7px;
            padding: 9px 12px;
            color: #333;
        }

        .dropdown-item:hover {
            background: #f5f1e9;
            color: #198754;
        }

        .dropdown-divider {
            border-color: #e8e2d8;
        }

        /* =========================
           CONTENT
        ========================= */

        .content {
            min-height: calc(100vh - 75px);
        }

        /* =========================
           FOOTER
        ========================= */

        footer {
            background: #252525;
            color: #ddd;
            padding: 25px 0;
            margin-top: 50px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 991px) {

            .search-box {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .navbar-actions {
                margin-top: 15px;
                padding-bottom: 10px;
                flex-wrap: wrap;
            }

            .chat-link {
                padding-left: 0;
            }

            .cart-link {
                margin-right: 10px;
            }
        }

        @media (max-width: 575px) {

            .brand-logo {
                font-size: 19px;
            }

            .navbar-actions {
                gap: 15px !important;
            }

            .btn-green,
            .btn-outline-success {
                padding: 8px 12px;
                font-size: 14px;
            }
        }
    </style>

    @yield('styles')

</head>

<body>

{{-- =========================================================
     NAVBAR CUSTOMER
========================================================= --}}

<nav class="navbar navbar-expand-lg sticky-top">

    <div class="container">

        {{-- LOGO --}}
        <a
            href="{{ route('store.home') }}"
            class="brand-logo"
        >
            Parfum Store
        </a>


        {{-- MOBILE TOGGLE --}}
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#customerNavbar"
            aria-controls="customerNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            Menu
        </button>


        {{-- NAVBAR CONTENT --}}
        <div
            class="collapse navbar-collapse"
            id="customerNavbar"
        >

            {{-- MENU BERANDA --}}
            <ul class="navbar-nav ms-lg-4">

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="{{ route('store.home') }}"
                    >
                        Beranda
                    </a>

                </li>

            </ul>


            {{-- SEARCH --}}
            <form
                action="{{ route('store.home') }}"
                method="GET"
                class="search-box d-flex mx-lg-auto my-3 my-lg-0"
                style="max-width: 400px; width: 100%;"
            >

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari parfum..."
                    value="{{ request('search') }}"
                >

                <button
                    type="submit"
                    class="px-3"
                >
                    Cari
                </button>

            </form>


            {{-- RIGHT NAVBAR --}}
            <div class="d-flex align-items-center gap-4 navbar-actions">

                {{-- =================================================
                     CHAT CUSTOMER
                ================================================== --}}

                @auth

                    @if(auth()->user()->role === 'customer')

                        <a
                            href="{{ route('customer.chat') }}"
                            class="chat-link"
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
                            $cartCount = auth()->user()
                                ->carts()
                                ->sum('jumlah');
                        @endphp

                        <a
                            href="{{ route('cart.index') }}"
                            class="cart-link"
                        >
                            Keranjang

                            @if($cartCount > 0)

                                <span class="badge bg-danger rounded-pill cart-badge">
                                    {{ $cartCount }}
                                </span>

                            @endif

                        </a>

                    @endif

                @endauth


                {{-- =================================================
                     LOGIN / USER
                ================================================== --}}

                @auth

                    <div class="dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            {{ auth()->user()->name }}
                        </a>


                        <ul class="dropdown-menu dropdown-menu-end">

                            {{-- PESANAN SAYA --}}
                            <li>

                                <a
                                    class="dropdown-item"
                                    href="{{ route('customer.orders') }}"
                                >
                                    Pesanan Saya
                                </a>

                            </li>


                            {{-- CHAT --}}
                            @if(auth()->user()->role === 'customer')

                                <li>

                                    <a
                                        class="dropdown-item"
                                        href="{{ route('customer.chat') }}"
                                    >
                                        Chat dengan Admin
                                    </a>

                                </li>

                            @endif


                            <li>
                                <hr class="dropdown-divider">
                            </li>


                            {{-- LOGOUT --}}
                            <li>

                                <form
                                    action="{{ route('logout') }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="dropdown-item"
                                    >
                                        Logout
                                    </button>

                                </form>

                            </li>

                        </ul>

                    </div>


                @else

                    {{-- LOGIN --}}
                    <a
                        href="{{ route('login') }}"
                        class="btn btn-outline-success"
                    >
                        Login
                    </a>


                    {{-- REGISTER --}}
                    <a
                        href="{{ route('register') }}"
                        class="btn-green"
                    >
                        Register
                    </a>

                @endauth

            </div>

        </div>

    </div>

</nav>


{{-- =========================================================
     MAIN CONTENT
========================================================= --}}

<main class="content">

    @yield('content')

</main>


{{-- =========================================================
     FOOTER
========================================================= --}}

<footer>

    <div class="container text-center">

        <small>
            © {{ date('Y') }} Parfum Store. All rights reserved.
        </small>

    </div>

</footer>


{{-- =========================================================
     BOOTSTRAP JS
========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>

</html>
```
