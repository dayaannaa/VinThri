<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IEA=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

<body style="overflow-x: hidden; background-color: #FEFAE0;">
    @include('layouts.header')
    {{-- <div class="row gx-5 align-items-center">
        <div class="col-xxl-5">
            <div class="body-text" style="margin-top: 160px;">
                VINTAGE <br> TREASURES AND <br> THRIFT FINDS
            </div>
            <p style="margin-left: 60px; font-family: Poppins, sans-serif; font-weight: 300; margin-top: 20px;">
                Browse through our diverse range of meticulously thrifted garments, <br>
                designed to bring out your individuality and cater to your sense of <br>
                style.
            </p>
            <a href="{{ url('/products/display') }}" class="button mb-20">Thrift Now!</a>

            <div class="container" style="margin-left: 47px; margin-top: 30px; margin-bottom: 30px;">
                <div id="products-container" class="row"></div>
            </div>
        </div>
        <div class="col-xxl-7">
            <img src="http://127.0.0.1:8000/storage/images/bag1.jpg"  alt="..." width="100px" height="100px">
        </div>
    </div> --}}
    <div class="row gx-5 align-items-center ml-2">
        <div class="col-xxl-5">
            <div class="text-start text-xxl-start">
                <div class="body-text" style="margin-top: 157px;">
                    <h1 class="display-3 fw-bolder mb-6">
                        VINTAGE <br> TREASURES AND <br> THRIFT FINDS
                    </h1>
                    <p style="font-size:18px ; font-family: Poppins, sans-serif; font-weight: 300;">
                        Browse through our diverse range of meticulously thrifted garments, <br>
                        designed to bring out your individuality and cater to your sense of <br>
                        style.
                    </p>
                </div>
                <a href="{{ url('/products/display') }}" class="button mb-20">Thrift Now!</a>

            </div>
        </div>
        <div class="col-xxl-7">
            <img src="http://127.0.0.1:8000/storage/images/bag1.jpg" alt="..." width="500px" height="500px"
                style="margin-left:50%">
        </div>
    </div>
</body>
<div
    style="background-color: #526143; border-radius: 10px; padding: 30px; display: flex; justify-content: center; align-items: center; margin: 0 15px; position: relative; top: -1px; z-index: 1;">
    <p style="font-family: 'Alfa Slab One', serif; color: #FEFAE0; font-size: 24px; margin: 0;">STAY UPTO DATE ABOUT OUR
        LATEST OFFERS</p>
</div>
<footer
    style="height: 120px; width: 100%; background-color: rgba(169, 179, 136, 0.5); margin-top: -50px; padding-top: 60px; position: relative; z-index: 0;">
    <div
        style="width: auto; height: 1px; background-color: rgba(185, 148, 112, 0.3); margin-left: 60px; margin-right: 60px; margin-top: 20px;">
    </div>
    <div
        style="text-align: left; padding: 10px; font-family: 'Poppins', sans-serif; color: #5F6F52; font-size: 10px; margin-left: 10px; margin-top: 5px;">
        VintThri © 2024, All Rights Reserved
    </div>
</footer>

</html>
