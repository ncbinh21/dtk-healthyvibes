<?php

namespace Healthyvibes\IntegrationBase\Model\Service\Validator;

/**
 * Interface ValidatorInterface
 * @package Healthyvibes\IntegrationBase\Model\Service\Validator
 */
interface ValidatorInterface
{
    /**
     * Performs domain-related validation for business object
     *
     * @param array $validationSubject
     * @return ResultInterface
     */
    public function validate(array $validationSubject);
}
