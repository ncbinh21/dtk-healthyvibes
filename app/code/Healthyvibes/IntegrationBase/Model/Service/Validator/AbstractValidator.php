<?php declare(strict_types=1);

namespace Healthyvibes\IntegrationBase\Model\Service\Validator;

use Healthyvibes\IntegrationBase\Model\Service\Validator\ResultInterfaceFactory;

/**
 * Class AbstractValidator
 * @package Healthyvibes\IntegrationBase\Model\Service\Validator
 */
abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * @var ResultInterfaceFactory
     */
    private $resultInterfaceFactory;

    /**
     * @param ResultInterfaceFactory $resultFactory
     */
    public function __construct(
        ResultInterfaceFactory $resultFactory
    ) {
        $this->resultInterfaceFactory = $resultFactory;
    }

    /**
     * Factory method
     *
     * @param bool $isValid
     * @param array $fails
     * @param array $errorCodes
     * @return \Magento\Payment\Gateway\Validator\ResultInterface
     */
    protected function createResult($isValid, array $fails = [], array $errorCodes = [])
    {
        return $this->resultInterfaceFactory->create(
            [
                'isValid' => (bool)$isValid,
                'failsDescription' => $fails,
                'errorCodes' => $errorCodes
            ]
        );
    }
}
