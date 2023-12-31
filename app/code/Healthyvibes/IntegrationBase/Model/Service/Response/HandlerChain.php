<?php declare(strict_types=1);

namespace Healthyvibes\IntegrationBase\Model\Service\Response;

use Magento\Framework\ObjectManager\TMap;
use Magento\Framework\ObjectManager\TMapFactory;

class HandlerChain implements HandlerInterface
{
    /**
     * @var HandlerInterface[] | TMap
     */
    private $handlers;

    /**
     * @param TMapFactory $tmapFactory
     * @param array $handlers
     */
    public function __construct(
        TMapFactory $tmapFactory,
        array $handlers = []
    ) {
        $this->handlers = $tmapFactory->create(
            [
                'array' => $handlers,
                'type' => HandlerInterface::class
            ]
        );
    }

    /**
     * Handles response
     *
     * @param array $handlingSubject
     * @param array $response
     * @return void
     */
    public function handle(array $handlingSubject, array $response)
    {
        foreach ($this->handlers as $handler) {
            // @TODO implement exceptions catching
            $handler->handle($handlingSubject, $response);
        }
    }
}
