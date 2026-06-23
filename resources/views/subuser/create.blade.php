@extends('layouts.admin')

@section('title', 'Create Sub User')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
        <x-icons.users class="w-4 h-4 text-gray-400" />
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <a href="{{ route('subuser.index') }}" class="hover:text-gray-700 transition-colors">Sub Users</a>
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <span class="text-gray-900">Create</span>
    </div>
@endsection


@section('content')

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto">

            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Add Sub User</h1>
                <p class="mt-1 text-sm text-gray-500">Create a new user account for your real estate system.</p>
            </div>


            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8">

                <form action="{{ route('subuser.store') }}" method="POST" class="space-y-5">

                    @csrf


                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">


                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter user name"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Role</label>
                            <input type="text" name="role" value="{{ old('role') }}" placeholder="Enter user role"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">
                            @error('role')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="example@email.com"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Phone Number</label>
                            <input type="tel" inputmode="numeric" name="phone" value="{{ old('phone') }}"
                                placeholder="+91" maxlength="10"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>



                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>

                            <div class="relative">

                                <input id="password" type="password" name="password" placeholder="Create password"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-12 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">

                                <button type="button" onclick="togglePassword('password')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700">
                                    <i id="passwordIcon" class="fa-solid fa-eye"></i>
                                </button>

                            </div>

                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                        </div>



                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm Password</label>

                            <div class="relative">

                                <input id="confirm_password" type="password" name="password_confirmation"
                                    placeholder="Repeat password"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-12 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">

                                <button type="button" onclick="togglePassword('confirm_password')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700">
                                    <i id="confirm_passwordIcon" class="fa-solid fa-eye"></i>
                                </button>

                            </div>

                        </div>




                        {{-- <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Designation</label>
                            <input type="text" name="designation" value="{{ old('designation') }}"
                                placeholder="Property Manager"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">
                            @error('designation')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div> --}}




                        {{-- <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">User Role</label>

                            <select name="role"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                                <option value="">Select Role</option>
                                <option value="manager">Manager</option>
                                <option value="agent">Property Agent</option>
                                <option value="employee">Employee</option>

                            </select>

                            @error('role')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                        </div>
 --}}


                    </div>



                    <div class="flex flex-col sm:flex-row gap-3 pt-2">

                        <button type="submit"
                            class="flex-1 bg-indigo-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors">
                            Create Sub User
                        </button>


                        <a href="{{ route('subuser.index') }}"
                            class="flex-1 border border-gray-200 text-gray-600 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-50 text-center">
                            Cancel
                        </a>

                    </div>


                </form>

            </div>

        </div>

    </div>

    <script>
        function togglePassword(id) {

            let input = document.getElementById(id);
            let icon = document.getElementById(id + 'Icon');

            if (input.type === "password") {

                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');

            } else {

                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');

            }

        }
    </script>
@endsection
