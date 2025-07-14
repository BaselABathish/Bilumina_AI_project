<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Assistants
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (empty($assistants))
                        <p class="text-gray-600">No assistants found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructions</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($assistants as $asst)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $asst['id'] }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $asst['name'] ?: '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $asst['model'] }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900 truncate max-w-xs" title="{{ $asst['description'] }}">
                                            {{ Str::limit($asst['description'], 50) ?: '-' }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900 truncate max-w-xs" title="{{ $asst['instructions'] }}">
                                            {{ Str::limit($asst['instructions'], 50) ?: '-' }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            {{ \Carbon\Carbon::createFromTimestamp($asst['created_at'])->toDayDateTimeString() }}
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
