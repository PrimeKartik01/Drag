@extends('layouts.admin')

@section('title', 'Edit Builder')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
        <x-icons.users class="w-4 h-4 text-gray-400" />
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <a href="{{ route('builder.index') }}" class="hover:text-gray-700 transition-colors">Builders</a>
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <span class="text-gray-900">Edit</span>
    </div>
@endsection

@section('content')

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Edit Builder</h1>
                <p class="mt-1 text-sm text-gray-500">Update builder details for your real estate system.</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8">

                <form action="{{ route('builder.update', $builder->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">

                    @csrf
                    @method('patch')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Builder Logo</label>

                        @if ($builder->photo)
                            <div class="py-4">
                                <p class="text-xs text-gray-400 mb-2">Current Logo</p>
                                <img src="{{ asset('storage/' . $builder->photo) }}"
                                    class="w-20 h-20 rounded-xl object-cover border">
                            </div>
                        @endif

                        <input type="file" name="photo"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">

                        @error('photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Builder Name</label>

                            <input type="text" name="name" value="{{ old('name', $builder->name) }}"
                                placeholder="Enter builder name"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">

                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">RERA Number</label>

                            <input type="text" name="rera_no" value="{{ old('rera_no', $builder->rera_no) }}"
                                placeholder="Enter RERA number"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">

                            @error('rera_no')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Description</label>

                            <textarea name="description" rows="5" placeholder="Enter builder description"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">{{ old('description', $builder->description) }}</textarea>

                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>


                    <div class="flex flex-col sm:flex-row gap-3 pt-2">

                        <button type="submit"
                            class="flex-1 bg-indigo-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors">
                            Update Builder
                        </button>

                        <a href="{{ route('builder.index') }}"
                            class="flex-1 border border-gray-200 text-gray-600 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-50 text-center">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection
