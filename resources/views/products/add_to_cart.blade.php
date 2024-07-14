<!DOCTYPE html>
<html>
<head>
    <title>Product Display</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        .product-image {
            width: 300px;
            height: auto;
            object-fit: cover;
        }

        .btn-primary:hover {
            background-color: #A9B388;
            color: #5F6F52;
        }

        .card {
            background-color: #FEFAE0;
            border-radius: 20px;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-15px);
        }

    </style>
</head>
<body>
    @include('layouts.header')
    <div style="width: auto; height: 1px; background-color: rgba(185, 148, 112, 0.3); margin-left: 60px; margin-right: 60px;"> </div>
    <h1 style="margin-left: 60px; margin-top: 30px; margin-bottom: 20px; font-family: Poppins, sans-serif; color: #5F6F52; font-size: 14px;">Home > Shop > Shirt</h1> <!-- temporary -->
        <div id="product-details-container" class="row"></div>
            <input type="hidden" id="customer_id">
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="{{ asset('js/addtocarts.js') }}"></script>
        </div>
            <p style="font-family: Alfa Slab One, serif; font-weight: 400; font-size: 25px;color: #5F6F52; text-align: center; margin-top: 60px;">
            You might also like
            </p>
            <div class="container" style="margin-left: 47px; margin-top: 30px;">
                <div id="products-container" class="row"></div>
            </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="{{ asset('js/display.js') }}"></script>
    </div>

</body>
</html>
