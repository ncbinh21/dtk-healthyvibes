<?php

namespace Healthyvibes\IntegrationBase\Model\Service\Command;

interface ResultInterface
{
    /**
     * Returns result interpretation
     *
     * @return array
     */
    public function get();
}
