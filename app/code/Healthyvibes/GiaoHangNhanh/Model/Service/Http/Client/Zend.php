<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Http\Client;

use Healthyvibes\IntegrationBase\Model\Logger\Logger;
use Healthyvibes\IntegrationBase\Model\Service\Http\ClientException;
use Healthyvibes\IntegrationBase\Model\Service\Http\ClientInterface;
use Healthyvibes\IntegrationBase\Model\Service\Http\ConverterException;
use Healthyvibes\IntegrationBase\Model\Service\Http\ConverterInterface;
use Healthyvibes\IntegrationBase\Model\Service\Http\TransferInterface;
use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Framework\HTTP\ZendClient;

/**
 * Class Zend
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Http\Client
 */
class Zend implements ClientInterface
{
    /**
     * @var ZendClientFactory
     */
    private $clientFactory;

    /**
     * @var ConverterInterface | null
     */
    private $converter;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param ZendClientFactory         $clientFactory
     * @param Logger                    $logger
     * @param ConverterInterface | null $converter
     */
    public function __construct(
        ZendClientFactory $clientFactory,
        Logger $logger,
        ConverterInterface $converter = null
    ) {
        $this->clientFactory = $clientFactory;
        $this->converter     = $converter;
        $this->logger        = $logger;
    }

    public function request(TransferInterface $transferObject)
    {
        $log    = [
            'request' => $this->converter ? $this->converter->convert($transferObject->getBody()) : $transferObject->getBody(),
            'request_uri' => $transferObject->getUri()
        ];
        $result = [];
        /** @var ZendClient $client */
        $client = $this->clientFactory->create();
        $header = $transferObject->getHeaders();
        $body = $this->converter->convert($transferObject->getBody());
        if (isset($body['shop_id'])) {
            $header['ShopId'] = $body['shop_id'];
        }
        $client->setConfig($transferObject->getClientConfig());
        $client->setMethod($transferObject->getMethod());
        $client->setRawData($transferObject->getBody());
        $client->setHeaders($header);
        $client->setUrlEncodeBody($transferObject->shouldEncode());
        $client->setUri($transferObject->getUri());

        try {
            $response        = $client->request();
            $result          = $this->converter ? $this->converter->convert($response->getBody()) : [$response->getBody()];
            $log['response'] = $result;
        } catch (\Zend_Http_Client_Exception $e) {
            throw new ClientException(
                __($e->getMessage())
            );
        } catch (ConverterException $e) {
            throw $e;
        } finally {
            $this->logger->debug($log);
        }

        return $result;
    }
}
