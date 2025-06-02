<style>
    .footer-dark {
        background-color: #1a202c;
        color: #cbd5e0;
        padding: 3rem 0;
    }
    .footer-container {
        max-width: 80rem;
        margin: 0 auto;
        padding: 0 1rem;
    }
    .footer-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 2rem;
    }
    @media (min-width: 768px) {
        .footer-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    .footer-heading {
        font-size: 1.125rem;
        font-weight: 700;
        color: white;
        margin-bottom: 1rem;
    }
    .footer-text {
        margin-bottom: 0.5rem;
    }
    .footer-link {
        color: #cbd5e0;
        text-decoration: none;
    }
    .footer-link:hover {
        color: white;
    }
    .footer-divider {
        border-top: 1px solid #4a5568;
        margin-top: 2rem;
        padding-top: 1rem;
    }
</style>

<footer class="footer-dark">
    <div class="footer-container">
        <div class="footer-grid">
            <div>
                <h3 class="footer-heading">About PizzApp</h3>
                <p class="footer-text">Delivering happiness with our delicious pizzas made from the freshest ingredients. Join us to taste perfection!</p>
            </div>
            <div>
                <h3 class="footer-heading">Quick Links</h3>
                <ul>
                    <li class="footer-text"><a href="{{ route('products.index') }}" class="footer-link">Menu</a></li>
                    <li class="footer-text"><a href="{{ route('customize.index') }}" class="footer-link">Customize Pizza</a></li>
                    <li class="footer-text"><a href="{{ route('cart.index') }}" class="footer-link">Cart</a></li>
                </ul>
            </div>
            <div>
                <h3 class="footer-heading">Contact</h3>
                <p class="footer-text">123 Pizza Street, New York, NY 10001</p>
                <p class="footer-text">Phone: +1 (123) 456-7890</p>
                <p class="footer-text">Email: support@pizzapp.com</p>
            </div>
            <div>
                <h3 class="footer-heading">Opening Hours</h3>
                <p class="footer-text">Mon-Fri: 10:00 AM - 10:00 PM</p>
                <p class="footer-text">Sat-Sun: 11:00 AM - 11:00 PM</p>
            </div>
        </div>
        <div class="footer-divider text-center">
            <p class="footer-text">&copy; {{ date('Y') }} PizzApp. All rights reserved.</p>
        </div>
    </div>
</footer>
