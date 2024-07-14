
<!DOCTYPE html>
<html>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.tailwindcss.com"></script>
            <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css');
        @import url('https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap');

        .card {
            background-color: #FEFAE0;
            border-radius: 20px;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-15px);
        }
    </style>
<body>
    @include('layouts.header')

    <div style="width: auto; height: 1px; background-color: rgba(185, 148, 112, 0.3); margin-left: 60px; margin-right: 60px;"> </div>
    <h1 style="margin-left: 60px; margin-top: 30px; margin-bottom: 20px; font-family: Poppins, sans-serif; color: #5F6F52; font-size: 14px;">Home > Shop</h1> <!-- temporary -->
    <p style="font-family: Poppins, sans-serif; font-weight: 700; font-size: 25px; margin-left: 60px; color: #5F6F52;">
        Products 
    </p>
    <div class="container" style="margin-left: 47px; margin-top: 20px;">
        <div id="products-container" class="row" style="margin-left: 2px;"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('js/display.js') }}"></script>
</body>
</html>