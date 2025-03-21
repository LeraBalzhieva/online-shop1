<?php

namespace Service\Logger;
use Model\Log;
class DatabaseLoggerService implements LoggerInterface
{
    private Log $logger;
    public function __construct()
    {
        $this->logger = new Log();
    }
    public function error(\Throwable $exception) {
        $this->logger->addLog($exception->getMessage(), $exception->getFile(), $exception->getLine(), date('Y-m-d H:i:s'));
    }
}

