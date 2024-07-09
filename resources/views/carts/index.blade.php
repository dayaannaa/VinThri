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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>/
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
    <div class="container">
        <h1>Cart List</h1>
        <div id="cartItems">
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




