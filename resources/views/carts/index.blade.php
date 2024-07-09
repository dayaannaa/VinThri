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
</html>
