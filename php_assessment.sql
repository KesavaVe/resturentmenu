-- PHP Fullstack Developer Assessment
-- Database: php_assessment
-- Source: _PHP Task (2).pdf
-- Notes:
-- 1. Historical order prices are preserved in order_items.price.
-- 2. Menu size/price combinations are normalized into menu_item_variants.
-- 3. One order can have many order_items and many payments.
-- 4. Source Order History jumps from ID 39 to ID 41; ID 40 is not present
--    in the supplied PDF, so it is intentionally not invented here.

DROP DATABASE IF EXISTS php_assessment;
CREATE DATABASE php_assessment CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE php_assessment;

-- ============================================================
-- MENU
-- ============================================================

CREATE TABLE menus (
    id INT UNSIGNED PRIMARY KEY,
    name VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE categories (
    id INT UNSIGNED PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    menu_id INT UNSIGNED NOT NULL,
    CONSTRAINT fk_categories_menu
        FOREIGN KEY (menu_id) REFERENCES menus(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    INDEX idx_categories_menu_id (menu_id)
) ENGINE=InnoDB;

CREATE TABLE menu_items (
    id INT UNSIGNED PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    CONSTRAINT fk_menu_items_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    INDEX idx_menu_items_category_id (category_id)
) ENGINE=InnoDB;

CREATE TABLE menu_item_variants (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    item_id INT UNSIGNED NOT NULL,
    size VARCHAR(50) NULL,
    price DECIMAL(10,5) NOT NULL,
    CONSTRAINT fk_variants_item
        FOREIGN KEY (item_id) REFERENCES menu_items(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    UNIQUE KEY uq_item_size (item_id, size),
    INDEX idx_variants_item_id (item_id)
) ENGINE=InnoDB;

INSERT INTO menus (id, name) VALUES
(1, 'Food'),
(2, 'Drinks');

INSERT INTO categories (id, name, menu_id) VALUES
(1, 'Starters', 1),
(2, 'Soft Drinks', 2),
(3, 'Mains', 1),
(4, 'Desserts', 2),
(5, 'Hot Drinks', 2);

INSERT INTO menu_items (id, name, category_id) VALUES
(1, 'Item1', 1),
(2, 'Item2', 1),
(3, 'Item3', 2),
(4, 'Item4', 2),
(5, 'Item5', 2),
(6, 'Item6', 3),
(7, 'Item7', 3),
(8, 'Item8', 4),
(9, 'Item9', 4),
(10, 'Item10', 5);

INSERT INTO menu_item_variants (item_id, size, price) VALUES
(1, 'Small', 1.50),
(1, 'Large', 2.50),
(2, NULL, 3.00),
(3, NULL, 2.50),
(4, NULL, 1.50),
(5, NULL, 1.00),
(6, 'Small', 2.50),
(6, 'Large', 3.60),
(7, NULL, 2.50),
(8, 'Small', 3.75),
(8, 'Large', 6.50),
(9, NULL, 1.50),
(10, NULL, 2.00);

-- ============================================================
-- ORDERS
-- ============================================================

CREATE TABLE orders (
    id INT UNSIGNED PRIMARY KEY,
    order_date DATE NOT NULL,
    status VARCHAR(30) NOT NULL,
    INDEX idx_orders_date (order_date),
    INDEX idx_orders_status (status)
) ENGINE=InnoDB;

CREATE TABLE order_items (
    id INT UNSIGNED PRIMARY KEY,
    order_id INT UNSIGNED NOT NULL,
    item_id INT UNSIGNED NOT NULL,
    size VARCHAR(50) NULL,
    price DECIMAL(10,5) NOT NULL,
    quantity INT UNSIGNED NOT NULL,
    total DECIMAL(10,5) NOT NULL,
    CONSTRAINT fk_order_items_order
        FOREIGN KEY (order_id) REFERENCES orders(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_order_items_item
        FOREIGN KEY (item_id) REFERENCES menu_items(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    INDEX idx_order_items_order_id (order_id),
    INDEX idx_order_items_item_id (item_id)
) ENGINE=InnoDB;

INSERT INTO orders (id, order_date, status) VALUES
(10, '2025-10-01', 'Completed'),
(11, '2025-10-01', 'Completed'),
(12, '2025-10-01', 'Completed'),
(13, '2025-10-01', 'Completed'),
(14, '2025-10-01', 'Completed'),
(15, '2025-10-02', 'Completed'),
(16, '2025-10-03', 'Completed'),
(17, '2025-10-01', 'Completed'),
(18, '2025-10-05', 'Completed'),
(19, '2025-10-01', 'Completed'),
(20, '2025-10-01', 'Completed');

INSERT INTO order_items
(id, order_id, item_id, size, price, quantity, total)
VALUES
(1,  10, 2,  NULL,    2.5,      1,  2.5),
(2,  10, 3,  NULL,    1.5,      2,  3.0),
(3,  10, 1,  'Small', 3.75,     1,  3.75),

(4,  11, 5,  NULL,    2.75,     1,  2.75),
(5,  11, 6,  NULL,    1.75,     2,  3.5),
(6,  11, 2,  NULL,    2.5,      1,  2.5),
(7,  11, 3,  NULL,    3.5,      1,  3.5),
(8,  11, 4,  NULL,    3.75,     2,  7.5),
(9,  11, 5,  NULL,    1.5,      1,  1.5),

(10, 12, 6,  'Large', 5.5,      2,  11.0),
(11, 12, 7,  NULL,    2.5,      1,  2.5),
(12, 12, 1,  'Large', 3.5,      1,  3.5),

(13, 13, 1,  'Small', 2.75,     2,  5.5),
(14, 13, 6,  'Small', 1.5,      1,  1.5),
(15, 13, 8,  'Small', 3.5,      1,  3.5),
(16, 13, 1,  'Small', 2.5,      2,  5.0),

(17, 14, 6,  'Large', 2.75,     1,  2.75),
(18, 14, 1,  'Large', 2.75655,  2,  5.5131),
(19, 14, 8,  'Large', 2.75,     2,  5.5),
(20, 14, 1,  'Large', 2.7556,   2,  5.5112),
(21, 14, 4,  NULL,    5.5,      1,  5.5),
(22, 14, 3,  NULL,    2.75,     2,  5.5),
(23, 14, 2,  NULL,    3.5,      1,  3.5),
(24, 14, 6,  'Large', 3.015,    3,  9.045),

(25, 15, 2,  NULL,    2.568,    2,  5.136),
(26, 16, 6,  'Large', 6.586,    3,  19.758),

(27, 17, 10, NULL,    2.5,      1,  2.5),
(28, 17, 9,  NULL,    2.75636,  1,  2.75636),
(29, 17, 7,  NULL,    5.63982,  1,  5.63982),

(30, 18, 1,  'Small', 2.5698,   2,  5.1396),
(31, 18, 6,  'Small', 5.36245,  2,  10.7249),
(32, 18, 8,  'Small', 5.23569,  2,  10.47138),

(33, 19, 2,  NULL,    2.75698,  1,  2.75698),
(34, 19, 4,  NULL,    2.356,    1,  2.356),
(35, 19, 5,  NULL,    2.457,    2,  4.914),
(36, 19, 7,  NULL,    2.6359,   1,  2.6359),
(37, 19, 9,  NULL,    6.523,    1,  6.523),
(38, 19, 10, NULL,    8.5412,   3,  25.6236),
(39, 19, 6,  'Large', 5.683,    2,  11.366),
(41, 19, 2,  NULL,    6.3564,   1,  6.3564),
(42, 19, 5,  NULL,    7.235,    1,  7.235),
(43, 19, 7,  NULL,    2.365,    1,  2.365),

(44, 20, 1,  'Large', 2.3658,   1,  2.3658),
(45, 20, 3,  NULL,    2.356,    1,  2.356),
(46, 20, 6,  'Large', 1.256,    1,  1.256),
(47, 20, 4,  NULL,    2.635,    1,  2.635),
(48, 20, 5,  NULL,    5.21,     1,  5.21),
(49, 20, 7,  NULL,    6.325,    2,  12.65),
(50, 20, 8,  'Small', 7.2514,   1,  7.2514),
(51, 20, 9,  NULL,    2.3999,   1,  2.3999),
(52, 20, 4,  NULL,    2.356,    3,  7.068),
(53, 20, 6,  'Small', 4.5326,   2,  9.0652);

-- ============================================================
-- PAYMENTS
-- ============================================================

CREATE TABLE payments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    payment_id INT UNSIGNED NOT NULL UNIQUE,
    order_id INT UNSIGNED NOT NULL,
    payment_date DATE NOT NULL,
    amount_due DECIMAL(10,5) NOT NULL,
    tips DECIMAL(10,5) NOT NULL DEFAULT 0,
    discount DECIMAL(10,5) NOT NULL DEFAULT 0,
    total_paid DECIMAL(10,5) NOT NULL,
    payment_type VARCHAR(30) NOT NULL,
    payment_status VARCHAR(30) NOT NULL,

    CONSTRAINT fk_payments_order
        FOREIGN KEY (order_id) REFERENCES orders(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    INDEX idx_payments_order_id (order_id),
    INDEX idx_payments_status (payment_status)
) ENGINE=InnoDB;

INSERT INTO payments
(payment_id, order_id, payment_date, amount_due, tips, discount, total_paid, payment_type, payment_status)
VALUES
(100, 10, '2025-10-01',  9.25,     0, 0,  9.25,  'Card', 'Completed'),

(101, 11, '2025-10-01', 21.25,     0, 0, 10.00,  'Cash', 'Completed'),
(102, 11, '2025-10-01', 21.25,     0, 0, 11.25,  'Card', 'Completed'),

(103, 12, '2025-10-02', 17.00,     3, 4, 16.00,  'Card', 'Completed'),

(104, 13, '2025-10-03', 15.50,     0, 2, 13.50,  'Card', 'Completed'),

(105, 14, '2025-10-01', 42.8193,   0, 0, 20.00,  'Cash', 'Completed'),
(106, 14, '2025-10-01', 42.8193,   0, 0, 22.82,  'Card', 'Completed'),

(107, 15, '2025-10-02',  5.136,    0, 0,  5.14,   'Card', 'Refunded'),

(108, 16, '2025-10-03', 19.758,    0, 0, 10.00,  'Cash', 'Completed'),
(109, 16, '2025-10-03', 19.758,    0, 0,  9.76,   'Card', 'Completed'),

(110, 17, '2025-10-01', 10.8918,   0, 0, 10.90,   'Card', 'Completed'),

(111, 18, '2025-10-05', 26.33588,  2, 0, 25.00,   'Cash', 'Completed'),
(115, 18, '2025-10-05', 26.33588,  0, 0,  3.34,   'Card', 'Completed'),

(116, 19, '2025-10-01', 72.13188,  0, 0, 50.00,   'Cash', 'Completed'),
(119, 19, '2025-10-01', 72.13188,  0, 0, 22.13,   'Card', 'Completed'),

(120, 20, '2025-10-01', 52.2573,   0, 0, 25.00,   'Cash', 'Completed'),
(121, 20, '2025-10-01', 52.2573,   0, 0, 27.28,   'Card', 'Completed');

-- ============================================================
-- VERIFICATION QUERIES
-- ============================================================

-- 1. Number of orders
SELECT COUNT(*) AS total_orders FROM orders;

-- 2. Number of order lines
SELECT COUNT(*) AS total_order_items FROM order_items;

-- 3. Number of payments
SELECT COUNT(*) AS total_payments FROM payments;

-- 4. Order totals calculated from order_items
SELECT
    order_id,
    ROUND(SUM(total), 5) AS calculated_order_total
FROM order_items
GROUP BY order_id
ORDER BY order_id;

-- 5. Payment summary per order
SELECT
    order_id,
    ROUND(SUM(total_paid), 5) AS total_paid
FROM payments
GROUP BY order_id
ORDER BY order_id;

-- 6. Full item information
SELECT
    oi.id,
    oi.order_id,
    oi.item_id,
    mi.name AS item_name,
    oi.size,
    oi.price,
    oi.quantity,
    oi.total
FROM order_items oi
JOIN menu_items mi ON mi.id = oi.item_id
ORDER BY oi.order_id, oi.id;

-- 7. Full order/payment summary.
-- Pre-aggregate order_items and payments separately to avoid
-- multiplying rows when an order has multiple items AND payments.
SELECT
    o.id AS order_id,
    o.order_date,
    o.status,
    COALESCE(oi.order_total, 0) AS order_total,
    COALESCE(p.total_paid, 0) AS total_paid
FROM orders o
LEFT JOIN (
    SELECT
        order_id,
        ROUND(SUM(total), 5) AS order_total
    FROM order_items
    GROUP BY order_id
) oi ON oi.order_id = o.id
LEFT JOIN (
    SELECT
        order_id,
        ROUND(SUM(total_paid), 5) AS total_paid
    FROM payments
    GROUP BY order_id
) p ON p.order_id = o.id
ORDER BY o.id;

-- 8. Payment reconciliation.
-- expected_paid = amount_due + tips - discount.
SELECT
    order_id,
    ROUND(MAX(amount_due), 5) AS amount_due,
    ROUND(MAX(tips), 5) AS tips,
    ROUND(MAX(discount), 5) AS discount,
    ROUND(MAX(amount_due + tips - discount), 5) AS expected_paid,
    ROUND(SUM(total_paid), 5) AS actual_paid,
    ROUND(
        SUM(total_paid) - MAX(amount_due + tips - discount),
        5
    ) AS difference
FROM payments
GROUP BY order_id
ORDER BY order_id;
