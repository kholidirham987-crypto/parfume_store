<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Admin Parfum Store')
    </title>


    <style>

        /* =====================================================
            GLOBAL
        ===================================================== */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;

            background: #f7f3ed;

            color: #2d261f;
        }


        /* =====================================================
            SIDEBAR
        ===================================================== */

        .sidebar {
            position: fixed;

            top: 0;
            left: 0;
            bottom: 0;

            width: 250px;

            display: flex;
            flex-direction: column;

            padding: 30px 18px;

            background: #4b3621;

            color: #ffffff;

            z-index: 1000;
        }


        /* =====================================================
            BRAND
        ===================================================== */

        .sidebar-brand {

            padding: 0 12px;

            margin-bottom: 40px;
        }

        .brand-title {

            color: #ffffff;

            font-size: 20px;

            font-weight: 800;

            letter-spacing: 0.5px;
        }

        .brand-subtitle {

            margin-top: 6px;

            color: #d8cbbd;

            font-size: 11px;

            font-weight: 500;
        }


        /* =====================================================
            MENU SIDEBAR
        ===================================================== */

        .sidebar-menu {

            display: flex;

            flex-direction: column;

            gap: 4px;
        }

        .sidebar-menu a {

            display: block;

            width: 100%;

            padding: 12px 14px;

            border-radius: 8px;

            color: #f5eee7;

            text-decoration: none;

            font-size: 14px;

            font-weight: 600;

            transition: all 0.2s ease;
        }

        .sidebar-menu a:hover {

            background: rgba(255, 255, 255, 0.08);

            color: #ffffff;
        }

        .sidebar-menu a.active {

            background: rgba(255, 255, 255, 0.15);

            color: #ffffff;

            font-weight: 700;
        }


        /* =====================================================
            BAGIAN BAWAH SIDEBAR
        ===================================================== */

        .sidebar-bottom {

            margin-top: auto;
        }


        /* =====================================================
            AKUN ADMIN
        ===================================================== */

        .account-box {

            margin-bottom: 12px;

            padding: 12px 14px;

            border-radius: 8px;

            background: rgba(255, 255, 255, 0.06);
        }

        .account-info {

            min-width: 0;
        }

        .account-name {

            overflow: hidden;

            color: #ffffff;

            font-size: 13px;

            font-weight: 700;

            white-space: nowrap;

            text-overflow: ellipsis;
        }

        .account-role {

            margin-top: 4px;

            color: #d8cbbd;

            font-size: 11px;

            font-weight: 500;
        }


        /* =====================================================
            LOGOUT
        ===================================================== */

        .logout-form {

            margin: 0;
        }

        .logout-button {

            display: block;

            width: 100%;

            padding: 12px 14px;

            border: none;

            border-radius: 8px;

            background: transparent;

            color: #f5eee7;

            text-align: left;

            font-family: inherit;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            transition: all 0.2s ease;
        }

        .logout-button:hover {

            background: rgba(255, 255, 255, 0.08);

            color: #ffffff;
        }


        /* =====================================================
            MAIN CONTENT
        ===================================================== */

        .main-content {

            min-height: 100vh;

            margin-left: 250px;

            padding: 35px;
        }


        /* =====================================================
            ALERT
        ===================================================== */

        .alert {

            padding: 14px 18px;

            margin-bottom: 20px;

            border-radius: 10px;

            font-size: 14px;
        }

        .alert-success {

            background: #e7f5e8;

            color: #256b2b;

            border: 1px solid #cce8ce;
        }

        .alert-error {

            background: #fdeaea;

            color: #a12626;

            border: 1px solid #f2cccc;
        }


        /* =====================================================
            PAGE HEADER
        ===================================================== */

        .page-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            margin-bottom: 25px;
        }

        .page-header h1 {

            margin: 0 0 6px;

            font-size: 28px;

            color: #2d261f;
        }

        .page-header p {

            margin: 0;

            color: #75695d;

            font-size: 14px;
        }


        /* =====================================================
            CARD
        ===================================================== */

        .card {

            overflow: hidden;

            background: #ffffff;

            border: 1px solid #e7ded4;

            border-radius: 16px;

            box-shadow:
                0 5px 20px rgba(75, 54, 33, 0.06);
        }

        .card-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 20px 24px;

            border-bottom: 1px solid #eee5dc;
        }


        /* =====================================================
            TABLE
        ===================================================== */

        .table-wrapper {

            width: 100%;

            overflow-x: auto;
        }

        table {

            width: 100%;

            border-collapse: collapse;
        }

        th,
        td {

            padding: 16px 20px;

            text-align: left;

            border-bottom: 1px solid #eee5dc;
        }

        th {

            background: #faf7f3;

            color: #6f6255;

            font-size: 13px;

            font-weight: 600;
        }

        td {

            font-size: 14px;
        }

        tbody tr:hover {

            background: #fcfaf7;
        }


        /* =====================================================
            BUTTON
        ===================================================== */

        .btn-primary,
        .btn-secondary,
        .btn-view,
        .btn-edit,
        .btn-delete {

            display: inline-block;

            padding: 9px 14px;

            border: none;

            border-radius: 8px;

            text-decoration: none;

            font-family: inherit;

            font-size: 13px;

            cursor: pointer;

            transition: all 0.2s ease;
        }

        .btn-primary {

            background: #4b3621;

            color: #ffffff;
        }

        .btn-primary:hover {

            background: #362617;
        }

        .btn-secondary {

            background: #eee7df;

            color: #4b3621;
        }

        .btn-secondary:hover {

            background: #e1d8ce;
        }

        .btn-view {

            background: #e9f1e8;

            color: #315b35;
        }

        .btn-edit {

            background: #f5ead8;

            color: #76531e;
        }

        .btn-delete {

            background: #f9e1df;

            color: #a33b35;
        }


        /* =====================================================
            ACTION
        ===================================================== */

        .action-group {

            display: flex;

            align-items: center;

            gap: 7px;

            flex-wrap: wrap;
        }

        .action-group form {

            margin: 0;
        }


        /* =====================================================
            BADGE
        ===================================================== */

        .badge-customer {

            display: inline-block;

            padding: 5px 10px;

            border-radius: 20px;

            background: #e7f3e8;

            color: #34703b;

            font-size: 12px;

            font-weight: 600;
        }


        /* =====================================================
            FORM
        ===================================================== */

        .form-card {

            max-width: 700px;

            padding: 25px;
        }

        .form-group {

            margin-bottom: 20px;
        }

        .form-group label {

            display: block;

            margin-bottom: 8px;

            font-size: 14px;

            font-weight: 600;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {

            width: 100%;

            padding: 12px 14px;

            border: 1px solid #ddd2c7;

            border-radius: 9px;

            outline: none;

            background: #ffffff;

            color: #2d261f;

            font-family: inherit;

            font-size: 14px;
        }

        .form-group textarea {

            min-height: 120px;

            resize: vertical;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {

            border-color: #4b3621;
        }

        .error {

            display: block;

            margin-top: 6px;

            color: #b52e2e;

            font-size: 12px;
        }

        .form-actions {

            display: flex;

            justify-content: flex-end;

            gap: 10px;

            margin-top: 25px;
        }


        /* =====================================================
            EMPTY STATE
        ===================================================== */

        .empty-state {

            padding: 60px 20px;

            text-align: center;
        }

        .empty-state h3 {

            margin: 0 0 8px;
        }

        .empty-state p {

            margin: 0 0 20px;

            color: #75695d;
        }


        /* =====================================================
            DETAIL
        ===================================================== */

        .detail-row {

            display: flex;

            justify-content: space-between;

            gap: 20px;

            padding: 20px 24px;

            border-bottom: 1px solid #eee5dc;
        }

        .detail-row:last-child {

            border-bottom: none;
        }

        .detail-row span {

            color: #75695d;
        }


        /* =====================================================
            RESPONSIVE 900PX
        ===================================================== */

        @media (max-width: 900px) {

            .sidebar {

                width: 220px;
            }

            .main-content {

                margin-left: 220px;

                padding: 25px;
            }
        }


        /* =====================================================
            RESPONSIVE 768PX
        ===================================================== */

        @media (max-width: 768px) {

            .sidebar {

                position: relative;

                width: 100%;

                height: auto;

                min-height: auto;

                padding: 20px;
            }

            .sidebar-brand {

                margin-bottom: 20px;
            }

            .sidebar-menu {

                gap: 4px;
            }

            .sidebar-bottom {

                margin-top: 20px;
            }

            .main-content {

                margin-left: 0;

                padding: 20px;
            }

            .page-header {

                align-items: flex-start;

                flex-direction: column;
            }

            .page-header h1 {

                font-size: 24px;
            }

            .form-card {

                max-width: 100%;
            }

            .detail-row {

                flex-direction: column;

                gap: 5px;
            }
        }

    </style>

</head>


<body>


    {{-- =====================================================
         SIDEBAR ADMIN
    ====================================================== --}}

    <aside class="sidebar">


        {{-- =================================================
             BRAND
        ================================================== --}}

        <div class="sidebar-brand">

            <div class="brand-title">
                PARFUM STORE
            </div>

            <div class="brand-subtitle">
                Administrator Panel
            </div>

        </div>


        {{-- =================================================
             MENU NAVIGASI
        ================================================== --}}

        <nav class="sidebar-menu">


            {{-- DASHBOARD --}}

            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                Dashboard

            </a>


            {{-- LAPORAN --}}

            <a href="{{ route('admin.reports.index') }}"
               class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">

                Laporan

            </a>


            {{-- KATEGORI --}}

            <a href="{{ route('categories.index') }}"
               class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">

                Kategori

            </a>


            {{-- MEREK --}}

            <a href="{{ route('brands.index') }}"
               class="{{ request()->routeIs('brands.*') ? 'active' : '' }}">

                Merek

            </a>


            {{-- PRODUK --}}

            <a href="{{ route('products.index') }}"
               class="{{ request()->routeIs('products.*') ? 'active' : '' }}">

                Produk

            </a>


            {{-- PESANAN --}}

            <a href="{{ route('orders.index') }}"
               class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">

                Pesanan

            </a>


            {{-- CUSTOMER --}}

            <a href="{{ route('customers.index') }}"
               class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">

                Customer

            </a>


            {{-- CHAT ADMIN --}}

            <a href="{{ route('admin.chat.index') }}"
               class="{{ request()->routeIs('admin.chat.*') ? 'active' : '' }}">

                Chat

            </a>


        </nav>


        {{-- =================================================
             BAGIAN BAWAH SIDEBAR
        ================================================== --}}

        <div class="sidebar-bottom">


            {{-- =================================================
                 AKUN ADMIN
            ================================================== --}}

            <div class="account-box">

                <div class="account-info">

                    <div class="account-name">

                        @auth

                            {{ auth()->user()->name }}

                        @else

                            Administrator

                        @endauth

                    </div>


                    <div class="account-role">

                        Administrator

                    </div>

                </div>

            </div>


            {{-- =================================================
                 LOGOUT
            ================================================== --}}

            <form
                action="{{ route('logout') }}"
                method="POST"
                class="logout-form"
            >

                @csrf

                <button
                    type="submit"
                    class="logout-button"
                    onclick="return confirm('Apakah Anda yakin ingin logout?')"
                >

                    Logout

                </button>

            </form>


        </div>


    </aside>


    {{-- =====================================================
         MAIN CONTENT
    ====================================================== --}}

    <main class="main-content">


        {{-- =================================================
             SUCCESS
        ================================================== --}}

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif


        {{-- =================================================
             ERROR
        ================================================== --}}

        @if(session('error'))

            <div class="alert alert-error">

                {{ session('error') }}

            </div>

        @endif


        {{-- =================================================
             VALIDATION ERROR
        ================================================== --}}

        @if($errors->any())

            <div class="alert alert-error">

                <strong>
                    Terdapat kesalahan:
                </strong>

                <ul style="margin: 8px 0 0 20px;">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =================================================
             CONTENT HALAMAN
        ================================================== --}}

        @yield('content')


    </main>


</body>

</html>