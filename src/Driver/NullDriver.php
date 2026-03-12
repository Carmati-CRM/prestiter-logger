<?php

declare(strict_types=1);

namespace Prestiter\Logger\Driver;

use Prestiter\Logger\DriverInterface;
use Prestiter\Logger\LogEntry;

/**
 * Null driver that does nothing.
 * Useful for testing environments.
 */
final class NullDriver implements DriverInterface
{
    public function send(LogEntry $entry): void
    {
        // Intentionally does nothing
    }
}
