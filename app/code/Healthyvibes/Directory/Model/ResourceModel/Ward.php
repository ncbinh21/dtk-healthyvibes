<?php

namespace Healthyvibes\Directory\Model\ResourceModel;


class Ward extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('healthyvibes_directory_region_ward', 'ward_id');
    }

    /**
     * @param $wardId
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function loadById($wardId)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            ['ward' => $this->getMainTable()]
        )->where(
            'ward.ward_id = ?',
            $wardId
        );

        return $connection->fetchRow($select);
    }
}
