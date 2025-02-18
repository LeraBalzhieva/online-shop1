<?php

require_once("../Model/Model.php");
class UserProduct extends Model
{
    public function getByUserProduct(int $userId)
    {

        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
        $result = $stmt->fetchAll();
        return $result;
    }

}