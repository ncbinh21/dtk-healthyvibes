<?php

namespace Healthyvibes\LoginPhoneNumber\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Configuration class.
 */
class Data extends AbstractHelper
{
    const PHONE_NUMBER = 'phone_number';
    /**
     * Is module active
     *
     * @param string|null $scopeCode
     * @return bool
     */
    public function isActive($scopeCode = null)
    {
        return (bool) $this->scopeConfig->isSetFlag(
            'healthyvibes_signin_phone_number/module/enabled',
            ScopeInterface::SCOPE_STORE,
            $scopeCode
        );
    }

    /**
     * Sign in mode.
     *
     * @param string|null $scopeCode
     * @return string
     */
    public function getSigninMode($scopeCode = null)
    {
        return $this->scopeConfig->getValue(
            'healthyvibes_signin_phone_number/options/mode',
            ScopeInterface::SCOPE_STORE,
            $scopeCode
        );
    }

    /**
     * Get if customer accounts are shared per website.
     *
     * @see \Magento\Customer\Model\Config\Share
     * @param string|null $scopeCode
     * @return string
     */
    public function getCustomerShareScope($scopeCode = null)
    {
        return $this->scopeConfig->getValue(
            \Magento\Customer\Model\Config\Share::XML_PATH_CUSTOMER_ACCOUNT_SHARE,
            ScopeInterface::SCOPE_STORE,
            $scopeCode
        );
    }
}
