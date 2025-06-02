<!-- Footer that exactly matches the legacy version -->
<footer class="bg-gray-900 text-gray-300 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-lg font-bold text-white">About PizzApp</h3>
                <p>Delivering happiness with our delicious pizzas made from the freshest ingredients. Join us to taste perfection!</p>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Quick Links</h3>
                <ul>
                    <li><a href="{{ route('products.index') }}" class="hover:text-white">Menu</a></li>
                    <li><a href="{{ route('customize.index') }}" class="hover:text-white">Customize Pizza</a></li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-white">Cart</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Contact</h3>
                <p>123 Pizza Street, New York, NY 10001</p>
                <p>Phone: +1 (123) 456-7890</p>
                <p>Email: support@pizzapp.com</p>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Opening Hours</h3>
                <p>Mon-Fri: 10:00 AM - 10:00 PM</p>
                <p>Sat-Sun: 11:00 AM - 11:00 PM</p>
            </div>
        </div>
        <div class="mt-8 text-center border-t border-gray-700 pt-4">
            <p>&copy; {{ date('Y') }} PizzApp. All rights reserved.</p>
        </div>
    </div>
</footer>
