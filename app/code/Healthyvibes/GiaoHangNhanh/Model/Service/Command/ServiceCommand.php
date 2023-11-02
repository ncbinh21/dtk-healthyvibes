<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Command;

use Healthyvibes\IntegrationBase\Model\Service\Command;
use Healthyvibes\IntegrationBase\Model\Service\Command\CommandException;
use Healthyvibes\IntegrationBase\Model\Service\CommandInterface;
use Healthyvibes\IntegrationBase\Model\Service\Http\ClientInterface;
use Healthyvibes\IntegrationBase\Model\Service\Http\TransferFactoryInterface;
use Healthyvibes\IntegrationBase\Model\Service\Request\BuilderInterface;
use Healthyvibes\IntegrationBase\Model\Service\Response\HandlerInterface;
use Healthyvibes\IntegrationBase\Model\Service\Validator\ValidatorInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ServiceCommand
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Command
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
     * @var Command\Result\ArrayResultFactory
     */
    private $resultFactory;

    /**
     * @var string|null
     */
    protected $resultKey;

    /**
     * ServiceCommand constructor.
     * @param BuilderInterface $requestBuilder
     * @param TransferFactoryInterface $transferFactory
     * @param ClientInterface $client
     * @param LoggerInterface $logger
     * @param Command\Result\ArrayResultFactory $resultFactory
     * @param HandlerInterface|null $handler
     * @param ValidatorInterface|null $validator
     * @param null $resultKey
     */
    public function __construct(
        BuilderInterface $requestBuilder,
        TransferFactoryInterface $transferFactory,
        ClientInterface $client,
        LoggerInterface $logger,
        Command\Result\ArrayResultFactory $resultFactory,
        HandlerInterface $handler = null,
        ValidatorInterface $validator = null,
        $resultKey = null
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->transferFactory = $transferFactory;
        $this->client = $client;
        $this->handler = $handler;
        $this->validator = $validator;
        $this->logger = $logger;
        $this->resultFactory = $resultFactory;
        $this->resultKey = $resultKey;
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
                throw new CommandException(
                    __(implode("\n", $result->getFailsDescription()))
                );
            }
        }

        if ($this->handler) {
            $this->handler->handle(
                $commandSubject,
                $response
            );
        }

        if ($this->resultKey) {
            return $this->resultFactory->create(
                [
                    'array' => [
                        $this->resultKey => $response['data']
                    ]
                ]
            );
        }
    }
}
