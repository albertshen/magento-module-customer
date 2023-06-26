<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Model\AbstractModel;
use AlbertMage\Customer\Api\Data\AddressInterface;

/**
 * Class Social Account
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class Address extends AbstractModel implements AddressInterface
{
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function getRegion()
    {
        return $this->getData(self::REGION);
    }

    /**
     * @inheritdoc
     */
    public function setRegion($region)
    {
        return $this->setData(self::REGION, $region);
    }

    /**
     * @inheritdoc
     */
    public function getRegionCode()
    {
        return $this->getData(self::REGION_CODE);
    }

    /**
     * @inheritdoc
     */
    public function setRegionCode($regionCode)
    {
        return $this->setData(self::REGION_CODE, $regionCode);
    }

    /**
     * @inheritdoc
     */
    public function getCity()
    {
        return $this->getData(self::CITY);
    }

    /**
     * @inheritdoc
     */
    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * @inheritdoc
     */
    public function getCityCode()
    {
        return $this->getData(self::CITY_CODE);
    }

    /**
     * @inheritdoc
     */
    public function setCityCode($cityCode)
    {
        return $this->setData(self::CITY_CODE, $cityCode);
    }

    /**
     * @inheritdoc
     */
    public function getDistrict()
    {
        return $this->getData(self::DISTRICT);
    }

    /**
     * @inheritdoc
     */
    public function setDistrict($district)
    {
        return $this->setData(self::DISTRICT, $district);
    }

    /**
     * @inheritdoc
     */
    public function getDistrictCode()
    {
        return $this->getData(self::DISTRICT_CODE);
    }

    /**
     * @inheritdoc
     */
    public function setDistrictCode($districtCode)
    {
        return $this->setData(self::DISTRICT_CODE, $districtCode);
    }

    /**
     * @inheritdoc
     */
    public function getStreet()
    {
        return $this->getData(self::STREET);
    }

    /**
     * @inheritdoc
     */
    public function setStreet($street)
    {
        return $this->setData(self::STREET, $street);
    }

    /**
     * @inheritdoc
     */
    public function getTelephone()
    {
        return $this->getData(self::TELEPHONE);
    }

    /**
     * @inheritdoc
     */
    public function setTelephone($telephone)
    {
        return $this->setData(self::TELEPHONE, $telephone);
    }

    /**
     * @inheritdoc
     */
    public function getPostcode()
    {
        return $this->getData(self::POSTCODE);
    }

    /**
     * @inheritdoc
     */
    public function setPostcode($postcode)
    {
        return $this->setData(self::POSTCODE, $postcode);
    }

    /**
     * @inheritdoc
     */
    public function getFirstname()
    {
        return $this->getData(self::FIRSTNAME);
    }

    /**
     * @inheritdoc
     */
    public function setFirstname($firstName)
    {
        return $this->setData(self::FIRSTNAME, $firstName);
    }

    /**
     * @inheritdoc
     */
    public function getLastname()
    {
        return $this->getData(self::LASTNAME);
    }

    /**
     * @inheritdoc
     */
    public function setLastname($lastName)
    {
        return $this->setData(self::LASTNAME, $lastName);
    }

    /**
     * @inheritdoc
     */
    public function getIsDefaultShipping()
    {
        return $this->getData(self::DEFAULT_SHIPPING);
    }

    /**
     * @inheritdoc
     */
    public function setIsDefaultShipping($isDefaultShipping)
    {
        return $this->setData(self::DEFAULT_SHIPPING, $isDefaultShipping);
    }
}