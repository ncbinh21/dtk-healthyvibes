<?php

namespace Healthyvibes\IntegrationBase\Model\Service\Command;

use Magento\Framework\Exception\NotFoundException;
use Healthyvibes\IntegrationBase\Model\Service\CommandInterface;

interface CommandPoolInterface
{
    /**
     * Retrieves operation
     *
     * @param string $commandCode
     * @return CommandInterface
     * @throws NotFoundException
     */
    public function get($commandCode);
}
