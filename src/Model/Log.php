<?php

namespace Model;

class   Log extends Model
{
    protected static function getTableName(): string
    {
        return 'logs';
    }

    public static function addLog(string $message, string $file, int $line, $date): array|false
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare
        (
            "INSERT INTO $tableName (message, file, line, date ) 
                                            VALUES (:message, :file, :line, :date)"
        );
        $stmt->execute([':message' => $message, ':file' => $file, ':line' => $line, ':date' => $date]);
        $result = $stmt->fetch();
        return $result;
    }
}

