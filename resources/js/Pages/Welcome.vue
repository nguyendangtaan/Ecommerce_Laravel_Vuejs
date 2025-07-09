<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

// Sample laptop data for demonstration
const featuredLaptops = [
    {
        id: 1,
        name: "MacBook Pro M2",
        price: "2,999",
        image: "https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400&h=300&fit=crop",
        category: "Apple",
        specs: "13-inch, 8GB RAM, 256GB SSD"
    },
    {
        id: 2,
        name: "Dell XPS 13",
        price: "1,299",
        image: "https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400&h=300&fit=crop",
        category: "Dell",
        specs: "13.4-inch, 16GB RAM, 512GB SSD"
    },
    {
        id: 3,
        name: "HP Spectre x360",
        price: "1,499",
        image: "https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=400&h=300&fit=crop",
        category: "HP",
        specs: "14-inch, 16GB RAM, 1TB SSD"
    },
    {
        id: 4,
        name: "Lenovo ThinkPad X1",
        price: "1,899",
        image: "https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=400&h=300&fit=crop",
        category: "Lenovo",
        specs: "14-inch, 16GB RAM, 512GB SSD"
    }
];

const categories = [
    { name: "Gaming Laptops", icon: "🎮", count: 24 },
    { name: "Business Laptops", icon: "💼", count: 18 },
    { name: "Student Laptops", icon: "📚", count: 15 },
    { name: "Apple MacBooks", icon: "🍎", count: 12 }
];
</script>

<template>
    <Head title="Laptop Store - Premium Laptops" />
    
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-blue-600">Laptop Store</h1>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <Link href="#" class="text-gray-700 hover:text-blue-600 transition-colors">Home</Link>
                    <Link href="#" class="text-gray-700 hover:text-blue-600 transition-colors">Laptops</Link>
                    <Link href="#" class="text-gray-700 hover:text-blue-600 transition-colors">Accessories</Link>
                    <Link href="#" class="text-gray-700 hover:text-blue-600 transition-colors">Support</Link>
                </nav>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <Link
                        v-if="canLogin && !$page.props.auth.user"
                        :href="route('login')"
                        class="text-gray-700 hover:text-blue-600 transition-colors"
                    >
                        Sign In
                    </Link>
                    <Link
                        v-if="canRegister && !$page.props.auth.user"
                        :href="route('register')"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        Sign Up
                    </Link>
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        Dashboard
                    </Link>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-6xl font-bold mb-6">
                        Find Your Perfect
                        <span class="text-yellow-300">Laptop</span>
                    </h1>
                    <p class="text-xl mb-8 text-blue-100">
                        Discover premium laptops for work, gaming, and creativity. 
                        Fast shipping and expert support included.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <Link
                            href="#featured"
                            class="bg-yellow-400 text-blue-900 px-8 py-3 rounded-lg font-semibold hover:bg-yellow-300 transition-colors text-center"
                        >
                            Shop Now
                        </Link>
                        <Link
                            href="#categories"
                            class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors text-center"
                        >
                            Browse Categories
                        </Link>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <img 
                        src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&h=400&fit=crop" 
                        alt="Premium Laptop"
                        class="rounded-lg shadow-2xl"
                    />
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="featured" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Laptops</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Handpicked premium laptops for every need. From gaming to business, 
                    we have the perfect machine for you.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div 
                    v-for="laptop in featuredLaptops" 
                    :key="laptop.id"
                    class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden"
                >
                    <img 
                        :src="laptop.image" 
                        :alt="laptop.name"
                        class="w-full h-48 object-cover"
                    />
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-blue-600 font-semibold">{{ laptop.category }}</span>
                            <span class="text-2xl font-bold text-gray-900">${{ laptop.price }}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ laptop.name }}</h3>
                        <p class="text-sm text-gray-600 mb-4">{{ laptop.specs }}</p>
                        <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section id="categories" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Shop by Category</h2>
                <p class="text-gray-600">
                    Find the perfect laptop for your specific needs
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div 
                    v-for="category in categories" 
                    :key="category.name"
                    class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6 text-center cursor-pointer"
                >
                    <div class="text-4xl mb-4">{{ category.icon }}</div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ category.name }}</h3>
                    <p class="text-gray-600">{{ category.count }} products</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Free Shipping</h3>
                    <p class="text-gray-600">Free shipping on all orders over $500</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">2-Year Warranty</h3>
                    <p class="text-gray-600">Extended warranty on all laptops</p>
                </div>

                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">24/7 Support</h3>
                    <p class="text-gray-600">Expert technical support available</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Laptop Store</h3>
                    <p class="text-gray-400">
                        Your trusted source for premium laptops and accessories.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><Link href="#" class="hover:text-white transition-colors">About Us</Link></li>
                        <li><Link href="#" class="hover:text-white transition-colors">Contact</Link></li>
                        <li><Link href="#" class="hover:text-white transition-colors">Support</Link></li>
                        <li><Link href="#" class="hover:text-white transition-colors">Blog</Link></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Categories</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><Link href="#" class="hover:text-white transition-colors">Gaming Laptops</Link></li>
                        <li><Link href="#" class="hover:text-white transition-colors">Business Laptops</Link></li>
                        <li><Link href="#" class="hover:text-white transition-colors">Student Laptops</Link></li>
                        <li><Link href="#" class="hover:text-white transition-colors">MacBooks</Link></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Contact Info</h4>
                    <div class="space-y-2 text-gray-400">
                        <p>📧 info@Laptop Store.com</p>
                        <p>📞 (555) 123-4567</p>
                        <p>📍 123 Tech Street, Digital City</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Laptop Store. All rights reserved. Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})</p>
            </div>
        </div>
    </footer>
</template>
