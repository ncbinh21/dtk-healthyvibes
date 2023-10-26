<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Response;

use Healthyvibes\GiaoHangNhanh\Model\Service\Helper\SubjectReader;
use Healthyvibes\IntegrationBase\Model\Service\Response\HandlerInterface;
use Magento\Sales\Model\Order;

/**
 * Class SynchronizeOrderHandler
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Response
 */
class SynchronizeOrderHandler implements HandlerInterface
{
    const GHN_STATUS_FAIL = 0;
    const GHN_STATUS_SUCCESS = 1;

    /**
     * @param array $handlingSubject
     * @param array $response
     */
    public function handle(array $handlingSubject, array $response)
    {
        /** @var Order $order */
        $order = SubjectReader::readOrder($handlingSubject);
        $responseData = SubjectReader::readResponseData($response);

        if ($trackingCode = SubjectReader::readOrderCode($responseData)) {
            $order->setData('ghn_status', self::GHN_STATUS_SUCCESS);
            $order->setData('tracking_code', $trackingCode);
        } else {
            $order->setData('ghn_status', self::GHN_STATUS_FAIL);
        }
    }
}
