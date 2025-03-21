<?php

namespace Service\Logger;

class LoggerService implements LoggerInterface
{
    public function error(\Throwable $exception)
    {
        $message = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getLine();

        $date = date('Y-m-d H:i:s');

        $logMessage = "Message: $message\n" .
            "File: $file\n" .
            "Line: $line\n" .
            "Date: $date\n" .
            "___________________________\n";
        error_log($logMessage);
        file_put_contents("../Storage/Log/errors.txt", $logMessage, FILE_APPEND);
    }

}