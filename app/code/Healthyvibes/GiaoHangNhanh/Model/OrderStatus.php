<?php

namespace Healthyvibes\GiaoHangNhanh\Model;

use Magento\Sales\Model\Order;

class OrderStatus
{
    /**
     * Processing
     */
    const STATE_PROCESSING = Order::STATE_PROCESSING;
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETE = 'complete';
    const STATUS_PREPARING_STORE_LIST = ['ready_to_pick', 'picking', 'money_collect_picking', 'picked'];
    const STATUS_DELIVERY_PROCESSING_LIST = ['storing', 'transporting', 'sorting', 'delivering', 'money_collect_delivering', 'delivery_fail'];
    const STATUS_DELIVERY_FAIL_LIST = ['waiting_to_return', 'return', 'return_transporting', 'returning', 'return_fail', 'returned', 'cancel', 'exception'];
    const STATUS_DELIVERY_ERROR_LIST = ['damage', 'lost'];
    const STATUS_DELIVERY_COMPLETED_LIST = ['delivered'];

    /**
     * STATUS_PREPARING_STORE
     */
    const STATUS_PREPARING_STORE_CODE = 'preparing';
    const STATUS_PREPARING_STORE_LABEL = 'Preparing';

    /**
     * STATUS_DELIVERY_PROCESSING_LIST
     */
    const STATUS_DELIVERY_PROCESSING_CODE = 'delivery_processing';
    const STATUS_DELIVERY_PROCESSING_LABEL = 'Delivery Processing';

    /**
     * STATUS_DELIVERY_FAIL_LIST
     */
    const STATUS_DELIVERY_FAIL_CODE = 'delivery_fail';
    const STATUS_DELIVERY_FAIL_LABEL = 'Delivery Fail';

    /**
     * STATUS_DELIVERY_ERROR_LIST
     */
    const STATUS_DELIVERY_ERROR_CODE = 'delivery_error';
    const STATUS_DELIVERY_ERROR_LABEL = 'Delivery Error';

    /**
     * STATUS_DELIVERY_COMPLETED_LIST
     */
    const STATUS_DELIVERY_COMPLETED_CODE = 'delivery_completed';
    const STATUS_DELIVERY_COMPLETED_LABEL = 'Delivery Completed';
}
