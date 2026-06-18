<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reset Password</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="login-page min-h-screen flex items-center justify-center px-4">


    <div
        class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-8 text-white shadow-2xl">


        <!-- Logo -->

        <div class="flex justify-center mb-5">

            <div
                class="w-20 h-20 rounded-full bg-white/10 border border-white/30 flex items-center justify-center text-3xl">

                <i class="fa-solid fa-lock"></i>

            </div>

        </div>



        <!-- Heading -->

        <div class="text-center mb-6">

            <h1 class="text-3xl font-bold">
                Reset Password
            </h1>


            <p class="text-white/60 mt-2">
                Create your new password
            </p>

        </div>





        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">

            @csrf


            <input type="hidden" name="token" value="{{ $token }}">



            <!-- Email -->

            <div class="flex items-center border border-gray-500 rounded-xl px-4 py-3">

                <i class="fa-regular fa-envelope text-gray-500"></i>


                <input type="email" name="email" value="{{ request('email') }}" placeholder="Email Address"
                    class="w-full px-3 outline-none text-gray-200 bg-transparent" required>


            </div>



            @error('email')
                <p class="text-red-400 text-sm">
                    {{ $message }}
                </p>
            @enderror






            <!-- New Password -->


            <div class="flex items-center border border-gray-500 rounded-xl px-4 py-3">


                <i class="fa-solid fa-lock text-gray-500"></i>


                <input type="password" name="password" placeholder="New Password"
                    class="w-full px-3 outline-none text-gray-200 bg-transparent" required>


            </div>





            <!-- Confirm Password -->


            <div class="flex items-center border border-gray-500 rounded-xl px-4 py-3">


                <i class="fa-solid fa-lock text-gray-500"></i>


                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                    class="w-full px-3 outline-none text-gray-200 bg-transparent" required>


            </div>




            @error('password')
                <p class="text-red-400 text-sm">
                    {{ $message }}
                </p>
            @enderror





            <!-- Button -->


            <button type="submit"
                class="w-full h-14 rounded-xl bg-white text-black font-semibold text-lg hover:bg-gray-200 transition">


                Update Password


            </button>



        </form>



    </div>



</body>

</html>
