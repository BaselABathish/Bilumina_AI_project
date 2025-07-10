<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            AI API Interaction
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded p-6">
                <form id="dynamicForm" action="/submit" method="post">
                    @csrf

                    <!-- Hidden input to carry the JSON payload -->
                    <input type="hidden" name="json_payload" id="json_payload">

                    <!-- Type Dropdown -->
                    <div class="mb-4">
                        <label for="type" class="block font-medium text-sm text-gray-700">Type</label>
                        <select id="type" name="type" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                            <option value="">Select a type</option>
                            <option value="ADD_ASSISTANT">ADD_ASSISTANT</option>
                            <option value="DELETE_ASSISTANT">DELETE_ASSISTANT</option>
                            <option value="LIST_ASSISTANTS">LIST_ASSISTANTS</option>
                            <option value="ADD_VECTOR_STORE">ADD_VECTOR_STORE</option>
                            <option value="DELETE_VECTOR_STORE">DELETE_VECTOR_STORE</option>
                            <option value="LIST_VECTOR_STORES">LIST_VECTOR_STORES</option>
                        </select>
                    </div>

                    <!-- Core Fields -->
                    <div class="mb-4">
                        <label for="service" class="block font-medium text-sm text-gray-700">Service</label>
                        <select id="service" name="service" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                            <option value="">Select a service</option>
                            <option value="openai">openai</option>
                            <option value="vector">vector</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="companyId" class="block font-medium text-sm text-gray-700">Company ID</label>
                        <input type="text" id="companyId" name="companyId" class="mt-1 block w-full bg-gray-100 border-gray-300 rounded shadow-sm" value="{{ auth()->user()->company_id }}" readonly>
                    </div>

                    <div class="mb-6">
                        <label for="username" class="block font-medium text-sm text-gray-700">Username</label>
                        <input type="text" id="username" name="username" class="mt-1 block w-full bg-gray-100 border-gray-300 rounded shadow-sm" value="{{ auth()->user()->name }}" readonly>
                    </div>

                    <!-- Dynamic Fields -->
                    <div id="dynamicFields" class="space-y-4"></div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Dynamic Form JS -->
    <script>
        const typeField = document.getElementById('type');
        const dynamicFields = document.getElementById('dynamicFields');
        const form = document.getElementById('dynamicForm');

        typeField.addEventListener('change', renderFields);

        // Initialize fields on page load
        document.addEventListener('DOMContentLoaded', renderFields);

        function renderFields() {
            const type = typeField.value;
            dynamicFields.innerHTML = '';

            const createInput = (label, name, isTextarea = false) => {
                const inputId = `input_${name}`;
                return `
                    <div>
                        <label for="${inputId}" class="block text-sm font-medium text-gray-700">${label}</label>
                        ${isTextarea
                    ? `<textarea id="${inputId}" name="${name}" class="mt-1 block w-full border-gray-300 rounded shadow-sm" rows="3"></textarea>`
                    : `<input type="text" id="${inputId}" name="${name}" class="mt-1 block w-full border-gray-300 rounded shadow-sm">`
                }
                    </div>
                `;
            };

            if (type === 'ADD_ASSISTANT') {
                dynamicFields.innerHTML = [
                    createInput('Instructions', 'instructions', true),
                    createInput('Name', 'name'),
                    `<div>
                        <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                        <select name="model" id="input_model" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                            <option value="gpt-4">gpt-4</option>
                            <option value="gpt-3.5">gpt-3.5</option>
                        </select>
                    </div>`,
                    createInput('Description', 'description'),
                    createInput('Reasoning Effort', 'reasoning_effort'),
                    createInput('Response Format', 'response_format'),
                    createInput('Temperature', 'temperature'),
                    createInput('Tool Resources', 'tool_resources'),
                    createInput('Tools', 'tools'),
                    createInput('Top P', 'top_p'),
                ].join('');
            }
            else if (type === 'DELETE_ASSISTANT' || type === 'DELETE_VECTOR_STORE') {
                dynamicFields.innerHTML = createInput('Deletion ID', 'deletion_id');
            }
            else if (type === 'ADD_VECTOR_STORE') {
                dynamicFields.innerHTML = [
                    createInput('Name', 'name'),
                    createInput('Chunking Strategy', 'chunking_strategy'),
                    createInput('Expires After', 'expires_after'),
                    createInput('File IDs', 'file_ids'),
                    createInput('Metadata', 'metadata', true),
                ].join('');
            }
            // LIST_* types: no extra fields
        }
    </script>
</x-app-layout>
