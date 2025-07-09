<template>
    <div>
        <Menu></Menu>
        <div class="container mx-auto p-6">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Checkout</h1>
                <p class="text-gray-600 text-lg">Complete your order and choose your payment method</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Order Summary -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h2>
                    
                    <div v-if="cart.length === 0" class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                        </svg>
                        <p class="text-gray-500">Your cart is empty</p>
                        <Link href="/products" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Continue Shopping
                        </Link>
                    </div>

                    <div v-else>
                        <!-- Cart Items -->
                        <div class="space-y-4 mb-6">
                            <div v-for="item in cart" :key="item.id" class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                <img :src="item.img_url" :alt="item.name" class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ item.name }}</h4>
                                    <p class="text-sm text-gray-600">Quantity: {{ item.quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">{{ (item.price * item.quantity).toFixed(2) }}</p>
                                    <button @click="removeFromCart(item.id)" class="text-red-600 hover:text-red-800 text-sm">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center text-lg font-semibold">
                                <span>Total:</span>
                                <span class="text-2xl text-blue-600">{{ total.toFixed(2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkout Form -->
                <div v-if="cart.length > 0" class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Shipping Information</h2>
                    
                    <form @submit.prevent="handleSubmit" class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <input 
                                type="text" 
                                v-model="form.name" 
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                placeholder="Enter your full name" 
                                required 
                            />
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input 
                                type="email" 
                                v-model="form.email" 
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                placeholder="Enter your email" 
                                required 
                            />
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                            <input 
                                type="tel" 
                                v-model="form.phone" 
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                placeholder="Enter your phone number" 
                                required 
                            />
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Shipping Address</label>
                            <textarea 
                                v-model="form.address" 
                                rows="3" 
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                placeholder="Enter your complete shipping address" 
                                required
                            ></textarea>
                        </div>

                        <!-- Payment Options -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Method</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-4">
                                    <input type="radio" id="cod" name="payment" value="cod" class="text-blue-600 focus:ring-blue-500">
                                    <label for="cod" class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span>Cash on Delivery</span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center space-x-4">
                                    <input type="radio" id="vnpay" name="payment" value="vnpay" class="text-blue-600 focus:ring-blue-500">
                                    <label for="vnpay" class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        <span>VNPAY Online Payment</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
                            <button 
                                type="submit" 
                                class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors font-semibold flex items-center justify-center"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Place Order
                            </button>
                            
                            <button 
                                type="button" 
                                @click="initiatePayment"
                                class="flex-1 bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition-colors font-semibold flex items-center justify-center"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Pay with VNPAY
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Empty Cart Message -->
                <div v-else class="lg:col-span-2 bg-white rounded-xl shadow-lg p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h3>
                    <p class="text-gray-500 mb-6">Add some products to your cart before proceeding to checkout.</p>
                    <Link href="/products" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        Continue Shopping
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Menu from '../Includes/Menu.vue';
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        Menu,
        Link
    },
    data() {
        return {
            cart: [],
            form: {
                name: '',
                phone: '',
                address: '',
                email: '',
            },
        };
    },
    computed: {
        total() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        }
    },
    mounted() {
        // Load cart from localStorage
        const savedCart = localStorage.getItem('cart');
        if (savedCart) {
            this.cart = JSON.parse(savedCart);
        }
        
        // Load saved shipping info
        this.loadShippingInfo();
    },
    methods: {
        async initiatePayment() {
            try {
                const response = await axios.post("/api/payment", {
                    amount: this.total,
                });

                if (response.data.payment_url) {
                    window.location.href = response.data.payment_url;
                } else {
                    alert("Failed to generate payment URL");
                }
            } catch (error) {
                console.error("Payment error:", error);
                alert("An error occurred during payment initialization.");
            }
        },

        async handleSubmit() {
            const orderData = {
                name: this.form.name,
                phone: this.form.phone,
                address: this.form.address,
                email: this.form.email,
                cart_items: this.cart,
            };

            try {
                const response = await axios.post('/api/orders', orderData);
                alert(response.data.message);

                // Save shipping info and clear cart
                localStorage.setItem('shipping', JSON.stringify(this.form));
                localStorage.removeItem('cart');
                this.cart = [];
                
                // Redirect to success page or show success message
                window.location.href = '/orders';
            } catch (error) {
                console.error('There was an error!', error);
                alert('There was an error placing your order.');
            }
        },

        saveShippingInfo() {
            localStorage.setItem('shipping', JSON.stringify(this.form));
        },

        loadShippingInfo() {
            const savedShipping = localStorage.getItem('shipping');
            if (savedShipping) {
                this.form = JSON.parse(savedShipping);
            }
        },

        removeFromCart(productId) {
            this.cart = this.cart.filter(item => item.id !== productId);
            localStorage.setItem('cart', JSON.stringify(this.cart));
        },
    }
}
</script>

<style scoped>
/* Custom styles for better form appearance */
input[type="radio"] {
    @apply w-4 h-4;
}

input[type="radio"]:checked {
    @apply bg-blue-600 border-blue-600;
}
</style>