<?php
function validate(array $data): array
{
    $errors = [];
// объявление и валидация данных
    if (isset($data['product_id'])) {
        $product_id = $data['product_id'];
        if ($product_id < 1)  {
            $errors['product_id'] = "Id не может быть отрицательным";
        }
    } else {
        $errors['product_id'] = "Строка должна быть заполнена";
    }

    if (isset($data['amount'])) {
        $amount = $data['amount'];
        if (($amount) < 1) || (($amount) > 100) {
            $errors['amount'] = "Количество не может быть отрицательным и больше 100";
        }
    } else {
        $errors['amount'] = "Строка должна быть заполнена";
    }
    return $errors;
}

$errors = validate($_POST);

print_r($errors);

if (empty($errors)) {
    session_start();
    //if (!isset($_SESSION['userId'])) {
      //  http_response_code(404);
        //require_once './404.php';
    //}
    $userId = $_SESSION['userId'];
    $product_id = $_POST['product_id'];
    $amount = $_POST['amount'];


    $pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
    $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
    $stmt->execute([':user_id' => $userId, ':product_id' => $product_id, ':amount' => $amount]);

    $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $userId]);
    $result = $stmt->fetch();
    print_r ($result);

}
require_once './add_product_form.php';

