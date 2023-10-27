<?php

namespace Healthyvibes\GiaoHangNhanh\Observer;

use Healthyvibes\GiaoHangNhanh\Model\Config;
use Healthyvibes\IntegrationBase\Model\Service\Command\CommandPoolInterface;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Exception;

/**
 * Class SaveShipmentAfterObserver
 * @package Healthyvibes\GiaoHangNhanh\Observer
 */
class SaveShipmentAfterObserver implements ObserverInterface
{
    /**
     * @var CommandPoolInterface
     */
    private $commandPool;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SaveShipmentAfterObserver constructor.
     * @param CommandPoolInterface $commandPool
     * @param LoggerInterface $logger
     */
    public function __construct(
        CommandPoolInterface $commandPool,
        LoggerInterface $logger
    ) {
        $this->commandPool = $commandPool;
        $this->logger = $logger;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @throws Exception
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $shipment = $observer->getEvent()->getShipment();
        /** @var \Magento\Sales\Model\Order $order */
        $order = $shipment->getOrder();

        if (str_contains($order->getShippingMethod(), Config::GHN_CODE)) {
            try {
                $result = $this->commandPool->get('synchronize_order')->execute([
                    'order' => $order,
                    'service_id' => $order->getShippingAddress()->getShippingServiceId()
                ]);
                $a = 1;//todo save
            } catch (Exception $e) {
                $this->logger->error($e->getMessage());
                throw new Exception(__('This shipping method isn\'t valid now. Please select another shipping method.'));
            }
        }
    }
}
