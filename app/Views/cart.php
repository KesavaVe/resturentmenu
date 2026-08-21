

<?= view('layouts/header', [
    'title' => 'Restaurant Cart'
]) ?>
    

   



    <!-- =====================================================
         CONTENT
    ====================================================== -->

    <div class="content-grid">


        <!-- =================================================
             PRODUCTS
        ================================================== -->

        <section class="products-panel">


            <div class="section-heading">

                <div class="section-title">
                    Our Menu
                </div>


                <div class="section-count">

                    <?= count($items) ?>

                    items

                </div>

            </div>



            <div class="products-grid">


                <?php

                /*
                |--------------------------------------------------------------------------
                | Food icons
                |--------------------------------------------------------------------------
                */

                $foodIcons = [
                    '🍔',
                    '🍕',
                    '🥗',
                    '🍟',
                    '🥤'
                ];


                $foodDescriptions = [
                    'Freshly prepared and full of flavor.',
                    'Deliciously baked with premium toppings.',
                    'Fresh ingredients for a lighter choice.',
                    'Crispy, golden and perfectly seasoned.',
                    'A refreshing drink to complete your meal.'
                ];


                $index = 0;

                ?>


                <?php foreach ($items as $itemId => $item): ?>


                    <?php

                    $icon =
                        $foodIcons[
                            $index % count($foodIcons)
                        ];


                    $description =
                        $foodDescriptions[
                            $index % count($foodDescriptions)
                        ];


                    $index++;

                    ?>


                    <div class="product-card">


                        <!-- PRODUCT IMAGE -->

                        <div class="product-image">

                            <span class="food-icon">
                                <?= $icon ?>
                            </span>

                        </div>


                        <!-- PRODUCT NAME -->

                        <div class="product-name">

                            <?= esc($item['name']) ?>

                        </div>


                        <!-- DESCRIPTION -->

                        <div class="product-description">

                            <?= esc($description) ?>

                        </div>


                        <!-- PRICE + ADD -->

                        <div class="product-bottom">


                            <div class="product-price">

                                £<?= number_format(
                                    $item['price'],
                                    2
                                ) ?>

                                <small>
                                    incl. tax
                                </small>

                            </div>


                            <form
                                method="post"
                                action="<?= site_url('cart/add') ?>"
                            >

                                <?= csrf_field() ?>


                                <input
                                    type="hidden"
                                    name="item_id"
                                    value="<?= $itemId ?>"
                                >


                                <button
                                    type="submit"
                                    class="add-button"
                                >

                                    <span class="plus-icon">
                                        +
                                    </span>

                                    Add

                                </button>

                            </form>


                        </div>


                    </div>


                <?php endforeach; ?>


            </div>


        </section>



        <!-- =================================================
             CART
        ================================================== -->

        <aside class="cart-panel">


            <!-- CART HEADER -->

            <div class="cart-header">


                <div class="cart-header-top">


                    <div class="cart-title">

                        <div class="cart-title-icon">
                            🛒
                        </div>

                        Your Order

                    </div>


                    <div
                        class="cart-count"
                        id="cart-count"
                    >

                        <?= count($cart) ?>

                    </div>


                </div>


                <div class="cart-subtitle">

                    Review your items before placing your order.

                </div>


            </div>



            <!-- CART BODY -->

            <div class="cart-body">


                <?php if (empty($cart)): ?>


                    <!-- EMPTY CART -->

                    <div class="empty-cart">

                        <div class="empty-cart-icon">
                            🛒
                        </div>


                        <h3>
                            Your cart is empty
                        </h3>


                        <p>

                            Pick something delicious
                            from our menu to get started.

                        </p>

                    </div>


                <?php else: ?>


                    <!-- CART ITEMS -->

                    <div
                        class="cart-items"
                        id="cart-items"
                    >


                        <?php foreach ($cart as $item): ?>


                            <div
                                class="cart-item"
                                data-item-id="<?= $item['item_id'] ?>"
                            >


                                <div class="cart-item-top">


                                    <div class="cart-item-info">


                                        <div class="cart-item-icon">

                                            <?php

                                            $cartIconIndex =
                                                (
                                                    (int) $item['item_id']
                                                    - 1
                                                ) %
                                                count($foodIcons);

                                            echo $foodIcons[
                                                $cartIconIndex
                                            ];

                                            ?>

                                        </div>


                                        <div>


                                            <div class="cart-item-name">

                                                <?= esc(
                                                    $item['name']
                                                ) ?>

                                            </div>


                                            <div class="cart-item-price">

                                                £<?= number_format(
                                                    $item['price'],
                                                    2
                                                ) ?>

                                                ×

                                                <span
                                                    class="line-quantity"
                                                >
                                                    <?= $item['quantity'] ?>
                                                </span>

                                            </div>


                                        </div>


                                    </div>


                                    <div class="cart-item-total">

                                        £<span class="item-total">

                                            <?= number_format(
                                                $item['price'] *
                                                $item['quantity'],
                                                2
                                            ) ?>

                                        </span>

                                    </div>


                                </div>



                                <!-- CONTROLS -->

                                <div class="cart-controls">


                                    <div class="quantity">


                                        <!-- DECREASE -->

                                        <button
                                            type="button"
                                            aria-label="Decrease quantity"
                                            onclick="changeQuantity(
                                                <?= $item['item_id'] ?>,
                                                -1
                                            )"
                                        >
                                            −
                                        </button>


                                        <!-- QUANTITY -->

                                        <span
                                            class="quantity-value"
                                        >

                                            <?= $item['quantity'] ?>

                                        </span>


                                        <!-- INCREASE -->

                                        <button
                                            type="button"
                                            aria-label="Increase quantity"
                                            onclick="changeQuantity(
                                                <?= $item['item_id'] ?>,
                                                1
                                            )"
                                        >
                                            +
                                        </button>


                                    </div>



                                    <!-- REMOVE -->

                                    <form
                                        method="post"
                                        action="<?= site_url(
                                            'cart/remove'
                                        ) ?>"
                                    >

                                        <?= csrf_field() ?>


                                        <input
                                            type="hidden"
                                            name="item_id"
                                            value="<?= $item['item_id'] ?>"
                                        >


                                        <button
                                            type="submit"
                                            class="remove-button"
                                        >
                                            Remove
                                        </button>


                                    </form>


                                </div>


                            </div>


                        <?php endforeach; ?>


                    </div>



                    <!-- =================================================
                         SUMMARY
                    ================================================== -->

                    <div class="summary">


                        <!-- SUBTOTAL -->

                        <div class="summary-row">

                            <span>
                                Subtotal
                            </span>


                            <strong>

                                £<span id="subtotal">

                                    <?= number_format(
                                        $summary['subtotal'],
                                        2
                                    ) ?>

                                </span>

                            </strong>

                        </div>



                        <!-- TAX -->

                        <div class="summary-row">


                            <span class="tax-label">

                                Tax

                                <span class="tax-badge">
                                    12.5%
                                </span>

                            </span>


                            <strong>

                                £<span id="tax">

                                    <?= number_format(
                                        $summary['tax'],
                                        2
                                    ) ?>

                                </span>

                            </strong>


                        </div>



                        <!-- TOTAL -->

                        <div class="total-row">


                            <div class="total-label">

                                Total Incl. Tax

                            </div>


                            <div class="grand-total">

                                <span
                                    class="grand-total-currency"
                                >
                                    £
                                </span>


                                <span id="grand-total">

                                    <?= number_format(
                                        $summary['total'],
                                        2
                                    ) ?>

                                </span>

                            </div>


                        </div>



                        <!-- CLEAR CART -->

                        <form
                            method="post"
                            action="<?= site_url(
                                'cart/clear'
                            ) ?>"
                        >

                            <?= csrf_field() ?>


                            <button
                                type="submit"
                                class="clear-button"
                            >
                                Clear Cart
                            </button>

                        </form>


                    </div>


                <?php endif; ?>


            </div>


        </aside>


    </div>






<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>


/*
|--------------------------------------------------------------------------
| CHANGE QUANTITY
|--------------------------------------------------------------------------
|
| change = 1
| Increase quantity
|
| change = -1
| Decrease quantity
|
*/

    async function changeQuantity(
        itemId,
        change
    ) {


        const cartItem =
            document.querySelector(
                `.cart-item[data-item-id="${itemId}"]`
            );


        if (!cartItem) {

            return;

        }


        const quantityElement =
            cartItem.querySelector(
                '.quantity-value'
            );


        if (!quantityElement) {

            return;

        }


        const currentQuantity =
            parseInt(
                quantityElement.textContent.trim(),
                10
            );


        const newQuantity =
            currentQuantity + change;


        /*
        |--------------------------------------------------------------------------
        | If quantity becomes 0, remove item
        |--------------------------------------------------------------------------
        */

        if (newQuantity < 1) {

            await removeItem(itemId);

            return;

        }


        await updateQuantity(
            itemId,
            newQuantity
        );

    }



/*
|--------------------------------------------------------------------------
| REMOVE ITEM
|--------------------------------------------------------------------------
*/

async function removeItem(itemId)
    {


        const formData =
            new FormData();


        formData.append(
            'item_id',
            itemId
        );


        /*
        |--------------------------------------------------------------------------
        | CSRF
        |--------------------------------------------------------------------------
        */

        const csrfInput =
            document.querySelector(
                'input[name="<?= csrf_token() ?>"]'
            );


        if (csrfInput) {

            formData.append(
                '<?= csrf_token() ?>',
                csrfInput.value
            );

        }


        try {


            const response =
                await fetch(
                    '<?= site_url(
                        'cart/remove'
                    ) ?>',
                    {
                        method: 'POST',
                        body: formData
                    }
                );


            if (response.ok) {

                window.location.reload();

            } else {

                alert(
                    'Unable to remove item.'
                );

            }


        }
        catch (error) {


            console.error(
                'Remove item error:',
                error
            );


            alert(
                'Something went wrong while removing the item.'
            );

        }

    }



/*
|--------------------------------------------------------------------------
| UPDATE QUANTITY
|--------------------------------------------------------------------------
*/

async function updateQuantity(
    itemId,
    quantity
)
{


    if (quantity < 1) {

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Form data
    |--------------------------------------------------------------------------
    */

    const formData =
        new FormData();


    formData.append(
        'item_id',
        itemId
    );


    formData.append(
        'quantity',
        quantity
    );


    /*
    |--------------------------------------------------------------------------
    | CSRF
    |--------------------------------------------------------------------------
    */

    const csrfInput =
        document.querySelector(
            'input[name="<?= csrf_token() ?>"]'
        );


    if (csrfInput) {

        formData.append(
            '<?= csrf_token() ?>',
            csrfInput.value
        );

    }


    try {


        /*
        |--------------------------------------------------------------------------
        | API request
        |--------------------------------------------------------------------------
        */

        const response =
            await fetch(
                '<?= site_url(
                    'cart/update-quantity'
                ) ?>',
                {
                    method: 'POST',
                    body: formData
                }
            );


        /*
        |--------------------------------------------------------------------------
        | JSON response
        |--------------------------------------------------------------------------
        */

        const result =
            await response.json();


        console.log(
            'Cart API Response:',
            result
        );


        /*
        |--------------------------------------------------------------------------
        | Error
        |--------------------------------------------------------------------------
        */

        if (!result.success) {

            alert(
                result.message ||
                'Unable to update cart.'
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Find item
        |--------------------------------------------------------------------------
        */

        const cartItem =
            document.querySelector(
                `.cart-item[data-item-id="${itemId}"]`
            );


        if (cartItem) {


            /*
            |--------------------------------------------------------------------------
            | Update line quantity
            |--------------------------------------------------------------------------
            */

            const lineQuantity =
                cartItem.querySelector(
                    '.line-quantity'
                );


            if (lineQuantity) {

                lineQuantity.textContent =
                    result.data.quantity;

            }


            /*
            |--------------------------------------------------------------------------
            | Update quantity control
            |--------------------------------------------------------------------------
            */

            const quantityValue =
                cartItem.querySelector(
                    '.quantity-value'
                );


            if (quantityValue) {

                quantityValue.textContent =
                    result.data.quantity;

            }


            /*
            |--------------------------------------------------------------------------
            | Update item total
            |--------------------------------------------------------------------------
            */

            const itemTotal =
                cartItem.querySelector(
                    '.item-total'
                );


            if (itemTotal) {

                itemTotal.textContent =
                    Number(
                        result.data.item_total
                    ).toFixed(2);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Update subtotal
        |--------------------------------------------------------------------------
        */

        const subtotal =
            document.getElementById(
                'subtotal'
            );


        if (subtotal) {

            subtotal.textContent =
                Number(
                    result.data.summary.subtotal
                ).toFixed(2);

        }


        /*
        |--------------------------------------------------------------------------
        | Update tax
        |--------------------------------------------------------------------------
        */

        const tax =
            document.getElementById(
                'tax'
            );


        if (tax) {

            tax.textContent =
                Number(
                    result.data.summary.tax
                ).toFixed(2);

        }


        /*
        |--------------------------------------------------------------------------
        | Update grand total
        |--------------------------------------------------------------------------
        */

        const grandTotal =
            document.getElementById(
                'grand-total'
            );


        if (grandTotal) {

            grandTotal.textContent =
                Number(
                    result.data.summary.total
                ).toFixed(2);

        }


    }
    catch (error) {


        console.error(
            'Cart update error:',
            error
        );


        alert(
            'Something went wrong while updating the cart.'
        );

    }

}


</script>

<?= view('layouts/footer') ?>