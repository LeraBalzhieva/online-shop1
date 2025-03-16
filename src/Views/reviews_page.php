<a href="/catalog">Назад в каталог</a>
<div class="product-info">
    <h2>О продукте</h2>
    <p>Название продукта: <?php if (isset($products)) echo $products->getName(); ?></p>
    <p>Описание: <?php if (isset($products)) echo $products->getDescription(); ?></p>
    <p>Цена: <?php if (isset($products)) echo $products->getPrice(); ?> р.</strong></p>
    <p>Средняя оценка <?php echo $averageRating; ?></p>

</div>

<h1>Отзывы о продукте</h1>
<?php if (!empty($reviews)): ?>
    <?php foreach ($reviews as $review): ?>
        <div class="review">
            <p>Отзыв номер <?php if (isset($review)) echo $review->getId(); ?></p>
            <p>Оценка: <?php if (isset($review)) echo $review->getRating(); ?></p>
            <p>Автор: </p>
            <p>Дата и время добавления отзыва: <?php if (isset($review)) echo $review->getCreatedAt(); ?></p>
            <p>Комментарий: <?php if (isset($review)) echo $review->getComment(); ?></p>
            <hr>
            <p></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Отзывов пока нет.</p>
<?php endif; ?>

<h2>Оставить отзыв</h2>
<form method="post" action="/review">
    <input type="hidden" name="product_id" value="<?php if (isset($products)) echo $products->getId(); ?>"/>

    <label for="rating">Оценка:</label>
    <select name="rating" id="rating">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
    <?php if (isset($errors['comment'])) echo $errors['comment']; ?>
    <label for="comment">Отзыв:</label>
    <textarea name="comment" id="comment"></textarea>
    <button type="submit">Отправить</button>
</form>
