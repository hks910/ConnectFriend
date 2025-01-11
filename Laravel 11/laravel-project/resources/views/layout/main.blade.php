<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            flex-direction: column;
        }

        .content-container {
            flex: 1; /* Ensures this section grows to fill available space */
            padding: 30px;
            background-color: #f8f9fa;
        }

        footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
    </style>
    <title>Connect Friend</title>
</head>

<body>
    <div class="container-fluid m-0 p-0 w-100">
        @include('component.navbar')

        <div class="content-container">
            @yield('content')
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Connect Friend. All Rights Reserved.</p>
    </footer>
</body>

</html>
