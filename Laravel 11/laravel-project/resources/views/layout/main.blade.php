<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css')}}">
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Custom styles */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        
        .navbar-custom {
            background-color: #343a40;
            color: white;
        }
        
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-nav .nav-link {
            color: #f8f9fa;
        }
        
        .navbar-custom .navbar-nav .nav-link:hover {
            color: #ffd700;
        }
        
        .content-container {
            min-height: 100vh;
            padding: 30px;
            background-color: #f8f9fa;
        }

        footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        
        .card-custom {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-custom:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .btn-primary-custom {
            background-color: #007bff;
            border: none;
        }

        .btn-primary-custom:hover {
            background-color: #0056b3;
        }

        .container-fluid {
            padding: 0;
            margin: 0;
        }
    </style>
    <title>Connect Friend</title>
</head>

<body>
    <div class="container-fluid m-0 p-0 w-100 h-100">
        @include('component.navbar')

        <div class="content-container">
            @yield('content')
        </div>

        {{-- @include('layout.footer') --}}
    </div>

    <footer>
        <p>&copy; 2025 Connect Friend. All Rights Reserved.</p>
    </footer>
</body>

</html>
