<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Validator;

use Healthyvibes\IntegrationBase\Model\Service\ConfigInterface;
use Healthyvibes\IntegrationBase\Model\Service\Validator\AbstractValidator;
use Healthyvibes\IntegrationBase\Model\Service\Validator\ResultInterfaceFactory;

/**
 * Class AbstractResponseValidator
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Validator
 */
abstract class AbstractResponseValidator extends AbstractValidator
{
    const MESSAGE = 'message';
    const SUCCESS_MESSAGE = 'Success';

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * AbstractResponseValidator constructor.
     * @param ResultInterfaceFactory $resultFactory
     * @param ConfigInterface|null $config
     */
    public function __construct(
        ResultInterfaceFactory $resultFactory,
        ConfigInterface $config = null
    ) {
        parent::__construct($resultFactory);
        $this->config = $config;
    }

    /**
     * @param array $response
     * @return bool
     */
    protected function validateResponseMsg(array $response)
    {
        return isset($response[self::MESSAGE]) && $response[self::MESSAGE] === self::SUCCESS_MESSAGE;
    }
}
