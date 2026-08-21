<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
 <link rel="shortcut icon" type="image/png" href="/favicon.png">
    <title>Restaurant Cart</title>

    <style>

        /* =====================================================
           RESET
        ===================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        /* =====================================================
           BODY
        ===================================================== */

        body {

            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Arial,
                sans-serif;

            min-height: 100vh;

            color: #1f2937;

            background:
                linear-gradient(
                    135deg,
                    #fff7ed 0%,
                    #fff 45%,
                    #fef2f2 100%
                );
        }


        /* =====================================================
           HEADER
        ===================================================== */

        .header {

            position: sticky;

            top: 0;

            z-index: 100;

            background: rgba(255, 255, 255, 0.92);

            backdrop-filter: blur(15px);

            -webkit-backdrop-filter: blur(15px);

            border-bottom: 1px solid rgba(0, 0, 0, 0.06);

            box-shadow:
                0 4px 20px rgba(0, 0, 0, 0.04);
        }


        .header-inner {

            max-width: 1400px;

            margin: auto;

            padding: 18px 35px;

            display: flex;

            align-items: center;

            justify-content: space-between;
        }


        /* =====================================================
           LOGO
        ===================================================== */

        .brand {

            display: flex;

            align-items: center;

            gap: 12px;

            text-decoration: none;

            color: #111827;
        }


        .brand-icon {

            width: 46px;

            height: 46px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 14px;

            font-size: 24px;

            background:
                linear-gradient(
                    135deg,
                    #ff6b35,
                    #f97316
                );

            box-shadow:
                0 8px 20px rgba(249, 115, 22, 0.25);
        }


        .brand-text {

            display: flex;

            flex-direction: column;
        }


        .brand-name {

            font-size: 20px;

            font-weight: 800;

            letter-spacing: -0.5px;
        }


        .brand-subtitle {

            font-size: 12px;

            color: #9ca3af;

            margin-top: 2px;
        }


        /* =====================================================
           CART HEADER
        ===================================================== */

        .header-cart {

            display: flex;

            align-items: center;

            gap: 10px;

            padding: 10px 16px;

            border-radius: 12px;

            background: #fff7ed;

            color: #ea580c;

            font-weight: 700;

            font-size: 14px;
        }


        .cart-icon {

            font-size: 20px;
        }


        /* =====================================================
           MAIN
        ===================================================== */

        .main {

            max-width: 1400px;

            margin: 0 auto;

            padding: 45px 35px 70px;
        }


        /* =====================================================
           HERO
        ===================================================== */

        .hero {

            display: flex;

            justify-content: space-between;

            align-items: flex-end;

            margin-bottom: 35px;
        }


        .hero-content {

            max-width: 650px;
        }


        .eyebrow {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            padding: 7px 12px;

            border-radius: 30px;

            background: #fff7ed;

            color: #ea580c;

            font-size: 12px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: 1px;

            margin-bottom: 15px;
        }


        .eyebrow-dot {

            width: 7px;

            height: 7px;

            border-radius: 50%;

            background: #f97316;

            box-shadow:
                0 0 0 4px rgba(249, 115, 22, 0.12);
        }


        .hero h1 {

            font-size: clamp(34px, 5vw, 54px);

            line-height: 1.05;

            letter-spacing: -2px;

            color: #111827;

            margin-bottom: 12px;
        }


        .hero h1 span {

            color: #f97316;
        }


        .hero-description {

            font-size: 16px;

            line-height: 1.7;

            color: #6b7280;
        }


        /* =====================================================
           MAIN GRID
        ===================================================== */

        .content-grid {

            display: grid;

            grid-template-columns:
                minmax(0, 1fr)
                390px;

            gap: 30px;

            align-items: start;
        }


        /* =====================================================
           PRODUCTS SECTION
        ===================================================== */

        .products-panel {

            background: rgba(255, 255, 255, 0.85);

            border: 1px solid rgba(255, 255, 255, 0.8);

            border-radius: 24px;

            padding: 28px;

            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.06);
        }


        .section-heading {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 25px;
        }


        .section-title {

            font-size: 23px;

            font-weight: 800;

            color: #111827;
        }


        .section-count {

            padding: 7px 12px;

            border-radius: 20px;

            background: #f3f4f6;

            color: #6b7280;

            font-size: 12px;

            font-weight: 700;
        }


        /* =====================================================
           PRODUCT GRID
        ===================================================== */

        .products-grid {

            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 18px;
        }


        /* =====================================================
           PRODUCT CARD
        ===================================================== */

        .product-card {

            position: relative;

            overflow: hidden;

            background: #ffffff;

            border: 1px solid #f1f1f1;

            border-radius: 20px;

            padding: 18px;

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                border-color 0.25s ease;
        }


        .product-card:hover {

            transform: translateY(-5px);

            border-color: #fed7aa;

            box-shadow:
                0 18px 35px rgba(0, 0, 0, 0.09);
        }


        /* =====================================================
           PRODUCT ICON
        ===================================================== */

        .product-image {

            height: 145px;

            border-radius: 16px;

            display: flex;

            align-items: center;

            justify-content: center;

            margin-bottom: 17px;

            background:
                linear-gradient(
                    135deg,
                    #fff7ed,
                    #ffedd5
                );

            position: relative;

            overflow: hidden;
        }


        .product-image::before {

            content: "";

            position: absolute;

            width: 130px;

            height: 130px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, 0.6);

            top: -60px;

            right: -40px;
        }


        .food-icon {

            font-size: 65px;

            position: relative;

            z-index: 2;

            filter:
                drop-shadow(
                    0 8px 8px rgba(0, 0, 0, 0.12)
                );

            transition:
                transform 0.3s ease;
        }


        .product-card:hover .food-icon {

            transform: scale(1.08) rotate(-3deg);
        }


        /* =====================================================
           PRODUCT CONTENT
        ===================================================== */

        .product-name {

            font-size: 17px;

            font-weight: 800;

            color: #111827;

            margin-bottom: 7px;
        }


        .product-description {

            font-size: 12px;

            line-height: 1.5;

            color: #9ca3af;

            min-height: 36px;

            margin-bottom: 15px;
        }


        .product-bottom {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 10px;
        }


        .product-price {

            font-size: 18px;

            font-weight: 900;

            color: #111827;
        }


        .product-price small {

            font-size: 11px;

            color: #9ca3af;

            font-weight: 500;
        }


        /* =====================================================
           ADD BUTTON
        ===================================================== */

        .add-button {

            border: none;

            outline: none;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            padding: 10px 14px;

            border-radius: 11px;

            background:
                linear-gradient(
                    135deg,
                    #f97316,
                    #ea580c
                );

            color: #ffffff;

            font-size: 12px;

            font-weight: 800;

            cursor: pointer;

            box-shadow:
                0 7px 15px rgba(234, 88, 12, 0.20);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }


        .add-button:hover {

            transform: translateY(-2px);

            box-shadow:
                0 10px 20px rgba(234, 88, 12, 0.28);
        }


        .add-button:active {

            transform: translateY(0);
        }


        .plus-icon {

            font-size: 16px;

            line-height: 1;
        }


        /* =====================================================
           CART PANEL
        ===================================================== */

        .cart-panel {

            position: sticky;

            top: 95px;

            background: #111827;

            color: white;

            border-radius: 25px;

            overflow: hidden;

            box-shadow:
                0 25px 60px rgba(17, 24, 39, 0.22);
        }


        .cart-header {

            padding: 25px 25px 20px;

            background:
                linear-gradient(
                    135deg,
                    #1f2937,
                    #111827
                );
        }


        .cart-header-top {

            display: flex;

            align-items: center;

            justify-content: space-between;
        }


        .cart-title {

            display: flex;

            align-items: center;

            gap: 10px;

            font-size: 21px;

            font-weight: 800;
        }


        .cart-title-icon {

            width: 40px;

            height: 40px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 12px;

            background: rgba(249, 115, 22, 0.15);

            font-size: 20px;
        }


        .cart-count {

            min-width: 30px;

            height: 30px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: #f97316;

            color: white;

            font-size: 12px;

            font-weight: 900;
        }


        .cart-subtitle {

            margin-top: 10px;

            font-size: 12px;

            color: #9ca3af;

        }


        /* =====================================================
           CART BODY
        ===================================================== */

        .cart-body {

            padding: 0 25px 25px;
        }


        .cart-items {

            max-height: 430px;

            overflow-y: auto;

            padding-right: 5px;
        }


        .cart-items::-webkit-scrollbar {

            width: 5px;
        }


        .cart-items::-webkit-scrollbar-track {

            background: transparent;
        }


        .cart-items::-webkit-scrollbar-thumb {

            background: #374151;

            border-radius: 20px;
        }


        /* =====================================================
           CART ITEM
        ===================================================== */

        .cart-item {

            padding: 18px 0;

            border-bottom:
                1px solid rgba(255, 255, 255, 0.08);
        }


        .cart-item:last-child {

            border-bottom: none;
        }


        .cart-item-top {

            display: flex;

            align-items: flex-start;

            justify-content: space-between;

            gap: 12px;
        }


        .cart-item-info {

            display: flex;

            align-items: center;

            gap: 11px;

            min-width: 0;
        }


        .cart-item-icon {

            width: 42px;

            height: 42px;

            flex-shrink: 0;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 12px;

            background:
                rgba(249, 115, 22, 0.12);

            font-size: 21px;
        }


        .cart-item-name {

            font-size: 14px;

            font-weight: 800;

            color: #ffffff;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }


        .cart-item-price {

            margin-top: 4px;

            font-size: 11px;

            color: #9ca3af;
        }


        .cart-item-total {

            font-size: 14px;

            font-weight: 800;

            color: #ffffff;

            white-space: nowrap;
        }


        /* =====================================================
           QUANTITY
        ===================================================== */

        .cart-controls {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-top: 12px;

            padding-left: 53px;
        }


        .quantity {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 4px;

            background: #1f2937;

            border: 1px solid #374151;

            border-radius: 10px;
        }


        .quantity button {

            width: 27px;

            height: 27px;

            border: none;

            border-radius: 7px;

            background: #374151;

            color: white;

            font-size: 17px;

            font-weight: 700;

            display: flex;

            align-items: center;

            justify-content: center;

            cursor: pointer;

            transition:
                background 0.2s ease,
                transform 0.2s ease;
        }


        .quantity button:hover {

            background: #f97316;

            transform: scale(1.05);
        }


        .quantity-value {

            min-width: 24px;

            text-align: center;

            font-size: 13px;

            font-weight: 800;

            color: white;
        }


        /* =====================================================
           REMOVE
        ===================================================== */

        .remove-button {

            border: none;

            background: transparent;

            color: #9ca3af;

            font-size: 11px;

            font-weight: 600;

            cursor: pointer;

            padding: 5px;

            transition:
                color 0.2s ease;
        }


        .remove-button:hover {

            color: #f87171;

            background: transparent;
        }


        /* =====================================================
           SUMMARY
        ===================================================== */

        .summary {

            margin-top: 10px;

            padding-top: 20px;

            border-top:
                1px solid rgba(255, 255, 255, 0.1);
        }


        .summary-row {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 13px;

            font-size: 13px;

            color: #9ca3af;
        }


        .summary-row strong {

            color: white;

            font-weight: 700;
        }


        .tax-label {

            display: flex;

            align-items: center;

            gap: 6px;
        }


        .tax-badge {

            padding: 3px 6px;

            border-radius: 5px;

            background: rgba(249, 115, 22, 0.12);

            color: #fb923c;

            font-size: 9px;

            font-weight: 800;
        }


        .total-row {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-top: 20px;

            padding-top: 18px;

            border-top:
                1px solid rgba(255, 255, 255, 0.1);
        }


        .total-label {

            font-size: 14px;

            color: #d1d5db;

            font-weight: 700;
        }


        .grand-total {

            font-size: 27px;

            font-weight: 900;

            color: #ffffff;
        }


        .grand-total-currency {

            font-size: 15px;

            color: #fb923c;
        }


        /* =====================================================
           CLEAR BUTTON
        ===================================================== */

        .clear-button {

            width: 100%;

            margin-top: 20px;

            padding: 13px;

            border: 1px solid #374151;

            border-radius: 12px;

            background: transparent;

            color: #d1d5db;

            font-size: 12px;

            font-weight: 800;

            cursor: pointer;

            transition:
                background 0.2s ease,
                color 0.2s ease,
                border-color 0.2s ease;
        }


        .clear-button:hover {

            background: rgba(239, 68, 68, 0.1);

            border-color: #ef4444;

            color: #fca5a5;
        }


        /* =====================================================
           EMPTY CART
        ===================================================== */

        .empty-cart {

            text-align: center;

            padding: 60px 20px;
        }


        .empty-cart-icon {

            width: 80px;

            height: 80px;

            margin: 0 auto 20px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background:
                rgba(249, 115, 22, 0.1);

            font-size: 38px;
        }


        .empty-cart h3 {

            font-size: 18px;

            color: white;

            margin-bottom: 8px;
        }


        .empty-cart p {

            color: #9ca3af;

            font-size: 13px;

            line-height: 1.6;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1100px) {

            .products-grid {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .content-grid {

                grid-template-columns:
                    minmax(0, 1fr)
                    350px;
            }
        }


        @media (max-width: 850px) {

            .header-inner {

                padding: 15px 20px;
            }

            .main {

                padding:
                    30px 20px 50px;
            }

            .content-grid {

                grid-template-columns: 1fr;
            }

            .cart-panel {

                position: static;
            }

            .cart-items {

                max-height: none;
            }
        }


        @media (max-width: 550px) {

            .hero {

                display: block;
            }

            .hero h1 {

                font-size: 38px;
            }

            .header-cart {

                padding: 9px 11px;
            }

            .header-cart span {

                display: none;
            }

            .products-panel {

                padding: 18px;
            }

            .products-grid {

                grid-template-columns: 1fr;
            }

            .product-image {

                height: 170px;
            }

            .cart-body,
            .cart-header {

                padding-left: 18px;
                padding-right: 18px;
            }

        }

    </style>

</head>


<body>


<!-- =========================================================
     HEADER
========================================================= -->

<header class="header">

    <div class="header-inner">


        <a
            href="<?= site_url('cart') ?>"
            class="brand"
        >

            <div class="brand-icon">
                🍽️
            </div>


            <div class="brand-text">

                <div class="brand-name">
                    Flavor House
                </div>

                <div class="brand-subtitle">
                    Fresh food · Fast ordering
                </div>

            </div>

        </a>


        <div class="header-cart">

            <div class="cart-icon">
                🛒
            </div>

            <span>
                Your Order
            </span>

        </div>


    </div>

</header>



<!-- =========================================================
     MAIN
========================================================= -->

<main class="site-main">