<?php

namespace Model;

class   Log extends Model
{
    protected function getTableName(): string
    {
        return 'logs';
    }

    public function addLog(string $message, string $file, int $line, $date): array|false
    {
        $stmt = $this->pdo->prepare
        (
            "INSERT INTO {$this->getTableName()} (message, file, line, date ) 
                                            VALUES (:message, :file, :line, :date)"
        );
        $stmt->execute([':message' => $message, ':file' => $file, ':line' => $line, ':date' => $date]);
        $result = $stmt->fetch();
        return $result;
    }
}

