
<div class="container">
    <li class="active"><a href="/catalog">Каталог</a></li>
    <li class="active"><a href="/order">К оформлению</a></li>

    <h3>Ваш заказ:</h3>
    <div>
        <?php foreach ($newUserOrders as $newUserOrder): ?>
            <div class="card text-center">

                <div class="card-body">
                    <h1>Заказ номер: <?php echo $newUserOrder['id']?></h1>
                    <p class="card-text">Имя: <?php echo $newUserOrder['name']; ?></p>
                    <p class="card-text">Номер телефона: <?php echo $newUserOrder['phone']; ?></p>
                    <p class="card-text">Город: <?php echo $newUserOrder['city']; ?></p>
                    <p class="card-text">Адрес: <?php echo $newUserOrder['address']; ?></p>
                    <p class="card-text">Комметарии: <?php echo $newUserOrder['comment']; ?></p>



                    <div class="card-text">

                        <h3>Ваш заказ: </h3>
               <?php foreach ($newUserOrder['products'] as $product): ?>

                        <p class="card-text"><?php echo $product['name']; ?></p>
                        <p class="card-text"><?php echo $product['price']; ?></p>
                        <p class="card-text"><?php echo $product['total']; ?></p>


                    </div>
                    <?php endforeach; ?>
                </div>


                <hr>

                </a>
            </div>
            <p class="card-text"><h3>Общая сумма заказа: <?php echo $userOrder['total']; ?></h3></p>

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
<?php
