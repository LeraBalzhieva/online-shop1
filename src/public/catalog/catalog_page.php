<div class="container">
    <li class="active"><a href="/profile">Мой профиль</a></li>
    <li class="active"><a href="/cart">Корзина</a></li>

    <h3>Catalog</h3>
    <div class="card-deck">
        <?php foreach ($products as $product): ?>
            <div class="card text-center">
                    <img class="card-img-top" src="<?php echo $product['image_url']; ?>" alt="Card image">
                    <div class="card-body">
                        <p class="card-text text-muted"><?php echo $product['name']; ?></p>
                        <h5 class="card-title"><?php echo $product['description']; ?></h5></a>
                        <div class="card-footer">
                            <?php echo "Цена:"; ?>
                            <?php echo $product['price'] . "р";  ?>
                        </div>
                    </div>
                </a>
            </div>
            <form action="/add-product" method="POST">
                <div class="container">
                   <input type="hidden" placeholder="Enter product id" name="product_id" value="<?php echo $product['id'];  ?>" id=product_id">

                    <label for="amount"><b>Введите количество:</b></label>
                    <?php if (isset($errors['amount'])):  ?>
                        <label style="color: red"><?php echo $errors['amount'];?></label>
                    <?php endif; ?>
                    <input type="text" placeholder="Количество" name="amount" id="amount" >

                    <button type="submit" class="registerbtn" >Добавить в корзину</button>

                    <hr>
                </div>
                <div class="container signin">

                </div>
                </form>

        <? endforeach; ?>


        <style>
            body {
                font-style: sans-serif;
                text-align: -webkit-match-parent;
            }

            a {
                text-decoration: none;

            }

            a:hover {
                text-decoration: none;

            }

            h3 {
                line-height: 5em;

            }

            .card {
                max-width: 25rem;
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

            .card-footer{
                font-weight: bold;
                font-size: 15px;
                background-color: white;
                text-align: center;
            }
        </style>

