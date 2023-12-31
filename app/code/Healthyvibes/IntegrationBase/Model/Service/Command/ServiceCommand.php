<?php declare(strict_types=1);

namespace Healthyvibes\IntegrationBase\Model\Service\Command;

use Healthyvibes\IntegrationBase\Model\Service\CommandInterface;
use Healthyvibes\IntegrationBase\Model\Service\Http\ClientInterface;
use Healthyvibes\IntegrationBase\Model\Service\Http\TransferFactoryInterface;
use Healthyvibes\IntegrationBase\Model\Service\Request\BuilderInterface;
use Healthyvibes\IntegrationBase\Model\Service\Response\HandlerInterface;
use Healthyvibes\IntegrationBase\Model\Service\Validator\ValidatorInterface;
use Healthyvibes\IntegrationBase\Model\Service\Validator\ResultInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ServiceCommand
 * @package Healthyvibes\IntegrationBase\Model\Service\Command
 */
class ServiceCommand implements CommandInterface
{
    /**
     * @var BuilderInterface
     */
    private $requestBuilder;

    /**
     * @var TransferFactoryInterface
     */
    private $transferFactory;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var HandlerInterface
     */
    private $handler;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * ServiceCommand constructor.
     * @param BuilderInterface $requestBuilder
     * @param TransferFactoryInterface $transferFactory
     * @param ClientInterface $client
     * @param LoggerInterface $logger
     * @param HandlerInterface|null $handler
     * @param ValidatorInterface|null $validator
     */
    public function __construct(
        BuilderInterface $requestBuilder,
        TransferFactoryInterface $transferFactory,
        ClientInterface $client,
        LoggerInterface $logger,
        HandlerInterface $handler = null,
        ValidatorInterface $validator = null
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->transferFactory = $transferFactory;
        $this->client = $client;
        $this->handler = $handler;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function execute(array $commandSubject)
    {
        $transferO = $this->transferFactory->create(
            $this->requestBuilder->build($commandSubject)
        );
        $response = $this->client->request($transferO);
        if ($this->validator !== null) {
            $result = $this->validator->validate(
                array_merge($commandSubject, ['response' => $response])
            );
            if (!$result->isValid()) {
                $this->processErrors($result);
            }
        }

        if ($this->handler) {
            $this->handler->handle(
                $commandSubject,
                $response
            );
        }
    }

    private function processErrors(ResultInterface $result)
    {
        $messages = [];
        $errorsSource = array_merge($result->getErrorCodes(), $result->getFailsDescription());
    }
}
