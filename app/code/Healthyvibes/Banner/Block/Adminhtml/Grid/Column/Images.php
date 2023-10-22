<?php

namespace Healthyvibes\Banner\Block\Adminhtml\Grid\Column;

class Images extends \Magento\Backend\Block\Widget\Grid\Column
{

    /**
     * StoreManager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Images constructor.
     *
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager storeManager
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    /**
     * Add to column decorated status
     *
     * @return array
     */
    public function getFrameCallback()
    {
        return [$this, 'imageValue'];
    }

    /**
     * Decorate status column values
     *
     * @param string                                 $value value
     * @param \Magento\Framework\Model\AbstractModel $row   row
     *
     * @return string
     */
    public function imageValue($value, $row)
    {
        $type = $row->getBannerType();

        if ($value) {
            $mediaUrl = $this->storeManager
                ->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            $cell = '<img src="'.$mediaUrl.$value.'" alt="'.$row->getTitle().'" height="100"/>';
            return $cell;
        } elseif ($type == 'Youtube') {
            $cell = $row->getBannerYoutube();
            return $cell;
        } elseif ($type == 'Video') {
            $cell = $row->getBannerVideo();
            return $cell;
        } elseif ($type == 'Vimeo') {
            $cell = $row->getBannerVimeo();
            return $cell;
        }
    }
}
