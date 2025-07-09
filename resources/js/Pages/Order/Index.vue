<template>
    <div>
        <Menu></Menu>
        <div class="container mx-auto p-6">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Order History</h1>
                <p class="text-gray-600 text-lg">Track your orders and view order details</p>
            </div>

            <!-- Orders List -->
            <div v-if="orders.length > 0" class="space-y-6">
                <div v-for="order in orders" :key="order.id" class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <!-- Order Header -->
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Order #{{ order.id }}</h3>
                                <p class="text-sm text-gray-600">{{ order.name }} • {{ order.email }}</p>
                            </div>
                            <div class="mt-2 sm:mt-0">
                                <button 
                                    @click="openCartModal(order.cart_items)"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-semibold flex items-center"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-1">Customer</h4>
                                <p class="text-gray-900">{{ order.name }}</p>
                                <p class="text-sm text-gray-600">{{ order.phone }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-1">Email</h4>
                                <p class="text-gray-900">{{ order.email }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-1">Shipping Address</h4>
                                <p class="text-gray-900 text-sm">{{ order.address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No orders yet</h3>
                <p class="text-gray-500 mb-6">Start shopping to see your order history here.</p>
                <Link href="/products" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                    Start Shopping
                </Link>
            </div>
        </div>

        <!-- Order Details Modal -->
        <div v-if="isModalOpen" @click.self="closeCartModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
                <div class="flex items-center justify-between p-6 border-b">
                    <h2 class="text-2xl font-bold text-gray-900">Order Details</h2>
                    <button @click="closeCartModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto max-h-[70vh]">
                    <div v-if="cartItems.length === 0" class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                        </svg>
                        <p class="text-gray-500">No items in this order</p>
                    </div>

                    <div v-else class="space-y-4">
                        <div v-for="item in cartItems" :key="item.id" class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            <img :src="item.img_url" :alt="item.name" class="w-16 h-16 object-cover rounded-lg">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">{{ item.name }}</h4>
                                <p class="text-sm text-gray-600">Quantity: {{ item.quantity }}</p>
                                <p class="text-sm text-gray-600">Price: ${{ item.price }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">${{ (item.price * item.quantity).toFixed(2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="cartItems.length > 0" class="p-6 border-t bg-gray-50">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">Total:</span>
                        <span class="text-2xl font-bold text-blue-600">${{ totalPrice }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Menu from '../Includes/Menu.vue';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        Menu,
        Link
    },
    data() {
        return {
            isModalOpen: false,
            orders: [],
            cartItems: [],
        };
    },
    computed: {
        totalPrice() {
            return this.cartItems.reduce((total, item) => {
                return total + (item.price * item.quantity);
            }, 0).toFixed(2);
        }
    },
    mounted() {
        this.fetchOrders();
    },
    methods: {
        async fetchOrders() {
            try {
                const response = await axios.get('/api/orders');
                this.orders = response.data;
            } catch (error) {
                console.error('Error fetching orders:', error);
                alert('There was an error fetching the orders.');
            }
        },
        openCartModal(cartItems) {
            this.cartItems = cartItems;
            this.isModalOpen = true;
        },
        closeCartModal() {
            this.isModalOpen = false;
        },
    }
}
</script>

<style scoped>
/* Custom styles for better modal appearance */
.modal-enter-active, .modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from, .modal-leave-to {
    opacity: 0;
}
</style>