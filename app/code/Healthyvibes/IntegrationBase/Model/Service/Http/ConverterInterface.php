<?php

namespace Healthyvibes\IntegrationBase\Model\Service\Http;

/**
 * Interface ConverterInterface
 * @package Healthyvibes\IntegrationBase\Model\Service\Http
 */
interface ConverterInterface
{
    /**
     * Converts response to ENV structure
     *
     * @param mixed $response
     * @return array
     * @throws \Healthyvibes\IntegrationBase\Model\Service\Http\ConverterException
     */
    public function convert($response);
}
