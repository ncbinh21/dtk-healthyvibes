<?php

namespace Healthyvibes\Magicmenu\Model;

class Category extends \Magento\Catalog\Model\Category
{
	protected function _construct()
    {
        $this->_init('catalog/category');
    }
}
