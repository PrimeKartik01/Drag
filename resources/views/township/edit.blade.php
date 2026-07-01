@extends('layouts.admin')

@section('title', 'Edit Township')

@section('content')

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto">

            <div class="mb-6 flex items-center gap-4">

                <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center">
                    <span class="text-sm font-bold text-white">
                        {{ strtoupper(substr($township->name, 0, 2)) }}
                    </span>
                </div>

                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
                        Edit Township
                    </h1>

                    <p class="text-sm text-gray-500">
                        Updating record for <span class="font-semibold">{{ $township->name }}</span>
                    </p>

                </div>

            </div>


            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8">


                <form action="{{ route('township.update', $township->id) }}" method="POST" class="space-y-5">

                    @csrf
                    @method('PATCH')


                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">


                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Builder</label>

                            <select name="builder_id"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50">

                                @foreach ($builders as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('builder_id', $township->builder_id) == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>


                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">City</label>

                            <select name="city_id"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50">

                                @foreach ($cities as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('city_id', $township->city_id) == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>


                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Township Name</label>

                            <input type="text" name="name" value="{{ old('name', $township->name) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50">

                        </div>


                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Location</label>

                            <input type="text" name="location" value="{{ old('location', $township->location) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50">

                        </div>


                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">RERA Number</label>

                            <input type="text" name="rera_no" value="{{ old('rera_no', $township->rera_no) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50">

                        </div>


                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>

                            <select name="status"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50">

                                <option value="1" {{ $township->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $township->status == 0 ? 'selected' : '' }}>Inactive</option>

                            </select>

                        </div>


                        <div class="sm:col-span-2">

                            <textarea name="description" rows="4"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50">{{ old('description', $township->description) }}</textarea>

                        </div>


                    </div>


                    <div class="flex flex-col sm:flex-row gap-3 pt-2">

                        <button
                            class="flex-1 bg-indigo-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700">
                            Save Changes
                        </button>

                        <a href="{{ route('township.index') }}"
                            class="flex-1 border border-gray-200 text-gray-600 py-2.5 rounded-xl text-sm font-semibold text-center">
                            Cancel
                        </a>

                    </div>


                </form>


            </div>

        </div>

    </div>

@endsection
