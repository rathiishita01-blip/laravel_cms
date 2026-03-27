<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Console | My Portfolio</title>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="{{ url('app.css') }}">

    <script src="{{ url('app.js') }}"></script>

    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.min.css">

<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>

    <style>
        body {
            background-color: #f5f7fa;
        }

        .topbar {
            background: #1f2937;
            color: #fff;
        }

        .topbar a {
            color: #d1d5db;
            text-decoration: none;
            margin-left: 15px;
        }

        .topbar a:hover {
            color: #fff;
        }

        .brand {
            font-weight: 600;
            font-size: 20px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .alert {
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
        }
    </style>
</head>

<body>

    <!-- Top Navigation -->
    <div class="topbar w3-padding">
        <div class="container w3-flex w3-justify-between w3-align-center">

            <div class="brand">Admin Console</div>

            <div>
                @if (Auth::check())
                    <span style="margin-right:10px;">
                         {{ auth()->user()->first }} {{ auth()->user()->last }}
                    </span>

                    <a href="/console/dashboard">Dashboard</a>
                    <a href="/">View Site</a>
                    <a href="/console/logout" class="w3-text-red">Logout</a>
                @else
                    <a href="/">Return to Website</a>
                @endif
            </div>

        </div>
    </div>

    <!-- Content Wrapper -->
    <div class="container">

        <!-- Flash Message -->
        @if (session()->has('message'))
            <div class="alert alert-error">
                {{ session()->get('message') }}
            </div>
        @endif

        <!-- Page Content -->
        <div class="card">
            @yield('content')
        </div>

    </div>

    <script>
    $(document).ready(function () {
        $('.datatable').each(function () {
            new DataTable(this, {
                pageLength: 10,
                responsive: true
            });
        });
    });
</script>

</body>
</html>