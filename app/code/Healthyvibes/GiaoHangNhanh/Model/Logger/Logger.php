<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Logger;

use Healthyvibes\IntegrationBase\Model\Logger\Logger as BaseLogger;

/**
 * Class Logger
 * @package Healthyvibes\GiaoHangNhanh\Model\Logger
 */
class Logger extends BaseLogger
{
    /**
     * @param array $debugData
     * @param array $debugReplacePrivateDataKeys
     * @return array
     */
    protected function filterDebugData(array $debugData, array $debugReplacePrivateDataKeys)
    {
        foreach (array_keys($debugData) as $key) {
            if (in_array($key, $debugReplacePrivateDataKeys)) {
                $debugData[$key] = self::DEBUG_KEYS_MASK;
            } elseif (is_array($debugData[$key])) {
                $debugData[$key] = $this->filterDebugData($debugData[$key], $debugReplacePrivateDataKeys);
            }
        }
        return $debugData;
    }
}
