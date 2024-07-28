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
        <style>
            .navbar {
                background-color: #FEFAE0;
                padding: 20px 0; /* Increase padding for thickness */
            }

            .form{
                position: relative;
            }

            .form .bi-search{
                position: absolute;
                top: 7px;
                left: 20px;
                color: #5F6F52;
            }

            .form span{
                position: absolute;
                right: 17px;
                top: 13px;
                padding: 2px;
            }

            .left-pan{
                padding-left: 7px;
            }

            .left-pan i{
                padding-left: 10px;
            }

            .nav-link:hover {
                color: #A9B388;
            }

            .form-input{
                height: 55px;
                text-indent: 33px;
                border-radius: 25px;
                background-color: rgba(169, 179, 136, 0.4);
            }

            .form-input:focus{
                background-color: rgba(169, 179, 136, 0.6);
                box-shadow: none;
                border: none;
            }

            .form-input::placeholder {
                font-family: "Poppins", sans-serif;
                font-weight: 400;
                font-style: normal;
                color: #5F6F52;
            }

            .cart-icon {
                padding-top: 10px;
            }

            .nav-link {
                font-family: "Poppins", sans-serif;
                font-weight: 400;
                font-style: normal;
            }

            .body-text {
                font-family: "Alfa Slab One", serif;
                font-size: 50px;
                font-weight: 350;
                font-style: normal;
                text-align: left;
                margin-top: 100px;
                margin-left: 60px;  
                color: #5F6F52;
            }

            .button {
                display: inline-block;
                background-color: #B99470;
                color: white;
                text-align: center;
                padding: 10px 50px;
                margin-left: 60px;
                margin-top: 40px;
                border-radius: 30px;
                text-decoration: none;
                font-size: 16px;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .button:hover {
                background-color: #FEFAE0;
            }

            .btn {
                background-color: #5F6F52;
                color: #FEFAE0;
                font-family: 'Poppins', sans-serif;
                border-color: #5F6F52;
            }

            .btn:hover {
                background-color: #FEFAE0;
                color: #5F6F52;
                border-color: #B99470;
            }
            /* Ensure the search icon library is loaded */
            @import url('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css');
            @import url('https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap');
        </style>
        <body style="background-color: #FEFAE0;">
            <div id="preloder">
                <div class="loader"></div>
            </div>
            <div>
                <nav class="navbar navbar-light" style="background-color:#FEFAE0;">
                    <div class="container-fluid d-flex align-items-center ml-5">
                        <a class="navbar-brand" style="color:#B99470; font-weight: 350; font-family: Alfa Slab One, serif; font-size: 32px;" href="{{ url('/home') }}">
                            VINTHRI</a>
                        <div class="d-flex flex-grow-1 align-items-center">
                            <ul class="navbar-nav d-flex flex-row mb-2 mb-lg-0 ms-3">
                                <li class="nav-item ms-3 ml-4">
                                    <a class="nav-link" style="color:#5F6F52;" href="{{ url('/products/display') }}">Shop</a>
                                </li>
                                <li class="nav-item ms-3 ml-4">
                                    <a class="nav-link" style="color:#5F6F52;" href="#">Reviews
                                    </a>
                                </li>
                                <li class="nav-item ms-3 ml-4">
                                    <a class="nav-link" style="color:#5F6F52;" href="#">About</a>
                                </li>
                            </ul>
                            <div class="form d-flex ms-3 flex-grow-1 position-relative ml-5">
                                <i class="bi bi-search"></i>
                                <input type="text" class="form-control form-input" placeholder="Search for products..." style="flex-grow: 1; max-width: 800px; max-height: 40px;">
                            </div>
                            <ul class="navbar-nav d-flex flex-row ms-auto mb-2 mb-lg-0">
                                <li class="nav-item ms-3">
                                <button class="btn" id="login"> 
                                    Sign In
                                </button>                                
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <script>
            document.getElementById("login").onclick = function () { 
                location.href = "{{ url('/login') }}"; 
            }; 
        </script>

        </body>
    </html>
