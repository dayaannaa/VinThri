 <!DOCTYPE html>
<html>
<head>
    <title>Cart List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>/
        .card-body {
            padding: 10px;
        }
        .card-img {
            max-width: 100px;
            max-height: 100px;
        }
                .total {
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cart List</h1>
        <div id="cartItems">
        </div>
        <div class="total">
            <p>Total Quantity: <span id="totalQuantity">0</span></p>
            <p>Overall Total: $<span id="overallTotal">0.00</span></p>
        </div>
        <button id="checkoutButton" class="btn btn-primary">Checkout</button>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/carts.js') }}"></script>
</body>
</html>

{{-- <!DOCTYPE html>
<html>
<head>
    <title>Cart List</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        .card-body {
            padding: 10px;
        }
        .card-img {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>
    @include('layouts.header')
    <div style="width: auto; height: 1px; background-color: rgba(185, 148, 112, 0.3); margin-left: 60px; margin-right: 60px;"> </div>
    <h1 style="margin-left: 60px; margin-top: 30px; margin-bottom: 20px; font-family: Poppins, sans-serif; color: #5F6F52; font-size: 14px;">Home > Cart</h1> <!-- temporary -->
    <h1 style="margin-left: 80px; margin-top: 30px; margin-bottom: 10px; font-family: Alfa Slab One, serif; color: #5F6F52; font-size: 24px;">Your Cart</h1> <!-- temporary -->
    <div class="container" style="margin-left: 60px; margin-top: 20px;">
    <div id="cartItems" style="align-items: center;">
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/carts.js') }}"></script>
</body>
</html> --}}


{{-- <!DOCTYPE html>
<html>
<head>
    <title>Cart List</title>
    <link rel="stylesheet" href="https://maxcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card-body {
            padding: 10px;
        }
        .card-img {
            max-width: 100px;
            max-height: 100px;
        }
        .total {
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cart List</h1>
        <div id="cartItems"></div>
        <div class="total">
            <p>Overall Total: $<span id="overallTotal">0.00</span></p>
        </div>
        <button id="checkoutButton" class="btn btn-primary">Checkout</button>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/carts.js') }}"></script>
</body>
</html> --}}




