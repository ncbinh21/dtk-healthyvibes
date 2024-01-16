<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Model\ResourceModel\MoneyManagement;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Healthyvibes\MoneyManagement\Model\MoneyManagement;
use Healthyvibes\MoneyManagement\Model\ResourceModel\MoneyManagement as ResourceMoneyManagement;

/**
 * Class Collection
 * @package Healthyvibes\MoneyManagement\Model\ResourceModel\MoneyManagement
 */
class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(MoneyManagement::class, ResourceMoneyManagement::class);
    }
}
