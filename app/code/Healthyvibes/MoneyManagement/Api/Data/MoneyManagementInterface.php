<?php

namespace Healthyvibes\MoneyManagement\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface MoneyManagementInterface
 */
interface MoneyManagementInterface extends ExtensibleDataInterface
{
    const ENTITY_ID = "entity_id";
    const TITLE = "title";
    const PERSON_NAME = "person_name";
    const TYPE = "type";
    const MONEY = "money";
    const DESCRIPTION = "description";
    const IMAGE = "image";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    /**
     * Get Entity ID
     *
     * @return int|null
     */
    public function getEntityId();

    /**
     * Set Entity ID
     *
     * @param int $entityId
     * @return $this
     */
    public function setEntityId(int $entityId);

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title);

    /**
     * Get person name
     *
     * @return string|null
     */
    public function getPersonName();

    /**
     * Set person name
     *
     * @param string $personName
     * @return $this
     */
    public function setPersonName(string $personName);

    /**
     * Get type
     *
     * @return string|null
     */
    public function getType();

    /**
     * Set type
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type);

    /**
     * Get money
     *
     * @return string|null
     */
    public function getMoney();

    /**
     * Set money
     *
     * @param string $money
     * @return $this
     */
    public function setMoney(string $money);

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription();

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description);

    /**
     * Get image
     *
     * @return string|null
     */
    public function getImage();

    /**
     * Set image
     *
     * @param string $image
     * @return $this
     */
    public function setImage(string $image);
}
