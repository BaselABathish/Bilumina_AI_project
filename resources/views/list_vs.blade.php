<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vector stores
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (empty($vs))
                        <p class="text-gray-600">No Vector stores found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company id</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($vs as $s)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $s['id'] }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $s['name'] ?: '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            {{ data_get($s, 'metadata.companyId', '-') }}
                                        </td>


                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            {{ \Carbon\Carbon::createFromTimestamp($s['created_at'])->toDayDateTimeString() }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
