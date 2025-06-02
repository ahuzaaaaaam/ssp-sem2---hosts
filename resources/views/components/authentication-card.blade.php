<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative">
    <!-- Background with reduced brightness -->
    <div class="absolute inset-0" style="background-image: url('https://cdn.pixabay.com/photo/2017/12/09/08/18/pizza-3007395_1280.jpg'); background-size: cover; background-position: center; filter: brightness(60%);"></div>

    <!-- Content with normal brightness -->
    <div class="relative z-10 w-full sm:max-w-md mt-4 px-8 py-8 bg-white shadow-xl overflow-hidden sm:rounded-xl border border-red-100">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Welcome to PizzApp</h2>
        {{ $slot }}
    </div>
    
    <div class="relative z-10 mt-6 text-center text-sm text-white">
        <p>© {{ date('Y') }} PizzApp. All rights reserved.</p>
    </div>
</div>
