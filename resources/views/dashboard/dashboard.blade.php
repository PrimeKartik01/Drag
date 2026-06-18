@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
        <x-icons.home class="w-4 h-4 text-gray-400" />
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <span class="text-gray-900">Dashboard</span>
    </div>
@endsection


@section('content')
    <div class="px-4 py-4">
        <p>Dashboard</p>
    </div>
@endsection
