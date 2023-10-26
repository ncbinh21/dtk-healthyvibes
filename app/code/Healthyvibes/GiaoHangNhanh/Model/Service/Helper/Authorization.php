<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Helper;

use Magento\Framework\Serialize\SerializerInterface;
use Healthyvibes\IntegrationBase\Model\Service\ConfigInterface;

/**
 * Class Authorization
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Helper
 */
class Authorization
{
    /**
     * @var string
     */
    protected $params;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * Authorization constructor.
     * @param SerializerInterface $serializer
     * @param ConfigInterface $config
     */
    public function __construct(
        SerializerInterface $serializer,
        ConfigInterface $config
    ) {
        $this->serializer = $serializer;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getParameter()
    {
        return $this->params;
    }

    /**
     * @param $params
     * @return $this
     */
    public function setParameter($params)
    {
        $this->params = $this->serializer->serialize($params);
        return $this;
    }

    /**
     * @param $params
     * @return bool|string
     */
    public function getBody($params)
    {
        return $this->serializer->serialize($params);
    }

    /**
     * Get Header
     *
     * @return array
     */
    public function getHeaders()
    {
        return [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($this->getParameter()),
            'Token: ' . $this->getToken()
        ];
    }

    /**
     * @return mixed|string
     */
    protected function getToken()
    {
        return $this->config->getValue('api_token');
    }
}
