<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Resource Model MoneyManagement
 */
class MoneyManagement extends AbstractDb
{
    const MONEY_MANAGEMENT_TABLE = 'healthyvibes_money_management';
    const ENTITY_ID = 'entity_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(self::MONEY_MANAGEMENT_TABLE, self::ENTITY_ID);
    }
}
