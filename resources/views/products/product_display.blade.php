
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
    <style>
        .product-card {
            width: 300px;
            margin-bottom: 20px;
            position: relative;
        }
        .product-image {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            cursor: pointer;
        }
    </style>
<body>
    <div class="container">
        <h1>Products</h1>
        <div id="products-container" class="row"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('js/display.js') }}"></script>
</body>
</html>
