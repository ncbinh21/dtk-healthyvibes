<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Response;

use Healthyvibes\GiaoHangNhanh\Model\Service\Helper\SubjectReader;
use Healthyvibes\IntegrationBase\Model\Service\Response\HandlerInterface;
use Magento\Sales\Model\Order;

/**
 * Class CancelOrderHandler
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Response
 */
class CancelOrderHandler implements HandlerInterface
{
    const GHN_SUCCESS_CANCELING_STATUS = 1;

    /**
     * @param array $handlingSubject
     * @param array $response
     */
    public function handle(array $handlingSubject, array $response)
    {
        /** @var Order $order */
        $order = SubjectReader::readOrder($handlingSubject);
        $order->setData('ghn_canceling_status', self::GHN_SUCCESS_CANCELING_STATUS);
    }
}
