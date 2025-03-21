<div class="container">
    <li class="active"><a href="/profile">Мой профиль</a></li>
    <li class="active"><a href="/catalog">Каталог</a></li>
    <li class="active"><a href="/order">К оформлению</a></li>

    <h3>CART</h3>
    <div class="card-deck">
        <?php if (!empty($userProducts)): ?>
            <?php foreach ($userProducts as $userProduct): ?>
                <div class="card text">
                    <img class="card-img-top" src="<?php echo $userProduct->getProduct()->getImage(); ?>" alt="Card image">
                    <div class="card-body">
                        <p class="card-text"><?php echo $userProduct->getProduct()->getName(); ?></p>
                        <p class="card-text">Количество: <?php echo $userProduct->getAmount(); ?></p>
                        <p class="card-text">Цена: <?php echo $userProduct->getProduct()->getPrice() . " р"; ?> </p>
                        <p class="card-text">Итого: <?php echo  $userProduct->getAmount() * $userProduct->getProduct()->getPrice() . " p"; ?> <br></p>
                    </div>

                    <div class="btn-group">
                        <form action="/add-product" method="POST" class="d-inline">
                            <input type="hidden" name="product_id" value="<?php echo $userProduct->getProduct()->getId(); ?>">
                            <input type="hidden" name="amount" value="1">
                            <button type="submit" class="btn btn-success">+</button>
                        </form>
                        <form action="/decrease-product" method="POST" class="d-inline">
                            <input type="hidden" name="product_id" value="<?php echo $userProduct->getProduct()->getId(); ?>">
                            <button type="submit" class="btn btn-danger">-</button>
                        </form>
                    </div>

                </div>
            <?php endforeach; ?>
<br>
            <br><h3>Общая сумма заказа: <?php echo $userProduct->getTotal() ?> руб.</h3>
        <?php else: ?>
            <p>Корзина пуста.</p>
        <?php endif; ?>
    </div>

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

        .card-deck {
            display: flex; /* Используем flexbox для расположения карточек */
            flex-wrap: wrap; /* Позволяет карточкам переноситься на следующую строку */
            justify-content: space-between; /* Распределяем карточки по строке */
        }

        .card {
            flex: 0 1 calc(33.333% - 10px); /* Устанавливаем ширину карточки на 1/3 (33.333%) с отступом */
            margin-bottom: 20px; /* Отступ снизу для карточек */
            box-sizing: border-box; /* Учитываем отступы и границы в ширине */
        }

        .card:hover {
            box-shadow: 1px 2px 10px lightgray;
            transition: 0.3s;
        }

        .btn-group {
            display: flex; /* Используем flexbox для горизонтального расположения кнопок */
            justify-content: center; /* Центрируем кнопки */
            margin-top: 10px; /* Отступ сверху */
        }

        .btn {
            margin: 0 5px; /* Отступы между кнопками */
        }
    </style>
</div>