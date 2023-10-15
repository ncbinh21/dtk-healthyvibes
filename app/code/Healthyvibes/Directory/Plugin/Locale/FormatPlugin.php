<?php

namespace Healthyvibes\Directory\Plugin\Locale;

class FormatPlugin
{
    public function afterGetNumber(\Magento\Framework\Locale\FormatInterface $subject, $result, $value)
    {
        if ($value === null) {
            return null;
        }

        if (!is_string($value)) {
            return (float)$value;
        }

        //trim spaces and apostrophes
        $value = preg_replace('/[^0-9^\^.,-]/m', '', $value);

        $separatorComa = strpos($value, ',');
        $separatorDot = strpos($value, '.');

        if ($separatorComa !== false && $separatorDot !== false) {
            if ($separatorComa > $separatorDot) {
                $value = str_replace(['.', ','], ['', '.'], $value);
            } else {
                $value = str_replace(',', '', $value);
            }
        } elseif ($separatorComa !== false) {
            $value = str_replace(',', '', $value);
        }

        return (float)$value;
    }
}
