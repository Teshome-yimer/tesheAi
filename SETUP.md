# Course Platform — Setup Guide

## Quick Start

```bash
# 1. Copy env
cp .env.example .env

# 2. Set your DB credentials in .env
DB_DATABASE=course_platform
DB_USERNAME=root
DB_PASSWORD=

# 3. Install dependencies
composer install

# 4. Install Stripe SDK (requires internet/SSL)
composer require stripe/stripe-php

# 5. Generate key + migrate + seed
php artisan key:generate
php artisan migrate --seed
php artisan storage:link

# 6. Run
php artisan serve
```

## Demo Credentials (after seeding)

| Role    | Email               | Password |
|---------|---------------------|----------|
| Admin   | admin@course.com    | password |
| Student | student@course.com  | password |

## Admin Recovery

If you cannot log in to the admin panel, you can recover access with artisan commands after installing dependencies.

```bash
# Create a new admin or promote an existing user to admin
php artisan admin:create admin@example.com StrongPassword123 --name="Admin User"

# Reset the current admin password
php artisan admin:reset-password NewStrongPassword123

# Reset a specific admin by email
php artisan admin:reset-password NewStrongPassword123 --email=admin@example.com
```

Notes:
- Only one admin account is kept active at a time.
- Creating a new admin demotes any other existing admin to `student`.
- These commands work only after `composer install` and normal Laravel setup are complete.

## Payment Keys

### Chapa (Ethiopian ETB)
Get keys from https://dashboard.chapa.co
```
CHAPA_SECRET_KEY=CHASECK_TEST-...
CHAPA_PUBLIC_KEY=CHAPUBK_TEST-...
```
Webhook URL: `https://yourdomain.com/payment/chapa/callback`

### Stripe (International USD)
Get keys from https://dashboard.stripe.com
```
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
```
Webhook URL: `https://yourdomain.com/api/webhooks/stripe`

## Pages

| URL | Description |
|-----|-------------|
| `/` | Landing page |
| `/course/web-development-bootcamp` | Course detail / sales page |
| `/checkout/web-development-bootcamp` | Checkout (requires login) |
| `/login` | Login |
| `/register` | Register |
| `/student/dashboard` | Student dashboard |
| `/student/course/{slug}` | Course viewer |
| `/admin/dashboard` | Admin panel |
