<?php

namespace Healthyvibes\IntegrationBase\Model\Service\Http;

/**
 * Interface TransferFactoryInterface
 * @package Healthyvibes\IntegrationBase\Model\Service\Http
 * @api
 */
interface TransferFactoryInterface
{
    /**
     * Builds gateway transfer object
     *
     * @param array $request
     * @return TransferInterface
     */
    public function create(array $request);
}
