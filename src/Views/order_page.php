<form action="/order" method="POST">
    <div class="row">

        <div class="col-75">

            <div class="container">

                <li class="active"><a href="/cart">Назад в корзину</a></li>
                <div class="row">
                    <div class="col-50">
                        <h3>Введите данные:</h3>
                        <label for="name"><i class="fa fa-user"></i> ФИО</label>
                        <?php if (isset($errors['name'])): ?>
                            <label style="color: red"><?php echo $errors['name']; ?></label>
                        <?php endif; ?>
                        <input type="text" id="name" name="name">


                        <label for="phone"><i class="fa fa-envelope"></i> Phone</label>
                        <?php if (isset($errors['phone'])): ?>
                            <label style="color: red"><?php echo $errors['phone']; ?></label>
                        <?php endif; ?>
                        <input type="text" id="phone" name="phone">


                        <label for="city"><i class="fa fa-institution"></i> Город</label>
                        <?php if (isset($errors['city'])): ?>
                            <label style="color: red"><?php echo $errors['city']; ?></label>
                        <?php endif; ?>
                        <input type="text" id="city" name="city">


                        <label for="adr"><i class="fa fa-address-card-o"></i> Адрес</label>
                        <?php if (isset($errors['address'])): ?>
                            <label style="color: red"><?php echo $errors['address']; ?></label>
                        <?php endif; ?>
                        <input type="text" id="adr" name="address">

                        <label for="comment"><i class="fa fa-envelope"></i> comment</label>
                        <?php if (isset($errors['comment'])): ?>
                            <label style="color: red"><?php echo $errors['comment']; ?></label>
                        <?php endif; ?>
                        <input type="text" id="comment" name="comment">


                    </div>

                </div>

            </div>
        </div>

        <div class="col-25">
            <div class="container">
                <h4>Ваш заказ:
                    <span class="price" style="color:black">
          <i class="fa fa-shopping-cart"></i>

        </span>
                </h4>
                <div class="card-deck">
                    <?php foreach ($products as $product): ?>
                        <div class="card text-center">
                            <img class="card-img-top" src="<?php echo $product['image_url']; ?>" alt="Card image">
                            <div class="card-body">
                                <p class="card-text"><?php echo $product['name']; ?></p>
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
                    <h3 class="card-title"> <?php echo "ОБЩИЙ ИТОГ:" . $total . "p"; ?></h3>

                </div>
            </div>
            <button type="submit" value="Оформить заказ" class="btn">Оформить заказ</button>


        </div>


</form>
<style>

    .row {
        display: -ms-flexbox; /* IE10 */
        display: flex;
        -ms-flex-wrap: wrap; /* IE10 */
        flex-wrap: wrap;
        margin: 0 -16px;
    }

    .col-25 {
        -ms-flex: 25%; /* IE10 */
        flex: 25%;
    }

    .col-50 {
        -ms-flex: 50%; /* IE10 */
        flex: 50%;
    }

    .col-75 {
        -ms-flex: 75%; /* IE10 */
        flex: 75%;
    }

    .col-25,
    .col-50,
    .col-75 {
        padding: 0 16px;
    }

    .container {
        background-color: #f2f2f2;
        padding: 5px 20px 15px 20px;
        border: 1px solid lightgrey;
        border-radius: 3px;
    }

    input[type=text] {
        width: 100%;
        margin-bottom: 20px;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    label {
        margin-bottom: 10px;
        display: block;
    }

    .icon-container {
        margin-bottom: 20px;
        padding: 7px 0;
        font-size: 24px;
    }

    .btn {
        background-color: #4CAF50;
        color: white;
        padding: 12px;
        margin: 10px 0;
        border: none;
        width: 100%;
        border-radius: 3px;
        cursor: pointer;
        font-size: 17px;
    }

    .btn:hover {
        background-color: #45a049;
    }

    span.price {
        float: right;
        color: grey;
    }

    /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (and change the direction - make the "cart" column go on top) */
    @media (max-width: 800px) {
        .row {
            flex-direction: column-reverse;
        }

        .col-25 {
            margin-bottom: 20px;
        }
    }
</style>



