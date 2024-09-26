<!DOCTYPE html>
<html>
<head>
    <title>Product App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('products.index') }}">Home</a>
        </div>
    </nav>

    <div class="py-4">
        <div class="container">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Product App. All rights reserved. | <a href="#" class="footer-link">Privacy Policy</a></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</body>
</html>
