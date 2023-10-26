<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Http\Converter;

use Healthyvibes\IntegrationBase\Model\Service\Http\ConverterException;
use Healthyvibes\IntegrationBase\Model\Service\Http\ConverterInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Psr\Log\LoggerInterface;

/**
 * Class JsonToArray
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Http\Converter
 */
class JsonToArray implements ConverterInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Json
     */
    private $serializer;

    /**
     * JsonToArray constructor.
     *
     * @param Json            $serializer
     * @param LoggerInterface $logger
     */
    public function __construct(
        Json $serializer,
        LoggerInterface $logger
    ) {
        $this->logger     = $logger;
        $this->serializer = $serializer;
    }

    /**
     * Converts gateway response to array structure
     *
     * @param mixed $response
     * @return array
     * @throws ConverterException
     */
    public function convert($response)
    {
        try {
            return $this->serializer->unserialize($response);
        } catch (\Exception $e) {
            $this->logger->critical('Can\'t read response from Giao Hang Nhanh');
            throw new ConverterException(__('Can\'t read response from Giao Hang Nhanh'));
        }
    }
}
