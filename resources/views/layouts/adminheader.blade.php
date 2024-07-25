<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<<<<<<< HEAD
<body style="background-color: #FEFAE0; height: 950px;">
<div class="navbar" style="background-color: #FEFAE0;">
    <a class="btn btn-ghost text-xl" style="color: #B99470; font-family: Alfa Slab One, serif; font-weight: 300; font-size: 32px;" href="{{ url('/adminhome') }}">VINTHRI</a>
  <div class="flex-1 justify-center">
    <ul class="menu menu-horizontal rounded-box" style="background-color: #FEFAE0; color: #5F6F52; font-weight: 300; font-family: Poppins, sans-serif; font-size: 15px;">
        <li>
            <a class="tooltip tooltip-bottom" data-tip="Admins">
            <svg
            class="h-8 w-8" 
            style="color: #5F6F52";
            fill="none" viewBox="0 0 24 24" 
            stroke="currentColor">
                <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            </a>
        </li>
        <li>
            <a class="tooltip tooltip-bottom" data-tip="Products">
            <svg
            class="h-8 w-8" 
            style="color: #5F6F52";
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">
                <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2" 
                d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"/>
            </svg>
            </a>
        </li>
        <li>
            <a class="tooltip tooltip-bottom" data-tip="Suppliers">
            <svg 
            class="h-8 w-8"
            style="color: #5F6F52";
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">
                <path
                stroke-linecap="round"
                stroke-linejoin="round" 
                stroke-width="2"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            </a>
        </li>
        <li>
            <a class="tooltip tooltip-bottom" data-tip="Categories">
            <svg 
            class="h-8 w-8"  
            style="color: #5F6F52";
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor">
                <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            </a>
        </li>
        <li>
            <a class="tooltip tooltip-bottom" data-tip="Feedbacks">
            <svg 
            class="h-8 w-8"  
            style="color: #5F6F52";
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor">
                <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
            </svg>
            </a>
        </li>
        <li>
            <a class="tooltip tooltip-bottom" data-tip="Users">
            <svg 
            class="h-8 w-8"
            style="color: #5F6F52";
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor">
                <path
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            </a>
        </li>
    </ul>
  </div>
=======
>>>>>>> bb1d93b29b062ce5b3850aada2bd96f26c6514e3

<body style="background-color: #FEFAE0; height: 950px;">
    <div class="navbar" style="background-color: #FEFAE0;">
        <a class="btn btn-ghost text-xl"
            style="color: #B99470; font-family: Alfa Slab One, serif; font-weight: 300; font-size: 20px;"
            href="{{ url('/adminhome') }}">VinThri</a>
        <div class="flex-1 justify-center">
            <ul class="menu menu-horizontal rounded-box"
                style="color: #5F6F52; font-weight: 300; font-family: Poppins, sans-serif; font-size: 15px;">
                <li>
                    <a href="{{ url('/admins') }} " class="text-decoration-none">
                        <svg class="h-8 w-8" style="color: #5F6F52"; fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Admins
                    </a>
                </li>
                <li>
                    <a href="{{ url('/products') }}" class="text-decoration-none">
                        <svg class="h-8 w-8" style="color: #5F6F52"; fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                        </svg>
                        Products
                    </a>
                </li>
                <li>
                    <a class="text-decoration-none">
                        <svg class="h-8 w-8" style="color: #5F6F52"; fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Suppliers
                    </a>
                </li>
                <li>
                    <a class="text-decoration-none">
                        <svg class="h-8 w-8" style="color: #5F6F52"; fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Categories
                    </a>
                </li>
                <li>
                    <a class="text-decoration-none">
                        <svg class="h-8 w-8" style="color: #5F6F52"; fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                        Feedbacks
                    </a>
                </li>
                <li>
                    <a class="text-decoration-none">
                        <svg class="h-8 w-8" style="color: #5F6F52"; fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Users
                    </a>
                </li>
            </ul>
        </div>

        <div class="flex-none">
            <!-- <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
        <div class="indicator">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <span class="badge badge-sm indicator-item">8</span>
        </div>
      </div>
      <div
        tabindex="0"
        class="card card-compact dropdown-content bg-base-100 z-[1] mt-3 w-52 shadow"
        style="color: #5F6F52; background-color: #A9B388;">
        <div class="card-body">
          <span class="text-lg font-bold">8 Items</span>
          <span class="text-info">Subtotal: $999</span>
          <div class="card-actions">
            <button class="btn btn-primary btn-block">View cart</button>
          </div>
        </div>
      </div>
    </div> -->
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="Tailwind CSS Navbar component"
                            src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                    </div>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow"
                    style="color: #5F6F52; background-color: rgba(169, 179, 136, 0.3);">
                    <li>
                        <a class="justify-between"
                            style="color: #5F6F52; font-family: Poppins, sans-serif; font weight: 300;">
                            Profile
                        </a>
                    </li>
                    <li><a style="color: #5F6F52; font-family: Poppins, sans-serif; font weight: 300;">Settings</a>
                    </li>
                    <li><a style="color: #5F6F52; font-family: Poppins, sans-serif; font weight: 300;">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>
