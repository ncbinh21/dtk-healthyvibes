<?php declare(strict_types=1);

namespace Healthyvibes\IntegrationBase\Model\Service\Command\Result;

use Healthyvibes\IntegrationBase\Model\Service\Command\ResultInterface;

/**
 * Container for array that should be returned as command result.
 *
 * @api
 */
class BoolResult implements ResultInterface
{
    /**
     * @var array
     */
    private $result;

    /**
     * Constructor
     *
     * @param bool $result
     */
    public function __construct($result = true)
    {
        $this->result = $result;
    }

    /**
     * Returns result interpretation
     *
     * @return mixed
     */
    public function get()
    {
        return (bool) $this->result;
    }
}
