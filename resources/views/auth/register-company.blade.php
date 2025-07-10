<x-guest-layout>
    <h1 class="text-xl mb-4">Register a New Company</h1>

    <form method="POST" action="{{ route('company.register') }}">
        @csrf

        <div>
            <label for="name">Company Name</label>
            <input id="name" type="text" name="name" required autofocus />
        </div>

        <div class="mt-4">
            <button type="submit">Create Company</button>
        </div>
    </form>
</x-guest-layout>
