<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Menu from './Includes/Menu.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const stats = ref({
    totalProducts: 0,
    totalCategories: 0,
    totalBrands: 0,
    totalOrders: 0,
    totalRevenue: 0,
    recentOrders: [],
    topProducts: []
});

const loading = ref(true);

onMounted(async () => {
    await fetchDashboardStats();
});

const fetchDashboardStats = async () => {
    try {
        // Fetch all data in parallel
        const [productsRes, categoriesRes, brandsRes, ordersRes] = await Promise.all([
            axios.get('/api/products'),
            axios.get('/api/categories'),
            axios.get('/api/brands'),
            axios.get('/api/orders')
        ]);

        const products = productsRes.data;
        const categories = categoriesRes.data;
        const brands = brandsRes.data;
        const orders = ordersRes.data;

        // Calculate total revenue
        const totalRevenue = orders.reduce((sum, order) => {
            if (order.cart_items && Array.isArray(order.cart_items)) {
                return sum + order.cart_items.reduce((orderSum, item) => {
                    return orderSum + (item.price * item.quantity);
                }, 0);
            }
            return sum;
        }, 0);

        // Get recent orders (last 5)
        const recentOrders = orders.slice(-5).reverse();

        // Get top products (by quantity sold)
        const productSales = {};
        orders.forEach(order => {
            if (order.cart_items && Array.isArray(order.cart_items)) {
                order.cart_items.forEach(item => {
                    if (productSales[item.id]) {
                        productSales[item.id].quantity += item.quantity;
                        productSales[item.id].revenue += item.price * item.quantity;
                    } else {
                        productSales[item.id] = {
                            ...item,
                            quantity: item.quantity,
                            revenue: item.price * item.quantity
                        };
                    }
                });
            }
        });

        const topProducts = Object.values(productSales)
            .sort((a, b) => b.quantity - a.quantity)
            .slice(0, 5);

        stats.value = {
            totalProducts: products.length,
            totalCategories: categories.length,
            totalBrands: brands.length,
            totalOrders: orders.length,
            totalRevenue: totalRevenue,
            recentOrders: recentOrders,
            topProducts: topProducts
        };

        loading.value = false;
    } catch (error) {
        console.error('Error fetching dashboard stats:', error);
        loading.value = false;
    }
};
</script>

<template>
    <Head title="Dashboard" />
    <Menu></Menu>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Loading State -->
                <div v-if="loading" class="text-center py-12">
                    <div class="inline-flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-xl text-gray-600">Loading dashboard...</span>
                    </div>
                </div>

                <!-- Dashboard Content -->
                <div v-else class="space-y-8">
                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Total Products -->
                        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ stats.totalProducts }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Categories -->
                        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Categories</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ stats.totalCategories }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Brands -->
                        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-purple-100">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Brands</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ stats.totalBrands }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Orders -->
                        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-orange-100">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ stats.totalOrders }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue Card -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Total Revenue</p>
                                <p class="text-3xl font-bold">{{ stats.totalRevenue.toFixed(2) }}</p>
                                <p class="text-blue-100 text-sm mt-1">All time sales</p>
                            </div>
                            <div class="p-4 rounded-full bg-white bg-opacity-20">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Charts and Tables Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Recent Orders -->
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
                            </div>
                            <div class="p-6">
                                <div v-if="stats.recentOrders.length === 0" class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-gray-500">No orders yet</p>
                                </div>
                                <div v-else class="space-y-4">
                                    <div v-for="order in stats.recentOrders" :key="order.id" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ order.name }}</p>
                                            <p class="text-sm text-gray-600">{{ order.email }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-600">Order #{{ order.id }}</p>
                                            <p class="text-sm font-medium text-gray-900">
                                                ${{ order.cart_items ? order.cart_items.reduce((sum, item) => sum + (item.price * item.quantity), 0).toFixed(2) : '0.00' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Top Products -->
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Top Selling Products</h3>
                            </div>
                            <div class="p-6">
                                <div v-if="stats.topProducts.length === 0" class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <p class="text-gray-500">No sales data yet</p>
                                </div>
                                <div v-else class="space-y-4">
                                    <div v-for="(product, index) in stats.topProducts" :key="product.id" class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-blue-600 font-bold">{{ index + 1 }}</span>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-900">{{ product.name }}</p>
                                            <p class="text-sm text-gray-600">{{ product.quantity }} units sold</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-gray-900">{{ product.revenue.toFixed(2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="/products" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span class="font-medium text-gray-900">Add Product</span>
                            </a>
                            <a href="/orders" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="font-medium text-gray-900">View Orders</span>
                            </a>
                            <a href="/checkout" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                                <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                                </svg>
                                <span class="font-medium text-gray-900">Checkout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Custom styles for better appearance */
.border-l-4 {
    border-left-width: 4px;
}
</style>
