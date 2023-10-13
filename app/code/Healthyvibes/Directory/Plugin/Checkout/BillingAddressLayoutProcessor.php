<?php

namespace Healthyvibes\Directory\Plugin\Checkout;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Checkout\Block\Checkout\LayoutProcessor;

class BillingAddressLayoutProcessor
{
    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @var
     */
    private $result;

    /**
     * BillingAddressLayoutProcessor constructor.
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * @param LayoutProcessor $subject
     * @param $result
     * @param $jsLayout
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterProcess(LayoutProcessor $subject, $result, $jsLayout)
    {
        $this->result = $result;

        $paymentConfiguration = $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
        ['payment']['children']['renders']['children'];

        $billingAddressPaymentForms = [];
        foreach ($paymentConfiguration as $payment => $config) {
            foreach ($config['methods'] as $methodCode => $paymentComponent) {
                if ($paymentComponent['isBillingAddressRequired'] === true) {
                    $billingAddressPaymentForms[] = $methodCode . '-form';
                }
            }
        }

        $paymentForms = $result['components']['checkout']['children']['steps']['children']
        ['billing-step']['children']['payment']['children']
        ['payments-list']['children'];

        $paymentMethodForms = array_keys($paymentForms);

        if (!isset($paymentMethodForms)) {
            return $result;
        }

        foreach ($paymentMethodForms as $paymentMethodForm) {
            if (!in_array($paymentMethodForm, $billingAddressPaymentForms)) {
                continue;
            }
            $paymentMethodCode = str_replace(
                '-form',
                '',
                $paymentMethodForm,
                $paymentMethodCode
            );
            $this->addField($paymentMethodForm, $paymentMethodCode);
        }
        return $this->result;
    }

    /**
     * @param $paymentMethodForm
     * @param $paymentMethodCode
     * @return $this
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function addField($paymentMethodForm, $paymentMethodCode)
    {
        $cityIdPassed = $this->result['components']['checkout']['children']['steps']['children']['billing-step']['children']
        ['payment']['children']['payments-list']['children'][$paymentMethodForm]['children']
        ['form-fields']['children']['city_id'];

        $cityIdField = [
            'component' => 'Healthyvibes_Directory/js/city',
            'config' => [
                'customScope' => 'billingAddress' . $paymentMethodCode,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'templateice' => 'ui/form/field',
                'customEntry' => 'billingAddress' . $paymentMethodCode . '.city',
            ],
            'dataScope' => 'billingAddress' . $paymentMethodCode . '.city_id',
            'label' => $cityIdPassed['label'],
            'provider' => 'checkoutProvider',
            'sortOrder' => '105',
            'validation' => ['required-entry' => true],
            'options' => $cityIdPassed['options'],
            'filterBy' => [ //exists
                'target' => '${ $.provider }:${ $.parentScope }.region_id',
                'field' => 'region_id',
            ],
            'customEntry' => null,
            'visible' => true,
            'deps' => ['checkoutProvider'],
            'imports' => [
                'initialOptions' => 'index = checkoutProvider:dictionaries.city_id',
                'setOptions' => 'index = checkoutProvider:dictionaries.city_id'
            ],
        ];

        $this->result['components']['checkout']['children']['steps']['children']['billing-step']['children']
        ['payment']['children']['payments-list']['children'][$paymentMethodForm]['children']
        ['form-fields']['children']['city_id'] = $cityIdField;

        return $this;
    }
}
