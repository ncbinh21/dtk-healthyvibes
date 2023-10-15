<?php

namespace Healthyvibes\Directory\Plugin;

use Magento\Directory\Model\ResourceModel\Region\Collection as RegionCollection;

class RegionCollectionPlugin
{

    /**
     * @param RegionCollection $subject
     * @param $result
     * @return mixed
     */
    public function afterToOptionArray(RegionCollection $subject, $result)
    {
        usort($result, [$this, 'sortByRegionId']);
        return $result;
    }

    /**
     * @param $currentElement
     * @param $nextElement
     * @return int
     */
    private function sortByRegionId($currentElement, $nextElement)
    {
        if ($currentElement['value'] == $nextElement['value']) {
            return 0;
        }

        return ($currentElement['value'] < $nextElement['value']) ? -1 : 1;
    }
}
