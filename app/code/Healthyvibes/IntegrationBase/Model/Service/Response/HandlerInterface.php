<?php

namespace Healthyvibes\IntegrationBase\Model\Service\Response;

/**
 * Interface HandlerInterface
 * @package Healthyvibes\IntegrationBase\Model\Service\Response
 */
interface HandlerInterface
{
    /**
     * Handles response
     *
     * @param array $handlingSubject
     * @param array $response
     * @return void
     */
    public function handle(array $handlingSubject, array $response);
}
