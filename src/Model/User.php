<?php
namespace Model;
class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $image;
    protected static function getTableName(): string
    {
        return 'users';
    }
    public static function getByEmail(string $email): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $result = $stmt->fetch();
        return static::hydrate($result);
    }
    private static function hydrate($result): self|null
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
    public static function addUser(string $name, string $email, string $password, string $photo): array|false
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("INSERT INTO $tableName (name, email, password, image_url) VALUES (:name, :email, :password, :image_url)");
        $stmt->execute([':name' => $name, ':email' => $email, ':password' => $password, 'image_url' => $photo]);
        $result = $stmt->fetch();
        return $result;
    }

    public static function updateEmailByID(string $email, int $userId): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName SET email = :email WHERE id = $userId");
        $stmt->execute([':email' => $email]);
    }

    public static function updateNamedByID(string $name, int $userId): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName name = :name WHERE id = $userId");
        $stmt->execute([':name' => $name]);
    }


    public static function verification(int $userId)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->query("SELECT * FROM $tableName WHERE id = $userId");
        $result = $stmt->fetch();

        return static::hydrate($result);
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