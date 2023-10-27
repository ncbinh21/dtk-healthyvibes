<?php

namespace Healthyvibes\IntegrationBase\Model\Service\Request;

/**
 * Interface BuilderInterface
 * @package Healthyvibes\IntegrationBase\Model\Service\Request
 */
interface BuilderInterface
{
    /**
     * Builds ENV request
     *
     * @param array $buildSubject
     * @return array
     */
    public function build(array $buildSubject);
}
