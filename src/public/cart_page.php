<div class="container">

    <h3>Cart</h3>
    <div class="card-deck">
        <div class="card text-center">
            <?php foreach ($user_products as $user_product): ?>
                <a href="#">
                    <div class="card-header">

                    </div>

                    <div class="card-body">
                        <p class="card-text text-muted"><?php echo $user_product['product_id']; ?></p>
                        <p class="card-text text-muted"><?php echo $user_product['amount']; ?></p>
                        <div class="card-footer">

                        </div>
                    </div>
                </a>
            </div>
        <? endforeach; ?>

        <style>

            body {
                font-style: sans-serif;
            }

            a {
                text-decoration: none;
            }

            a:hover {
                text-decoration: none;
            }

            h3 {
                line-height: 3em;
            }

            .card {
                max-width: 16rem;
            }

            .card:hover {
                box-shadow: 1px 2px 10px lightgray;
                transition: 0.2s;
            }

            .card-header {
                font-size: 13px;
                color: gray;
                background-color: white;
            }

            .text-muted {
                font-size: 11px;
            }

            .card-footer{
                font-weight: bold;
                font-size: 18px;
                background-color: white;
            }
        </style>
<?php
