<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IEA=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="">
            <meta name="author" content="">
            <title>@yield('title')</title>
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
            <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        </head>
        <body>
        @include('layouts.header')
                <div class="body-text">
                    VINTAGE <br> TREASURES AND <br> THRIFT FINDS
                </div>
                <p style="margin-left: 60px; font-family: Poppins, sans-serif; font-weight: 300; margin-top: 20px;">
                    Browse through our diverse range of meticulously thrifted garments, <br>
                    designed to bring out your individuality and cater to your sense of <br>
                    style.
                </p>
                <a href="{{ url('/products/display') }}" class="button mb-20">Shop Now</a>
                <div style="height: 70px; width:100%; background-color: #5F6F52;"></div>
                <p style="text-align: center; font-family: Alfa Slab One, serif; font-weight: 300; font-size: 40px; margin-top: 40px; color: #5F6F52;">
                    PRODUCTS 
                </p>
                <div class="container" style="margin-left: 47px; margin-top: 30px; margin-bottom: 30px;">
                    <div id="products-container" class="row"></div>
                </div>
                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="{{ asset('js/display.js') }}"></script>
            </div> 
        </body>
        <div style="background-color: #526143; border-radius: 10px; padding: 30px; display: flex; justify-content: center; align-items: center; margin: 0 15px; position: relative; top: -1px; z-index: 1;">
            <p style="font-family: 'Alfa Slab One', serif; color: #FEFAE0; font-size: 24px; margin: 0;">STAY UPTO DATE ABOUT OUR LATEST OFFERS</p>
        </div>
        <footer style="height: 120px; width: 100%; background-color: rgba(169, 179, 136, 0.5); margin-top: -50px; padding-top: 60px; position: relative; z-index: 0;">
            <div style="width: auto; height: 1px; background-color: rgba(185, 148, 112, 0.3); margin-left: 60px; margin-right: 60px; margin-top: 20px;"> </div>
            <div style="text-align: left; padding: 10px; font-family: 'Poppins', sans-serif; color: #5F6F52; font-size: 10px; margin-left: 10px; margin-top: 5px;">
                VintThri © 2024, All Rights Reserved
            </div>
        </footer>
    </html>
