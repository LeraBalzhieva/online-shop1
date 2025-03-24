<?php

namespace Model;
abstract class Model
{
    protected static \PDO $pdo;
    public static function getPDO(): \PDO
    {
        static::$pdo= new \PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
        return static::$pdo;
    }
    abstract static protected function getTableName(): string;
}