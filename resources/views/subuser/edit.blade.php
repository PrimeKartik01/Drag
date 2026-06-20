@extends('layouts.admin')

@section('title','Edit Sub User')

@section('breadcrumb')
<div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
    <x-icons.users class="w-4 h-4 text-gray-400" />
    <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
    <a href="{{ route('subuser.index') }}" class="hover:text-gray-700">Sub Users</a>
    <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
    <span class="text-gray-900">Edit</span>
</div>
@endsection

@section('content')

<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <div class="mb-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center">
                <span class="text-sm font-bold text-white">{{ strtoupper(substr($subuser->name,0,2)) }}</span>
            </div>

            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Edit Sub User</h1>
                <p class="text-sm text-gray-500">Updating record for <span class="font-semibold">{{ $subuser->name }}</span></p>
            </div>
        </div>


        @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8">

            <form action="{{ route('subuser.update',$subuser->id) }}" method="POST" class="space-y-5">

                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">


                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name</label>
                        <input type="text" name="name" value="{{ old('name',$subuser->name) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>


                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email',$subuser->email) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>


                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Phone Number</label>
                        <input type="tel" inputmode="numeric" name="phone" value="{{ old('phone',$subuser->phone) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>


                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">New Password <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="password" name="password" placeholder="Leave blank to keep current" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>


                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="Repeat password" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

{{-- 
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Role</label>
                        <select name="role" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="manager" {{ old('role',$subuser->role)=='manager'?'selected':'' }}>Manager</option>
                            <option value="agent" {{ old('role',$subuser->role)=='agent'?'selected':'' }}>Property Agent</option>
                            <option value="employee" {{ old('role',$subuser->role)=='employee'?'selected':'' }}>Employee</option>
                        </select>
                    </div>
--}}

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                        <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="active" {{ old('status',$subuser->status)=='active'?'selected':'' }}>Active</option>
                            <option value="inactive" {{ old('status',$subuser->status)=='inactive'?'selected':'' }}>Inactive</option>
                        </select>
                    </div> 


                </div>


                <div class="flex flex-col sm:flex-row gap-3 pt-2">

                    <button class="flex-1 bg-indigo-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700">
                        Save Changes
                    </button>

                    <a href="{{ route('subuser.index') }}" class="flex-1 border border-gray-200 text-gray-600 py-2.5 rounded-xl text-sm font-semibold text-center hover:bg-gray-50">
                        Cancel
                    </a>

                </div>


            </form>

        </div>

    </div>
</div>

@endsection