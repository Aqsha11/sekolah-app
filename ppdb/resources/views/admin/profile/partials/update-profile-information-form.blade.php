<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Profile Information
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Update your account's profile information and email address.
        </p>
    </header>

    <form method="POST" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        {{-- NAME --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name"
                value="{{ old('name', $user->name) }}"
                class="mt-1 block w-full border rounded-lg p-2"
                required>
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- EMAIL --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email"
                value="{{ old('email', $user->email) }}"
                class="mt-1 block w-full border rounded-lg p-2"
                required>
            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- BUTTON --}}
        <div class="flex items-center gap-4">
            <button type="submit"
                class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700">
                Save
            </button>

            @if(session('success'))
                <p class="text-green-600 text-sm">
                    {{ session('success') }}
                </p>
            @endif
        </div>
    </form>
</section>