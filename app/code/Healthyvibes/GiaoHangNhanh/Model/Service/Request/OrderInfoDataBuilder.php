<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Request;

use Healthyvibes\GiaoHangNhanh\Model\Service\Helper\SubjectReader;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class OrderInfoDataBuilder
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Request
 */
class OrderInfoDataBuilder extends AbstractDataBuilder
{
    /**
     * @param array $buildSubject
     * @return array
     * @throws NoSuchEntityException
     */
    public function build(array $buildSubject)
    {
        $order = SubjectReader::readOrder($buildSubject);
        return [
            self::ORDER_CODE => $order->getData('tracking_code')
        ];
    }
}
