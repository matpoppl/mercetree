<?php

namespace Mateusz\Mercetree\Application\Logger;

use Psr\Log\LoggerInterface;

class MockLogger implements LoggerInterface
{
    public function emergency(\Stringable|string $message, array $context = []): void
    {
        $this->log("EMERGENCY", $message, $context);
    }

    public function alert(\Stringable|string $message, array $context = []): void
    {
        $this->log("ALERT", $message, $context);
    }

    public function critical(\Stringable|string $message, array $context = []): void
    {
        $this->log("CRITICAL", $message, $context);
    }

    public function error(\Stringable|string $message, array $context = []): void
    {
        $this->log("ERROR", $message, $context);
    }

    public function warning(\Stringable|string $message, array $context = []): void
    {
        $this->log("WARNING", $message, $context);
    }

    public function notice(\Stringable|string $message, array $context = []): void
    {
        $this->log("NOTICE", $message, $context);
    }

    public function info(\Stringable|string $message, array $context = []): void
    {
        $this->log("INFO", $message, $context);
    }

    public function debug(\Stringable|string $message, array $context = []): void
    {
        $this->log("DEBUG", $message, $context);
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        file_put_contents('php://stderr', sprintf("[% 10s] %s\n", $level, $message));
    }
}
