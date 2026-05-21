# VogueVista — Fashion E-Commerce

VogueVista is a full-featured fashion e-commerce web application built with Laravel. It includes an admin panel for store management and a customer-facing storefront for browsing and purchasing products.

---

## Tech Stack

- **Backend:** Laravel (PHP)
- **Frontend:** Blade Templates, Tailwind CSS
- **Database:** MySQL
- **Payment:** Cash on Delivery & QRIS

---

## Features

- Admin panel: manage products, categories, orders, home sliders, and payment settings
- Customer storefront: browse collections, wishlist, cart, checkout, and order tracking
- Authentication: register, sign in, and session management

---

## Admin Panel

### Sign In

Admin and customer authentication page. Enter your email and password to access the dashboard.

![Sign In](public/readme/admin-side/signin-page.png)

---

### Register

New user registration page. Customers fill in their full name, email, password, and confirm password to create an account.

![Register](public/readme/admin-side/register-page.png)

---

### Dashboard

The main admin overview page. Displays summary stats (total products, categories, orders, sliders), quick action buttons, and a recent products table.

![Dashboard](public/readme/admin-side/dashboard-admin-page.png)

---

### All Categories

Lists all product categories with their images and names. Each row has **Edit** and **Delete** action buttons. A **+ Add Category** button is available at the top right.

![All Categories](public/readme/admin-side/categories-page.png)

---

### Add Category

Form page to create a new product category. Fields: Name, Description, and Image upload.

![Add Category](public/readme/admin-side/add-category-page.png)

---

### All Products

Lists all store products in a table with columns for product name, description, price, stock status, and image. Each row has **Edit** and **Delete** actions.

![All Products](public/readme/admin-side/products-page.png)

---

### Add Product

Form page to add a new product. Fields: Category (dropdown), Name, Description, Price, Quantity, and Image upload.

![Add Product](public/readme/admin-side/add-product-page.png)

---

### View Product (Customer Side)

The product detail page seen by customers. Shows product image, name, category, price, stock availability, quantity selector, and buttons for **Add to Cart** and **Wishlist**.

![View Product](public/readme/admin-side/view-product-page.png)

---

### Orders

Lists all incoming customer orders with tracking number, customer info, payment method, status (In Progress / Delivered), and date. Each order has a **View** button.

![Orders](public/readme/admin-side/orders-list-page.png)

---

### Home Sliders

Manages the homepage carousel slides. Each slider entry shows an image, title, and description. Supports **Edit** and **Delete** per slide, plus **+ Add Slider**.

![Home Sliders](public/readme/admin-side/home-slider-page.png)

---

### Settings

Store payment settings page. Admin can upload a QRIS QR code image, set the merchant name, and optionally enter an NMID. Supported wallets include GoPay, OVO, DANA, ShopeePay, LinkAja, BCA Mobile, BNI, and Mandiri.

![Settings](public/readme/admin-side/settings-page.png)

---

## Customer Storefront

### Home Page

The main storefront landing page featuring a hero carousel (home sliders), featured collections, and navigation with search, wishlist, and cart.

![Home Page](public/readme/cust-side/home-page.png)

---

### All Categories

Displays all available product categories for customers to browse and filter by.

![All Categories](public/readme/cust-side/all-categories-page.png)

---

### Product Page

Detailed product view with image, name, category link, price, quantity selector, stock count, and Add to Cart / Wishlist buttons.

![Product Page](public/readme/cust-side/product-page.png)

---

### Cart

Shopping cart page showing selected items, quantities, and total price before proceeding to checkout.

![Cart](public/readme/cust-side/cart-page.png)

---

### Checkout

Order summary and payment method selection (Cash on Delivery or QRIS). Customer fills in shipping details and confirms the order.

![Checkout](public/readme/cust-side/checkout-page.png)

---

### My Orders

Customer order history page showing all past and active orders with tracking numbers and statuses.

![My Orders](public/readme/cust-side/my-orders-page.png)

---

### My Wishlist

Saved items page. Customers can view and manage products they have wishlisted for later purchase.

![My Wishlist](public/readme/cust-side/my-wishlist-page.png)

---

## Getting Started

```bash
git clone <repo-url>
cd fashion-ecommerce
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

---

## License

MIT
