@extends('layouts.admin')

@section('title', 'Edit Sub User')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
        <x-icons.users class="w-4 h-4 text-gray-400" />
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <a href="{{ route('subuser.index') }}" class="hover:text-gray-700 transition-colors">
            Sub Users
        </a>
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <span class="text-gray-900">Edit</span>
    </div>
@endsection

@section('content')

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto">

            <div class="flex justify-between items-end mb-6">

                <div>

                    <p class="text-xs font-bold tracking-widest uppercase text-indigo-600 mb-1">
                        Sub User Management
                    </p>

                    <h1 class="text-3xl font-extrabold text-gray-900">
                        Edit Sub User
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Update sub user information
                    </p>

                </div>

                <a href="{{ route('subuser.index') }}"
                    class="px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">

                    Back

                </a>

            </div>


            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8">

                <form action="{{ route('subuser.update', $subuser) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PATCH')

                    <div class="flex flex-col sm:flex-row gap-6 items-center sm:items-start mb-8">

                        @if ($subuser->photo)
                            <img src="{{ asset('storage/' . $subuser->photo) }}"
                                class="w-32 h-32 rounded-2xl object-cover border border-gray-200 shadow">
                        @else
                            <div class="w-32 h-32 rounded-2xl bg-indigo-600 flex items-center justify-center shadow">

                                <span class="text-3xl font-bold text-white">
                                    {{ strtoupper(substr($subuser->name, 0, 2)) }}
                                </span>

                            </div>
                        @endif


                        <div class="space-y-3">

                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ $subuser->name }}
                            </h2>

                            <p class="text-sm text-gray-500">
                                {{ $subuser->email }}
                            </p>

                            <div class="flex flex-wrap gap-2">

                                <span
                                    class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-600">
                                    {{ $subuser->role?->name ?? 'No Role Assigned' }}
                                </span>

                                @if ($subuser->last_activity_at && $subuser->last_activity_at->gt(now()->subMinutes(5)))
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Online
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                        Offline
                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>


                    <div class="border-t border-gray-100 mb-8"></div>


                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        <div class="sm:col-span-2">

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Profile Photo
                            </label>

                            <input type="file" name="photo" accept="image/*"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                            @error('photo')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror

                        </div>


                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Full Name
                            </label>

                            <input type="text" name="name" value="{{ old('name', $subuser->name) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50">

                            @error('name')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror

                        </div>


                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address
                            </label>

                            <input type="email" name="email" value="{{ old('email', $subuser->email) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50">

                            @error('email')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror

                        </div>


                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Phone Number
                            </label>

                            <input type="text" name="phone" value="{{ old('phone', $subuser->phone) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50">

                            @error('phone')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror

                        </div>


                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Special ID
                            </label>

                            <input type="text" name="special_id" value="{{ old('special_id', $subuser->special_id) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50">

                            @error('special_id')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror

                        </div>
                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                New Password
                                <span class="text-gray-400 font-normal">(Optional)</span>
                            </label>

                            <input type="password" name="password" placeholder="Leave blank to keep current password"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50">

                            @error('password')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror

                        </div>


                        <div>

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirm Password
                            </label>

                            <input type="password" name="password_confirmation" placeholder="Confirm password"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50">

                        </div>


                        <div class="sm:col-span-2">

                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Role
                            </label>

                            <select name="role_id"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                                <option value="">Select Role</option>

                                @foreach ($roles as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('role_id', $subuser->role_id) == $id ? 'selected' : '' }}>

                                        {{ $name }}

                                    </option>
                                @endforeach

                            </select>

                            @error('role_id')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror

                        </div>


                        <div>

                            <label class="text-xs font-bold uppercase text-gray-400">
                                Created At
                            </label>

                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                {{ $subuser->created_at->format('d M Y, h:i A') }}
                            </p>

                        </div>


                        <div>

                            <label class="text-xs font-bold uppercase text-gray-400">
                                Last Updated
                            </label>

                            <p class="mt-2 text-sm font-semibold text-gray-900">
                                {{ $subuser->updated_at->format('d M Y, h:i A') }}
                            </p>

                        </div>

                    </div>


                    <div class="border-t border-gray-100 mt-8 pt-6">

                        <div class="flex flex-col sm:flex-row gap-3">

                            <button type="submit"
                                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl text-sm font-semibold transition">

                                Save Changes

                            </button>

                            <a href="{{ route('subuser.index') }}"
                                class="flex-1 border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 py-3 rounded-xl text-center text-sm font-semibold transition">

                                Cancel

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
