<!DOCTYPE html>
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
        #checkoutButton {
            border-radius: 40px;
        }
        #checkoutButton:hover {
            background-color: #FEFAE0; 
            color: #5F6F52; 
        }
        .btn.btn-outline-secondary {
            border-color: transparent; 
            border-width: 1px; 
            font-size: 15px;
        }

        .btn.btn-outline-secondary:hover {
            border-color: transparent; 
            border-width: 1px; 
            background-color: #5F6F52;
        }
    </style>
</head>
<body>
    @include('layouts.header')
    <div style="width: auto; height: 1px; background-color: rgba(185, 148, 112, 0.3); margin-left: 60px; margin-right: 60px;"> </div>
    <h1 style="margin-left: 60px; margin-top: 30px; margin-bottom: 20px; font-family: Poppins, sans-serif; color: #5F6F52; font-size: 14px;">Home > Cart</h1> <!-- temporary -->
    <h1 style="text-align: center; margin-top: 30px; margin-bottom: 10px; font-family: Alfa Slab One, serif; color: #5F6F52; font-size: 50px;">Your Cart</h1> <!-- temporary -->
   
    <div class="container" style="margin-top: 30px;">
    <div id="cartItems"></div>
        <!-- <div class="total">
            <p>Overall Total: $<span id="overallTotal">0.00</span></p>
        </div> -->

        <div class="card mb-4 mt-4" style="width: 1223px; margin-left: 143px; background-color: #5F6F52;">
          <div class="card-body p-4">
            <div class="float-end" >
                <div class="mb-0 me-5 d-flex align-items-center total">
                    <p class="small me-2" style="color: #FEFAE0; font-family: Poppins, serif; font-size: 15px;">Order total: ₱</p>
                    <span id="overallTotal" class="lead fw-normal" style="color: #FEFAE0; font-family: Poppins, serif; font-size: 15px;">0.00</span>
                </div>
            </div>
          </div>
        </div>

        <button id="checkoutButton" class="btn" style="background-color: #5F6F52; width: 300px; margin-left: 1063px; color: #FEFAE0">Checkout</button>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/carts.js') }}"></script>
</body>
</html>

