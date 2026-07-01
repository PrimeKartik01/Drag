@extends('layouts.admin')

@section('title', 'Create Township')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
        <x-icons.building class="w-4 h-4 text-gray-400" />
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <a href="{{ route('township.index') }}" class="hover:text-gray-700">Townships</a>
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <span class="text-gray-900">Create</span>
    </div>
@endsection

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto">

            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Add Township</h1>
                <p class="mt-1 text-sm text-gray-500">Create a new township for your real estate system.</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8">

                <form action="{{ route('township.store') }}" method="POST" class="space-y-5">

                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">


                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Builder</label>

                            <select name="builder_id"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                                <option value="">Select Builder</option>

                                @foreach ($builders as $id => $name)
                                    <option value="{{ $id }}" {{ old('builder_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('builder_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                        </div>



                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">City</label>

                            <select name="city_id"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                                <option value="">Select City</option>

                                @foreach ($cities as $id => $name)
                                    <option value="{{ $id }}" {{ old('city_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('city_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                        </div>



                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Township Name</label>

                            <input type="text" name="name" value="{{ old('name') }}"
                                placeholder="Enter township name"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                        </div>



                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Location</label>

                            <input type="text" name="location" value="{{ old('location') }}" placeholder="Sector / Area"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                            @error('location')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                        </div>



                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">RERA Number</label>

                            <input type="text" name="rera_no" value="{{ old('rera_no') }}" placeholder="Optional"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                            @error('rera_no')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                        </div>



                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>

                            <select name="status"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">

                                <option value="1">Active</option>
                                <option value="0">Inactive</option>

                            </select>

                        </div>



                        <div class="sm:col-span-2">

                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Description</label>

                            <textarea name="description" rows="4"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>

                        </div>


                    </div>


                    <div class="flex flex-col sm:flex-row gap-3 pt-2">

                        <button
                            class="flex-1 bg-indigo-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700">
                            Create Township
                        </button>

                        <a href="{{ route('township.index') }}"
                            class="flex-1 border border-gray-200 text-gray-600 py-2.5 rounded-xl text-sm font-semibold text-center hover:bg-gray-50">
                            Cancel
                        </a>

                    </div>


                </form>

            </div>

        </div>

    </div>
@endsection
