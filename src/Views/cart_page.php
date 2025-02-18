
<div class="container">
    <li class="active"><a href="/profile">Мой профиль</a></li>
    <li class="active"><a href="catalog">Каталог</a></li>

    <h3>CART</h3>
    <div class="card-deck">
        <?php foreach ($products as $product): ?>
            <div class="card text-center">
                <img class="card-img-top" src="<?php echo $product['image_url']; ?>" alt="Card image">
                <div class="card-body">
                    <p class="card-text"><?php echo $product['name']; ?></p>
                    <p class="card-text"><?php echo $product['description']; ?></p></a>
                    <div class="card-text">
                        <?php echo "Цена:" . $product['price'] . "р"; ?> <br>
                        <?php echo "Количество: " . $product['amount'] . "шт"; ?> <br>
                        <h5 class="card-title"> <?php echo "Итого:" . $product['amount'] * $product['price'] . "p"; ?></h5>
                    </div>
                </div>
                <hr>

                </a>
            </div>


        <?php endforeach; ?>

        <style>
            body {
                font-style: sans-serif;
                text-align: -webkit-match-parent;
            }

            a {
                text-decoration: none;

            }

            h5 {
                font-size: 1.1em;
            }

            a:hover {
                text-decoration: none;

            }

            h3 {
                line-height: 5em;

            }

            .card {
                max-width: 30rem;
                text-align: center;
            }

            .card:hover {
                box-shadow: 1px 2px 10px lightgray;
                transition: 0.3s;

            }


            .card-header {
                font-size: 15px;
                color: gray;
                background-color: white;

            }

            .text-muted {
                font-size: 15px;
                text-align: center;
            }

            .card-footer {
                font-weight: bold;
                font-size: 15px;
                background-color: white;
                text-align: center;
            }
        </style>
