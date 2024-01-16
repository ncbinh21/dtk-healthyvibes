<?php
declare(strict_types=1);

namespace Healthyvibes\MoneyManagement\Model;

use Healthyvibes\MoneyManagement\Api\Data\MoneyManagementInterface;
use Healthyvibes\MoneyManagement\Model\Image\FileInfo;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Money Management model
 */
class MoneyManagement extends AbstractExtensibleModel implements MoneyManagementInterface
{
    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * Init resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\MoneyManagement::class);
    }

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param StoreManagerInterface $storeManager
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        StoreManagerInterface $storeManager,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $resource,
            $resourceCollection,
            $data
        );
        $this->storeManager = $storeManager;
    }

    /**
     * Get image url
     *
     * @param null $storeId
     * @return string
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getImageUrl($storeId = null)
    {
        $url = '';
        if ($image = $this->getImage() ?: '') {
            $store = $this->storeManager->getStore($storeId);
            $mediaBaseUrl = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $url = $image[0] === '/' ? $image :
                $mediaBaseUrl . ltrim(FileInfo::ENTITY_MEDIA_PATH, '/') . '/' . $image;
        }
        return $url;
    }

    /**
     * @inheritDoc
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle(string $title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @inheritDoc
     */
    public function getPersonName()
    {
        return $this->getData(self::PERSON_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setPersonName(string $personName)
    {
        return $this->setData(self::PERSON_NAME, $personName);
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->getData(self::TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setType(string $type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * @inheritDoc
     */
    public function getMoney()
    {
        return $this->getData(self::MONEY);
    }

    /**
     * @inheritDoc
     */
    public function setMoney(string $money)
    {
        return $this->setData(self::MONEY, $money);
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setDescription(string $description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritDoc
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * @inheritDoc
     */
    public function setImage(string $image)
    {
        return $this->setData(self::IMAGE, $image);
    }
}
