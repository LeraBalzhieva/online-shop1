<div class="container">

        <li class="nav-item"><a class="nav-link active" href="/catalog">Каталог</a></li>


    <h3 class="text-center">Ваши заказы:</h3>

    <?php foreach ($userOrders as $newUserOrder): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Заказ номер: <?php echo $newUserOrder->getId()?></h2>
                <p class="card-text"><strong>Имя:</strong> <?php echo $newUserOrder->getName(); ?></p>
                <p class="card-text"><strong>Номер телефона:</strong> <?php echo $newUserOrder->getPhone(); ?></p>
                <p class="card-text"><strong>Город:</strong> <?php echo $newUserOrder->getCity(); ?></p>
                <p class="card-text"><strong>Адрес:</strong> <?php echo $newUserOrder->getAddress(); ?></p>
                <p class="card-text"><strong>Комментарии:</strong> <?php echo $newUserOrder->getComment(); ?></p>

                <?php foreach ($newUserOrder->getOrderProducts() as $orderProduct): ?>
                    <div class="product-item">
                        <h4 class="mt-4">Список продуктов:</h4>
                        <p class="card-text"><strong>Название продукта:</strong> <?php echo $orderProduct->getProduct()->getName(); ?></p>
                        <p class="card-text"><strong>Цена:</strong> <?php echo $orderProduct->getProduct()->getPrice(); ?> р</p>
                        <p class="card-text"><strong>Количество:</strong> <?php echo $orderProduct->getAmount(); ?> шт</p>
                    </div>
                <?php endforeach; ?>

                <hr>
                <p class="font-weight-bold">Общая сумма заказа: <span class="total-price"><?php echo $newUserOrder->getTotal(); ?> р</span></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
        color: #333;
        padding: 20px;
    }

    .nav-pills .nav-link {
        margin-right: 15px;
        border-radius: 5px;
    }

    .nav-pills .nav-link.active {
        background-color: #007bff;
        color: white;
    }

    h3 {
        margin-bottom: 20px;
        text-align: center;

    }

    .card {
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s;
        background-color: white;
    }

    .card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .product-item {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .product-item:last-child {
        border-bottom: none; /* Убираем нижнюю границу у последнего элемента */
    }

    .font-weight-bold {
        font-weight: bold;
        font-size: 1.2em;
    }

    .total-price {
        color: #28a745; /* Зеленый цвет для общей суммы */
        font-size: 1.5em; /* Увеличенный размер шрифта */
    }
</style>