<?php declare(strict_types=1);

namespace Healthyvibes\IntegrationBase\Model\Service\Http\Client;

use Healthyvibes\IntegrationBase\Model\Service\Http\ConverterInterface;
use Magento\Framework\Webapi\Soap\ClientFactory;
use Healthyvibes\IntegrationBase\Model\Service\Http\ClientInterface;
use Healthyvibes\IntegrationBase\Model\Service\Http\TransferInterface;
use Healthyvibes\IntegrationBase\Model\Logger\Logger;

class Soap implements ClientInterface
{
    /**
     * @var ClientFactory
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
     * Soap constructor.
     * @param ClientFactory $clientFactory
     * @param Logger $logger
     * @param ConverterInterface|null $converter
     */
    public function __construct(
        ClientFactory $clientFactory,
        Logger $logger,
        ConverterInterface $converter = null
    ) {
        $this->clientFactory = $clientFactory;
        $this->logger = $logger;
        $this->converter = $converter;
    }

    /**
     * @inheritDoc
     */
    public function request(TransferInterface $transferObject)
    {
        $this->logger->debug(['request' => $transferObject->getBody()]);

        $client = $this->clientFactory->create(
            $transferObject->getClientConfig()['wsdl'],
            ['trace' => true]
        );
        try {
            $client->__setSoapHeaders($transferObject->getHeaders());

            $response = $client->__soapCall(
                $transferObject->getMethod(),
                [$transferObject->getBody()]
            );

            $result = $this->converter
                ? $this->converter->convert(
                    $response
                )
                : [$response];

            $this->logger->debug(['response' => $result]);
        } catch (\Exception $e) {
            $this->logger->debug(['trace' => $client->__getLastRequest()]);
            throw $e;
        }

        return $result;
    }
}
