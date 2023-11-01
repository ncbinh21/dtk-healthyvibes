<?php

namespace Healthyvibes\GiaoHangNhanh\Observer;

use Exception;
use Healthyvibes\GiaoHangNhanh\Model\Config;
use Healthyvibes\GiaoHangNhanh\Model\Service\Request\AbstractDataBuilder;
use Healthyvibes\IntegrationBase\Model\Service\Command\CommandPoolInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order\Shipment\TrackFactory;
use Healthyvibes\GiaoHangNhanh\Model\Carrier\GHN\Express;
use Magento\Sales\Api\Data\ShipmentTrackInterface;
use Psr\Log\LoggerInterface;

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
     * @var TrackFactory
     */
    private $trackFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SaveShipmentAfterObserver constructor.
     * @param CommandPoolInterface $commandPool
     * @param TrackFactory $trackFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        CommandPoolInterface $commandPool,
        TrackFactory $trackFactory,
        LoggerInterface $logger
    ) {
        $this->commandPool = $commandPool;
        $this->trackFactory = $trackFactory;
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
                if ($result && $data = $result->get()) {
                    if (isset($data['create_order'][AbstractDataBuilder::ORDER_CODE])) {
                        $data = [
                            ShipmentTrackInterface::CARRIER_CODE => Express::SERVICE_CODE,
                            ShipmentTrackInterface::TITLE => Express::SERVICE_NAME,
                            ShipmentTrackInterface::TRACK_NUMBER => $data['create_order'][AbstractDataBuilder::ORDER_CODE],
                        ];
                        $track = $this->trackFactory->create()->addData($data);
                        $shipment->addTrack($track)->save();
                    }
                }
            } catch (Exception $e) {
                $this->logger->error($e->getMessage());
                throw new Exception(__('We can\'t create shipment on GHN system. Please contact with admin.'));
            }
        }
    }
}
