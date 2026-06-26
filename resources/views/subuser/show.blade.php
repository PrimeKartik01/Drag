@extends('layouts.admin')

@section('title', 'Builder Details')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
        <x-icons.users class="w-4 h-4 text-gray-400" />
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <a href="{{ route('builder.index') }}" class="hover:text-gray-700 transition-colors">
            Builders
        </a>
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <span class="text-gray-900">Details</span>
    </div>
@endsection


@section('content')

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto">


            <div class="flex justify-between items-end mb-6">


                <div>

                    <p class="text-xs font-bold tracking-widest uppercase text-indigo-600 mb-1">
                        Builder Details
                    </p>

                    <h1 class="text-3xl font-extrabold text-gray-900">
                        {{ $builder->name }}
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        View builder information
                    </p>

                </div>


                <a href="{{ route('builder.index') }}"
                    class="px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">

                    Back

                </a>


            </div>




            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8">


                <div class="flex flex-col sm:flex-row gap-6 items-center sm:items-start">


                    @if ($builder->photo)
                        <img src="{{ asset('storage/' . $builder->photo) }}"
                            class="w-32 h-32 rounded-2xl object-cover border border-gray-200">
                    @else
                        <div class="w-32 h-32 rounded-2xl bg-indigo-600 flex items-center justify-center">

                            <span class="text-3xl font-bold text-white">
                                {{ strtoupper(substr($builder->name, 0, 2)) }}
                            </span>

                        </div>
                    @endif



                    <div class="space-y-2 text-center sm:text-left">


                        <h2 class="text-2xl font-bold text-gray-900">
                            {{ $builder->name }}
                        </h2>


                        <p class="text-sm text-gray-500">
                            {{ $builder->slug }}
                        </p>


                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-600">

                            RERA : {{ $builder->rera_no ?? 'N/A' }}

                        </span>


                    </div>


                </div>




                <div class="border-t border-gray-100 my-8"></div>




                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">



                    <div>

                        <label class="text-xs font-bold uppercase text-gray-400">
                            Builder Name
                        </label>

                        <p class="mt-1 text-sm font-semibold text-gray-900">
                            {{ $builder->name }}
                        </p>

                    </div>




                    <div>

                        <label class="text-xs font-bold uppercase text-gray-400">
                            RERA Number
                        </label>

                        <p class="mt-1 text-sm font-semibold text-gray-900">
                            {{ $builder->rera_no ?? '-' }}
                        </p>

                    </div>




                    <div class="sm:col-span-2">

                        <label class="text-xs font-bold uppercase text-gray-400">
                            Description
                        </label>


                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">

                            {{ $builder->description ?? 'No description available' }}

                        </p>


                    </div>



                    <div>

                        <label class="text-xs font-bold uppercase text-gray-400">
                            Created At
                        </label>

                        <p class="mt-1 text-sm text-gray-700">
                            {{ $builder->created_at->format('d M Y, h:i A') }}
                        </p>

                    </div>



                    <div>

                        <label class="text-xs font-bold uppercase text-gray-400">
                            Updated At
                        </label>

                        <p class="mt-1 text-sm text-gray-700">
                            {{ $builder->updated_at->format('d M Y, h:i A') }}
                        </p>

                    </div>



                </div>



            </div>


        </div>

    </div>


@endsection
