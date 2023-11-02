<?php

namespace Healthyvibes\IntegrationBase\Model\Service\Http;

/**
 * Interface ClientInterface
 * @package Healthyvibes\IntegrationBase\Model\Service\Http
 */
interface ClientInterface
{
    /**
     * Making request. Returns result as ENV array
     *
     * @param \Healthyvibes\IntegrationBase\Model\Service\Http\TransferInterface $transferObject
     * @return array
     * @throws \Healthyvibes\IntegrationBase\Model\Service\Http\ClientException
     * @throws \Healthyvibes\IntegrationBase\Model\Service\Http\ConverterException
     */
    public function request(\Healthyvibes\IntegrationBase\Model\Service\Http\TransferInterface $transferObject);
}
