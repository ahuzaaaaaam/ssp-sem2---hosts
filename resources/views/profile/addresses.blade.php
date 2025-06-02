<x-app-layout>
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('profile') }}" class="inline-flex items-center text-red-600 hover:text-red-800">
                <i class="fas fa-arrow-left mr-2"></i> Back to Profile
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">Manage Addresses</h1>
                <p class="text-sm text-gray-500 mt-1">Add, edit, or remove your shipping addresses</p>
            </div>

            <livewire:user-profile.address-management />
        </div>
    </div>
</x-app-layout>
