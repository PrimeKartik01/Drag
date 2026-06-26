@extends('layouts.admin')

@section('title', 'Builders')

@section('content')

    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                <div>
                    <p class="text-xs font-bold tracking-widest uppercase text-indigo-600 mb-1">Builder Management</p>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Builder Directory</h1>
                    <p class="mt-1.5 text-sm text-gray-500">Manage all builders of your real estate system</p>
                </div>

                <div class="flex items-center gap-3">
                    <form action="{{ route('builder.bulkDelete') }}" method="POST" id="bulkDeleteForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="ids" id="bulkIds">

                        <button type="submit" onclick="return confirm('Are you sure want to delete selected builders?')"
                            class="px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm hover:bg-red-700">
                            Delete Selected
                        </button>
                    </form>

                    <a href="{{ route('builder.create') }}"
                        class="px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm hover:bg-indigo-700">
                        Add Builder
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">

                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-gray-900 text-gray-400 text-xs uppercase">
                                <th class="px-5 py-3.5">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th class="px-4 py-3.5 text-left">Builder</th>
                                <th class="px-4 py-3.5 text-left">RERA No</th>
                                <th class="px-4 py-3.5 text-left">Created</th>
                                <th class="px-5 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($builders as $builder)
                                <tr class="hover:bg-indigo-50/40">

                                    <td class="px-5 py-3.5">
                                        <input type="checkbox" value="{{ $builder->id }}" class="rowCheckbox">
                                    </td>

                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            @if ($builder->photo)
                                                <img src="{{ asset('storage/' . $builder->photo) }}"
                                                    class="w-10 h-10 rounded-xl object-cover">
                                            @else
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center">
                                                    <span
                                                        class="text-xs font-bold text-white">{{ strtoupper(substr($builder->name, 0, 2)) }}</span>
                                                </div>
                                            @endif

                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $builder->name }}</p>
                                                <p class="text-xs text-gray-400">{{ $builder->slug }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3.5 text-sm text-gray-500">
                                        {{ $builder->rera_no ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3.5 text-sm text-gray-500">
                                        {{ $builder->created_at->format('d M Y') }}
                                    </td>

                                    <td class="px-5 py-3.5">
                                        <div class="flex justify-end gap-2">

                                            <a href="{{ route('builder.show', $builder->id) }}"
                                                class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 text-xs">
                                                View
                                            </a>

                                            <a href="{{ route('builder.edit', $builder->id) }}"
                                                class="px-3 py-1.5 rounded-lg bg-green-50 text-green-600 text-xs">
                                                Edit
                                            </a>

                                            <form action="{{ route('builder.destroy', $builder->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button onclick="return confirm('Delete {{ $builder->name }}?')"
                                                    class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-xs">
                                                    Delete
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center py-20 text-gray-400">
                                        No builders found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

            @if ($builders->hasPages())
                <div class="mt-6 flex justify-end">
                    {{ $builders->links() }}
                </div>
            @endif

        </div>
    </div>

    <script>
        document.getElementById('selectAll').addEventListener('click', function() {
            document.querySelectorAll('.rowCheckbox').forEach(cb => cb.checked = this.checked);
        });

        document.getElementById('bulkDeleteForm').addEventListener('submit', function(e) {
            let ids = [];

            document.querySelectorAll('.rowCheckbox:checked').forEach(cb => {
                ids.push(cb.value);
            });

            if (ids.length === 0) {
                e.preventDefault();
                alert('Please select builders first');
                return;
            }

            document.getElementById('bulkIds').value = ids.join(',');
        });
    </script>

@endsection
