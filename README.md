# PHP / CodeIgniter 4 Assessment

A CodeIgniter 4 application developed as part of a PHP Full Stack Developer assessment.

The project includes an Orders API with authentication, pagination, order details, payment information, and a session-based restaurant cart with AJAX quantity updates and 12.5% inclusive tax calculation.

---

## 1. Project Overview

This project implements the following main requirements:

- CodeIgniter 4 backend
- MySQL database integration
- Orders REST API
- Order items and menu item details
- Payment details
- API authentication
- Pagination
- Error handling
- Session-based shopping cart
- Add/remove cart items
- Multiple quantities
- AJAX quantity updates
- Dynamic subtotal calculation
- 12.5% inclusive tax calculation
- Dynamic total calculation
- CSRF protection
- Server-side price validation
- N+1 query optimization

---

# 2. Features

## Orders API

- Get all orders
- Pagination support
- Get individual order by ID
- Order item details
- Menu item names
- Item prices
- Item quantities
- Item totals
- Payment details
- Authentication
- Validation
- Proper HTTP status codes

## Cart

- Display five products
- Add product to cart
- Add the same product multiple times
- Add multiple different products
- Increase quantity
- Decrease quantity
- Remove product
- Clear cart
- AJAX quantity updates
- Dynamic item totals
- Dynamic subtotal
- Dynamic tax
- Dynamic grand total
- Session-based cart

---

# 3. Technology Stack

## Backend

- PHP 8.2+
- CodeIgniter 4.7.4
- MySQL
- CodeIgniter Session
- CodeIgniter Filters

## Frontend

- PHP Views
- HTML5
- CSS3
- JavaScript
- Fetch API / AJAX

## Development Tools

- Composer
- XAMPP
- MySQL
- phpMyAdmin
- Postman
- Git

---

# 4. Requirements

Make sure the following are installed:

- PHP 8.2 or higher
- Composer
- MySQL
- XAMPP or another PHP development environment
- Git
- Postman

Check PHP:

```bash
php -v