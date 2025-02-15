<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


if (!isset($_SESSION['userId']))
    {

    header('Location: login.php');
    exit();
    } else {

    $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
    $stmt = $pdo->query("SELECT * FROM user_products WHERE user_id = {$_SESSION['userId']}");
    $userProducts = $stmt->fetchAll();

    $products = [];
    foreach ($userProducts as $userProduct) {
        $productId = $userProduct['product_id'];
        $productStmt = $pdo->query("SELECT * FROM products WHERE id = $productId");
        $product = $productStmt->fetch();
        $product['amount'] = $userProduct['amount'];
        $products[] = $product;

    }
}
?>
<div class="container">
    <li class="active"><a href="/profile">Мой профиль</a></li>
    <li class="active"><a href="catalog">Каталог</a></li>

    <h3>CART</h3>
    <div class="card-deck">
        <?php foreach ($products as $product): ?>
            <div class="card text-center">
                <img class="card-img-top" src="<?php echo $product['image_url']; ?>" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"><?php echo $product['name']; ?></p>
                    <h5 class="card-title"><?php echo $product['description']; ?></h5></a>
                    <div class="card-footer">
                        <?php echo "Цена:" . $product['price'] . "р";  ?> <br>
                        <?php echo "Количество: " . $product['amount'] . "шт";  ?> <br>
                        <?php echo "Итого:" . $product['amount'] * $product['price'] . "p"; ?>

                    </div>
                </div>

                </a>
            </div>

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


