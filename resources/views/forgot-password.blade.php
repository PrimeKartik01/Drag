<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Forgot Password</title>

    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="login-page min-h-screen flex items-center justify-center px-4">

    <div
        class="w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-8 text-white shadow-2xl">


        <div class="text-center mb-6">

            <h1 class="text-3xl font-bold">
                Forgot Password
            </h1>

            <p class="text-white/60 mt-2">
                Enter your email to receive password reset link
            </p>

        </div>



        <form action="{{ route('forgot.password.send') }}" method="POST" class="space-y-4">

            @csrf


            <div class="flex items-center border border-gray-500 rounded-xl px-4 py-3">

                <i class="fa-regular fa-envelope text-gray-500"></i>

                <input type="email" name="email" placeholder="Email Address"
                    class="w-full px-3 outline-none text-gray-200 bg-transparent" required>

            </div>


            @error('email')
                <p class="text-red-400 text-sm">
                    {{ $message }}
                </p>
            @enderror



            @if (session('success'))
                <p class="text-green-400 text-sm text-center">
                    {{ session('success') }}
                </p>
            @endif



            <button type="submit"
                class="w-full h-14 rounded-xl bg-white text-black font-semibold text-lg hover:bg-gray-200 transition">

                Send Reset Link

            </button>


        </form>


        <div class="text-center mt-5">

            <a href="{{ route('admin.login') }}" class="text-white/70 hover:text-white">
                Back to Login
            </a>

        </div>


    </div>


</body>

</html>
