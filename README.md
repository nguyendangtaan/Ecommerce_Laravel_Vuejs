Giới thiệu

Đây là dự án website thương mại điện tử (Ecommerce) được xây dựng với backend Laravel và frontend Vue.js. Dự án hỗ trợ các chức năng quản lý sản phẩm, danh mục, thương hiệu, đơn hàng, thanh toán, xác thực người dùng, và nhiều tính năng khác.

Tính năng chính

Đăng ký, đăng nhập, xác thực email người dùng

Quản lý sản phẩm, danh mục, thương hiệu (CRUD)

Quản lý đơn hàng, thanh toán (tích hợp VNPAY)

Quản lý hồ sơ người dùng

Giao diện hiện đại với Vue.js và Inertia.js

API RESTful cho các chức năng chính

Công nghệ sử dụng

Backend: Laravel 10+

Frontend: Vue.js 3, Inertia.js

Cơ sở dữ liệu: SQL Lite

Xác thực: Laravel Sanctum

Thanh toán: VNPAY (sandbox)

CSS: TailwindCSS, SASS

Build tool: Vite

Cài đặt

Yêu cầu

PHP >= 8.1

Composer

Node.js & npm

SQL Lite

Hướng dẫn cài đặt

Clone project:

    git clone <repo-url>

    cd Ecommerce_Laravel_Vuejs

Cài đặt backend:

    composer install

    cp .env.example .env

    php artisan key:generate

    # Cấu hình database trong .env

    php artisan migrate --seed

Cài đặt frontend:

    npm install

    npm run dev

Khởi động server:

    php artisan serve

Truy cập ứng dụng tại: http://localhost:8000