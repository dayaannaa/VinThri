<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="{{ asset('js/auth.js') }}"></script>
</head>

<body style="background-color: #FEFAE0;">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8" style="background-color: #FEFAE0;">
                <h1 class="text-xl font-bold leading-tight tracking-tight md:text-2xl dark:text-white" style="color: #5F6F52;">
                    Sign in to your account
                </h1>
                <form id="login-form" class="space-y-4 md:space-y-6">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" style="color: #5F6F52;">Email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="name@gmail.com" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" style="color: #5F6F52;">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" style="background-color: #B99470;">Sign in</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400" style="text-align: center;">
                        Don’t have an account yet? <a href="#" class="font-medium text-primary-600 hover:underline dark:text-primary-500" id="open-signup-modal" style="color: #5F6F52;">Sign up</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

     <div id="signup-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8" style="background-color: #FEFAE0;">
                <h2 class="text-xl font-bold leading-tight tracking-tight md:text-2xl dark:text-white" style="color: #5F6F52;">
                    Create your account
                </h2>
                <form id="signup-form" class="space-y-4 md:space-y-6">
                    <div>
                        <label for="signup-first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" style="color: #5F6F52;">First Name</label>
                        <input type="text" name="first_name" id="signup-first_name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="John" required>
                    </div>
                    <div>
                        <label for="signup-last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" style="color: #5F6F52;">Last Name</label>
                        <input type="text" name="last_name" id="signup-last_name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Williams" required>
                    </div>
                    <div>
                        <label for="signup-address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" style="color: #5F6F52;">Address</label>
                        <input type="text" name="address" id="signup-address" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Upper Bicutan" required>
                    </div>
                    <div>
                        <label for="signup-email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" style="color: #5F6F52;">Email</label>
                        <input type="email" name="email" id="signup-email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="name@gmail.com" required>
                    </div>
                    <div>
                        <label for="signup-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" style="color: #5F6F52;">Password</label>
                        <input type="password" name="password" id="signup-password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" style="background-color: #B99470;">Sign up</button>
                    <button type="button" id="close-signup-modal" class="flex w-full justify-center mt-4 rounded-md bg-gray-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">Cancel</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>