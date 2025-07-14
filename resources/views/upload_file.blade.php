<form action="/upload_file" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <div class="mb-4">
        <label for="companyId" class="block font-medium text-sm text-gray-700">Company ID</label>
        <input type="text" id="companyId" name="companyId" class="mt-1 block w-full bg-gray-100 border-gray-300 rounded shadow-sm" value="{{ auth()->user()->company_id }}" readonly>
    </div>

    <div class="mb-6">
        <label for="username" class="block font-medium text-sm text-gray-700">Username</label>
        <input type="text" id="username" name="username" class="mt-1 block w-full bg-gray-100 border-gray-300 rounded shadow-sm" value="{{ auth()->user()->name }}" readonly>
    </div>
    <button type="submit">Upload & Embed</button>
</form>
