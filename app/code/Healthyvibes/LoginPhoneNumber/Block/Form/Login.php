<?php

namespace Healthyvibes\LoginPhoneNumber\Block\Form;

use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url;
use Healthyvibes\LoginPhoneNumber\Helper\Data as HelperData;
use Healthyvibes\LoginPhoneNumber\Model\Config\Source\SigninMode;

/**
 * Customer login form block
 *
 * @api
 * @since 100.0.2
 */
class Login extends \Magento\Customer\Block\Form\Login
{
    /**
     * @var \Healthyvibes\LoginPhoneNumber\Helper\Data
     */
    private $helperData;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param Url $customerUrl
     * @param HelperData $helperData
     * @param array $data
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        Url $customerUrl,
        HelperData $helperData,
        array $data = []
    ) {
        parent::__construct($context, $customerSession, $customerUrl, $data);
        $this->helperData = $helperData;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->helperData->isActive();
    }

    /**
     * @return object
     */
    public function getMode()
    {
        switch ($this->helperData->getSigninMode()) {
            case SigninMode::TYPE_PHONE:
                $mode = $this->modePhone();
                break;
            case SigninMode::TYPE_BOTH_OR:
                $mode = $this->modeBoth();
                break;
        }
        return $this->addData($mode);
    }

    /**
     * List of parameters to be used in form as phone mode.
     *
     * @return array
     */
    private function modePhone()
    {
        return [
            'note' => $this->escapeHtml(
                __('If you have an account, sign in with your phone number.')
            ),
            'label' => $this->escapeHtml(__('Phone Number')),
            'title' => $this->escapeHtmlAttr(__('Phone Number'))
        ];
    }

    /**
     * List of parameters to be used in form as phone and email mode.
     *
     * @return array
     */
    private function modeBoth()
    {
        return [
            'note' => $this->escapeHtml(
                __('If you have an account, sign in with your email address or phone number.')
            ),
            'label' => $this->escapeHtml(__('Email Address or Phone Number')),
            'title' => $this->escapeHtmlAttr(__('Email or Phone'))
        ];
    }
}
