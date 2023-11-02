<?php

namespace Healthyvibes\IntegrationBase\Model\Service;

use Healthyvibes\IntegrationBase\Model\Service\Command\CommandException;

/**
 * Interface CommandInterface
 * @package Healthyvibes\IntegrationBase\Model\Service
 */
interface CommandInterface
{
    /**
     * @param array $subject
     * @return null| Command\ResultInterface
     * @throws CommandException
     */
    public function execute(array $subject);
}
