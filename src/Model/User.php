<?php
namespace Model;
class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $image;
    protected function getTableName(): string
    {
        return 'users';
    }
    public function getByEmail(string $email): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $result = $stmt->fetch();
        return $this->hydrate($result);

    }
    private function hydrate($result): self|null
    {
        if ($result === false) {
            return null;
        }
        $obj = new self();
        $obj->id = $result["id"];
        $obj->name = $result["name"];
        $obj->email = $result["email"];
        $obj->password = $result["password"];
        $obj->image = $result["image_url"];
        return $obj;
    }
    public function addUser(string $name, string $email, string $password, string $photo): array|false
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->getTableName()} (name, email, password, image_url) VALUES (:name, :email, :password, :image_url)");
        $stmt->execute([':name' => $name, ':email' => $email, ':password' => $password, 'image_url' => $photo]);
        $result = $stmt->fetch();
        return $result;
    }

    public function updateEmailByID(string $email, int $userId): void
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->getTableName()} SET email = :email WHERE id = $userId");
        $stmt->execute([':email' => $email]);
    }

    public function updateNamedByID(string $name, int $userId): void
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->getTableName()} SET name = :name WHERE id = $userId");
        $stmt->execute([':name' => $name]);
    }


    public function verification(int $userId)
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->getTableName()} WHERE id = $userId");
        $result = $stmt->fetch();

        return $this->hydrate($result);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getImage(): string
    {
        return $this->image;
    }




}