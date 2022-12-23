<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Api\Data;

/**
 * Customer socical account interface.
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface SocialAccountInterface extends \Magento\Framework\Api\CustomAttributesDataInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'entity_id';
    const CUSTOMER_ID = 'customer_id';
    const OPENID = 'openid';
    const UNIOIONID = 'unionid';
    const APPLICATION = 'application';
    const PLATFORM = 'platform';
    const UNIQUE_HASH = 'unique_hash';
    const ADDITIONAL_DATA = 'additional_data';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get customer ID
     *
     * @return int|null
     */
    public function getCustomerId();

    /**
     * Set customer ID
     *
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * Get openId
     *
     * @return string|null
     */
    public function getOpenId();

    /**
     * Set openId
     *
     * @param int $openId
     * @return $this
     */
    public function setOpenId($openId);

    /**
     * Get Union Id
     *
     * @return string|null
     */
    public function getUnionId();

    /**
     * Set Union Id
     *
     * @param string $unionId
     * @return $this
     */
    public function setUnionId($unionId);

    /**
     * Get application
     *
     * @return string|null
     */
    public function getApplication();

    /**
     * Set appliction
     *
     * @param string $appliction
     * @return $this
     */
    public function setApplication($application);

    /**
     * Get platform
     *
     * @return string|null
     */
    public function getPlatform();

    /**
     * Set paltform
     *
     * @param string $platform
     * @return $this
     */
    public function setPlatform($platform);

    /**
     * Get unique hash.
     *
     * @return string
     */
    public function getUniqueHash();

    /**
     * Set unique hash.
     *
     * @param string $uniqueHash
     * @return $this
     */
    public function setUniqueHash($uniqueHash);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \AlbertMage\Customer\Api\Data\SocialAccountExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \AlbertMage\Customer\Api\Data\SocialAccountExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\AlbertMage\Customer\Api\Data\SocialAccountExtensionInterface $extensionAttributes);
}
