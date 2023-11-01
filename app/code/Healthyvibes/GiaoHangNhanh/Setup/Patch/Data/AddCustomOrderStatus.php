<?php

namespace Healthyvibes\GiaoHangNhanh\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Sales\Model\Order\StatusFactory;
use Magento\Sales\Model\ResourceModel\Order\StatusFactory as StatusResourceFactory;
use Healthyvibes\GiaoHangNhanh\Model\OrderStatus;

class AddCustomOrderStatus implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * Status Factory
     *
     * @var StatusFactory
     */
    private $statusFactory;

    /**
     * Status Resource Factory
     *
     * @var StatusResourceFactory
     */
    private $statusResourceFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        StatusFactory $statusFactory,
        StatusResourceFactory $statusResourceFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->statusFactory = $statusFactory;
        $this->statusResourceFactory = $statusResourceFactory;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->addNewOrderStateAndStatus();

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @throws \Exception
     */
    protected function addNewOrderStateAndStatus()
    {
        $orderStatus = [
            [
                'code' => OrderStatus::STATUS_PREPARING_STORE_CODE,
                'label' => OrderStatus::STATUS_PREPARING_STORE_LABEL,
                'state' => OrderStatus::STATE_PROCESSING
            ],
            [
                'code' => OrderStatus::STATUS_DELIVERY_PROCESSING_CODE,
                'label' => OrderStatus::STATUS_DELIVERY_PROCESSING_LABEL,
                'state' => OrderStatus::STATE_PROCESSING
            ],
            [
                'code' => OrderStatus::STATUS_DELIVERY_FAIL_CODE,
                'label' => OrderStatus::STATUS_DELIVERY_FAIL_LABEL,
                'state' => OrderStatus::STATE_PROCESSING
            ],
            [
                'code' => OrderStatus::STATUS_DELIVERY_ERROR_CODE,
                'label' => OrderStatus::STATUS_DELIVERY_ERROR_LABEL,
                'state' => OrderStatus::STATE_PROCESSING
            ],
            [
                'code' => OrderStatus::STATUS_DELIVERY_COMPLETED_CODE,
                'label' => OrderStatus::STATUS_DELIVERY_COMPLETED_LABEL,
                'state' => OrderStatus::STATE_PROCESSING
            ]
        ];

        foreach ($orderStatus as $status) {
            $this->addStatus(
                $status['code'],
                $status['label'],
                $status['state']
            );
        }
    }

    /**
     * @param $code
     * @param $label
     * @param $state
     * @param false $isDefault
     * @param bool $visibleonFront
     * @throws \Exception
     */
    protected function addStatus($code, $label, $state = OrderStatus::STATE_PROCESSING, $isDefault = false, $visibleonFront = true)
    {
        $statusResource = $this->statusResourceFactory->create();
        $status = $this->statusFactory->create();
        $status->setData([
            'status' => $code,
            'label' => $label,
        ]);

        try {
            $statusResource->save($status);
        } catch (\Exception $e) {
            return;
        }
        $status->assignState($state, $isDefault, $visibleonFront);
    }
}
