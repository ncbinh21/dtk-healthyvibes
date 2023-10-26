<?php declare(strict_types=1);

namespace Healthyvibes\IntegrationBase\Model\Service\Config;

use Healthyvibes\IntegrationBase\Model\Service\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    const DEFAULT_PATH_PATTERN = 'healthyvibes_integration/%s/%s';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var string|null
     */
    private $pathPattern;

    /**
     * @var string|null
     */
    private $integrationType;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param string|null $integrationType
     * @param string $pathPattern
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        $integrationType = null,
        $pathPattern = self::DEFAULT_PATH_PATTERN
    ) {
        $this->integrationType = $integrationType;
        $this->scopeConfig = $scopeConfig;
        $this->pathPattern = $pathPattern;
    }

    /**
     * @inheritDoc
     */
    public function getValue($field, $storeId = null)
    {
        if ($this->integrationType === null || $this->pathPattern === null) {
            return null;
        }

        return $this->scopeConfig->getValue(
            sprintf($this->pathPattern, $this->integrationType, $field),
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @inheritDoc
     */
    public function isSetFlag($field, $storeId = null)
    {
        if ($this->integrationType === null || $this->pathPattern === null) {
            return null;
        }
        return $this->scopeConfig->isSetFlag(
            sprintf($this->pathPattern, $this->integrationType, $field),
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @inheritDoc
     */
    public function setPathPattern($pathPattern)
    {
        $this->pathPattern = $pathPattern;
    }

    /**
     * @inheritDoc
     */
    public function setIntegrationType($integrationCode)
    {
        $this->integrationType = $integrationCode;
    }
}
