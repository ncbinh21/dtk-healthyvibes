<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Block\Adminhtml\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Button Model Delete
 */
class Delete extends Generic implements ButtonProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getButtonData()
    {
        $message = __('Are you sure you want to delete this item?');
        $result = [];
        if ($this->getContext()->getRequestParam('id')) {
            $result = [
                'label' => __('Delete'),
                'class' => 'delete',
                'id' => 'delete-button',
                'data_attribute' => [
                    'url' => $this->getDeleteUrl(),
                ],
                'on_click' => 'deleteConfirm("' . $message . '","' . $this->getDeleteUrl() . '")',
                'sort_order' => 20,
            ];
        }
        return $result;
    }

    /**
     * Get delete url
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getContext()->getRequestParam('id')]);
    }
}
