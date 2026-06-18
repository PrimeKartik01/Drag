<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Owner Login</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="login-page min-h-screen flex items-center justify-center px-4 relative">

    <div
        class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-8 text-white shadow-2xl">

        <!-- Logo -->
        <div class="flex justify-center mb-5">
            <div
                class="w-20 h-20 rounded-full bg-white/10 border border-white/30 flex items-center justify-center text-3xl">
                <i class="fa-solid fa-user-shield"></i>
            </div>
        </div>

        <!-- Heading -->
        <div class="text-center mb-5">
            <h1 class="text-4xl font-bold">Welcome Back</h1>
            <p class="text-white/60 mt-2">Login to your owner account</p>
        </div>

        <form action="{{ route('admin.login') }}" method="POST" class="space-y-3">

            @csrf

            <!-- Email -->
            <div>
                <div class="flex items-center border border-gray-500 rounded-xl px-4 py-3">
                    <i class="fa-regular fa-envelope text-gray-500"></i>

                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address"
                        autocomplete="off" class="w-full px-3 outline-none text-gray-400 bg-transparent" required>
                </div>
            </div>
  

            <!-- Password -->
            <div>
                <div class="flex items-center border border-gray-500 rounded-xl px-4 py-3">
                    <i class="fa-solid fa-lock text-gray-500"></i>

                    <input type="password" name="password" placeholder="Password" autocomplete="new-password"
                        class="w-full px-3 outline-none text-gray-200 bg-transparent" required>
                </div>
            </div>


            @if ($errors->any())
                <div class=" text-red-400 rounded-xl px-4 py-3 text-sm text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="text-right">
                <a href="{{ route('forgot.password') }}" class="text-sm text-white/70 hover:text-white transition">
                    Forgot Password?
                </a>
            </div>


            <!-- Button -->
            <button type="submit"
                class="w-full h-14 rounded-xl bg-white text-black font-semibold text-lg hover:bg-gray-200 transition">
                Sign In
            </button>

        </form>

    </div>

</body>

</html>
