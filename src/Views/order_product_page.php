
<div class="container">
    <li class="active"><a href="/catalog">Каталог</a></li>
    <li class="active"><a href="/order">К оформлению</a></li>

    <h3>Ваш заказ:</h3>
    <div>
        <?php foreach ($userOrders as $newUserOrder): ?>
            <div class="card text-center">

                <div class="card-body">
                    <h2>Заказ номер: <?php echo $newUserOrder->getId()?></h2>
                    <p class="card-text">Имя: <?php echo $newUserOrder->getName(); ?></p>
                    <p class="card-text">Номер телефона: <?php echo $newUserOrder->getPhone(); ?></p>
                    <p class="card-text">Город: <?php echo $newUserOrder->getCity(); ?></p>
                    <p class="card-text">Адрес: <?php echo $newUserOrder->getAddress(); ?></p>
                    <p class="card-text">Комметарии: <?php echo $newUserOrder->getComment(); ?></p>

                    <div class="card-text">

                        <h3>Ваш заказ: </h3>
               <?php foreach ($newOrderProducts as $newOrderProduct): ?>

                        <p class="card-text"><?php echo $newOrderProduct->getProduct()->getName(); ?></p>
                        <p class="card-text">Цена: <?php echo $newOrderProduct->getProduct()->getPrice(); ?> р</p>
                        <p class="card-text">Количество: <?php echo $newOrderProduct->getAmount(); ?> шт</p>

                    </div>
                    <?php endforeach; ?>
                </div>
                <hr>
                </a>
            </div>
          <p class="card-text"><h3>Общая сумма заказа: <?php echo $totalSum; ?> р</h3></p>

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
