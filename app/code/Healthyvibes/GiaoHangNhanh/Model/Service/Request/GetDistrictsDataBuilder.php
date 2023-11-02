<?php declare(strict_types=1);

namespace Healthyvibes\GiaoHangNhanh\Model\Service\Request;

/**
 * Class GetDistrictsDataBuilder
 * @package Healthyvibes\GiaoHangNhanh\Model\Service\Request
 */
class GetDistrictsDataBuilder extends AbstractDataBuilder
{
    public function build(array $buildSubject)
    {
        return [self::TOKEN => $this->config->getValue('api_token')];
    }
}
