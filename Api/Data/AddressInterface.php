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
    const KEY_ID = 'id';

    const KEY_COUNTRY_ID = 'country_id';

    const KEY_REGION = 'region';

    const KEY_REGION_ID = 'region_id';

    const KEY_CITY = 'city';

    const KEY_CITY_ID = 'city_id';

    const KEY_DISTRICT = 'district';

    const KEY_DISTRICT_ID = 'district_id';

    const KEY_POSTCODE = 'postcode';

    const KEY_STREET = 'street';

    const KEY_FIRSTNAME = 'firstname';

    const KEY_LASTNAME = 'lastname';

    const KEY_TELEPHONE = 'telephone';

    const KEY_DEFAULT_SHIPPING = 'default_shipping';

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
     * Get country Id
     *
     * @return string|null
     */
    public function getCountryId();

    /**
     * Set country Id
     *
     * @param string $countryId
     * @return $this
     */
    public function setCountryId($countryId);

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
     * Get region id
     *
     * @return int|null
     */
    public function getRegionId();

    /**
     * Set region id
     *
     * @param int $regionId
     * @return $this
     */
    public function setRegionId($regionId);

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
     * Get city id
     *
     * @return int|null
     */
    public function getCityId();

    /**
     * Set city id
     *
     * @param int $cityId
     * @return $this
     */
    public function setCityId($cityId);

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
     * Get district id
     *
     * @return int|null
     */
    public function getDistrictId();

    /**
     * Set district id
     *
     * @param int $districtId
     * @return $this
     */
    public function setDistrictId($districtId);

    /**
     * Get street
     *
     * @return string[]|null
     */
    public function getStreet();

    /**
     * Set street
     *
     * @param string[] $street
     * @return $this
     */
    public function setStreet($street);

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
