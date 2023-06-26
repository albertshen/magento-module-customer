<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlbertMage\Customer\Api\Data;

/**
 * Customer address interface.
 * @api
 * @since 100.0.2
 */
interface AddressInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const REGION = 'region';
    const REGION_CODE = 'region_code';
    const CITY = 'city';
    const CITY_CODE = 'city_code';
    const DISTRICT = 'district';
    const DISTRICT_CODE = 'district_code';
    const STREET = 'street';
    const TELEPHONE = 'telephone';
    const POSTCODE = 'postcode';
    const FIRSTNAME = 'firstname';
    const LASTNAME = 'lastname';
    const DEFAULT_SHIPPING = 'default_shipping';
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
     * Get region
     *
     * @return string|null
     */
    public function getRegion();

    /**
     * Set region
     *
     * @param string $region
     * @return $this
     */
    public function setRegion($region);

    /**
     * Get region Code
     *
     * @return int|null
     */
    public function getRegionCode();

    /**
     * Set region Code
     *
     * @param int $regionCode
     * @return $this
     */
    public function setRegionCode($regionCode);

    /**
     * Get city name
     *
     * @return string|null
     */
    public function getCity();

    /**
     * Set city name
     *
     * @param string $city
     * @return $this
     */
    public function setCity($city);

    /**
     * Get city Code
     *
     * @return int|null
     */
    public function getCityCode();

    /**
     * Set city Code
     *
     * @param int $cityCode
     * @return $this
     */
    public function setCityCode($cityCode);

    /**
     * Get district name
     *
     * @return string|null
     */
    public function getDistrict();

    /**
     * Set district name
     *
     * @param string $district
     * @return $this
     */
    public function setDistrict($district);

    /**
     * Get district Code
     *
     * @return int|null
     */
    public function getDistrictCode();

    /**
     * Set district Code
     *
     * @param int $districtCode
     * @return $this
     */
    public function setDistrictCode($districtCode);

    /**
     * Get street
     *
     * @return string|null
     */
    public function getStreet();

    /**
     * Set street
     *
     * @param string $street
     * @return $this
     */
    public function setStreet(string $street);

    /**
     * Get telephone number
     *
     * @return string|null
     */
    public function getTelephone();

    /**
     * Set telephone number
     *
     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone);

    /**
     * Get postcode
     *
     * @return string|null
     */
    public function getPostcode();

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return $this
     */
    public function setPostcode($postcode);

    /**
     * Get first name
     *
     * @return string|null
     */
    public function getFirstname();

    /**
     * Set first name
     *
     * @param string $firstName
     * @return $this
     */
    public function setFirstname($firstName);

    /**
     * Get last name
     *
     * @return string|null
     */
    public function getLastname();

    /**
     * Set last name
     *
     * @param string $lastName
     * @return $this
     */
    public function setLastname($lastName);

    /**
     * Get if this address is default shipping address
     *
     * @return bool|null
     */
    public function getIsDefaultShipping();

    /**
     * Set if this address is default shipping address
     *
     * @param bool $isDefaultShipping
     * @return $this
     */
    public function setIsDefaultShipping($isDefaultShipping);

}
