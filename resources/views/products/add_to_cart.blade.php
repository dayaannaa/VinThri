<!DOCTYPE html>
<html>
<head>
    <title>Product Display</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .product-card {
            display: flex;
            margin-bottom: 20px;
        }
        .product-image {
            width: 300px;
            height: auto;
            max-height: 500px;
            object-fit: cover;
        }
        .image-selection {
            margin-right: 20px;
        }
        .image-selection input {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Product Details</h1>

        <p>Customer ID: <span id="customer-id"></span></p>
        <div id="product-details-container" class="row"></div>

        <input type="hidden" id="customer_id">

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control" style="width: 100px; margin-bottom: 10px;">

        <button id="addToCartBtn" class="btn btn-primary">Add to Cart</button>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="{{ asset('js/addtocarts.js') }}"></script>
    </div>
</body>
</html>
