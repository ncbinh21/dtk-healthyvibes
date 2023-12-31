<?php

namespace Healthyvibes\FacebookChat\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_FB_MESSENGER_ENABLE = 'messenger/general/enable';
    const XML_FB_APP_ID = 'messenger/general/app_id';
    const XML_FB_PAGE_ID = 'messenger/general/page_id';
    const XML_FB_COLOR = 'messenger/general/color_option';
    const XML_FB_LOGIN_TEXT = 'messenger/general/login_message';
    const XML_FB_LOGOUT_TEXT = 'messenger/general/logout_message';
    const XML_FB_GREETING_DIALOG_DISPLAY = 'messenger/general/greeting_dialog_display';
    const XML_FB_GREETING_DIALOG_DELAY = 'messenger/general/greeting_dialog_delay';

    /**
     * Asset service
     *
     * @var \Magento\Framework\View\Asset\Repository
     */

    protected $_assetRepo;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\View\Asset\Repository $assetRepo
    ) {
        $this->_assetRepo = $assetRepo;
        parent::__construct($context);
    }

    public function getJsUrl() : string
    {
        return $this->_assetRepo->getUrl("Healthyvibes_FacebookChat::js/customerchat.js");
    }

    public function isEnable($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_FB_MESSENGER_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getFBAppId($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_FB_APP_ID,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
    public function getFBPageId($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_FB_PAGE_ID,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
    public function getFBColor($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_FB_COLOR,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
    public function getFBLoginText($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_FB_LOGIN_TEXT,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
    public function getFBLogoutText($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_FB_LOGOUT_TEXT,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getFBGreetingDialogDisplay($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_FB_GREETING_DIALOG_DISPLAY,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getFBGreetingDialogDelay($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_FB_GREETING_DIALOG_DELAY,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
