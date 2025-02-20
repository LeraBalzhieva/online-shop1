<?php
namespace Model;
class User extends Model
{
    public function getByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $result = $stmt->fetch();
        return $result;
    }

    public function updateEmailByID(string $email, int $userId)
    {

        $stmt = $this->pdo->prepare("UPDATE users SET name = :name WHERE id = $userId");
        $stmt->execute([':name' => $email]);
    }

    public function updateNamedByID(string $name, int $userId)
    {

        $stmt = $this->pdo->prepare("UPDATE users SET name = :name WHERE id = $userId");
        $stmt->execute([':name' => $name]);
    }

    public function addUser(string $name, string $email, string $password, string $photo): array|false
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, image_url) VALUES (:name, :email, :password, :image_url)");
        $stmt->execute([':name' => $name, ':email' => $email, ':password' => $password, 'image_url' => $photo]);
        $result = $stmt->fetch();
        return $result;
    }

    public function verification(int $userId)
    {
        $stmt = $this->pdo->query('SELECT * FROM users WHERE id = ' . $_SESSION['userId']);
        $result = $stmt->fetch();
        return $result;
    }


}