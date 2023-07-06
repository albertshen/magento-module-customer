<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Model\AbstractModel;
use AlbertMage\Customer\Api\Data\CustomerInterface;

/**
 * Class Customer
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class Customer extends AbstractModel implements CustomerInterface
{
    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get phone number
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->getData(self::PHONE);
    }

    /**
     * Set phone number
     *
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        return $this->setData(self::PHONE, $phone);
    }

    /**
     * Get nickname
     *
     * @return string|null
     */
    public function getNickname()
    {
        return $this->getData(self::NICKNAME);
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     * @return $this
     */
    public function setNickname($nickname)
    {
        return $this->setData(self::NICKNAME, $nickname);
    }

    /**
     * Get picture
     *
     * @return string|null
     */
    public function getPicture()
    {
        return $this->getData(self::PICTURE);
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return $this
     */
    public function setPicture($picture)
    {
        return $this->setData(self::PICTURE, $picture);
    }

    /**
     * Get first name
     *
     * @return string|null
     */
    public function getFirstname()
    {
        return $this->getData(self::FIRSTNAME);
    }

    /**
     * Set first name
     *
     * @param string $firstName
     * @return $this
     */
    public function setFirstname($firstName)
    {
        return $this->setData(self::FIRSTNAME, $firstName);
    }

    /**
     * Get last name
     *
     * @return string|null
     */
    public function getLastname()
    {
        return $this->getData(self::LASTNAME);
    }

    /**
     * Set last name
     *
     * @param string $lastName
     * @return $this
     */
    public function setLastname($lastName)
    {
        return $this->setData(self::LASTNAME, $lastName);
    }

    /**
     * Get gender
     *
     * @return int|null
     */
    public function getGender()
    {
        return $this->getData(self::GENDER);
    }

    /**
     * Set gender
     *
     * @param int $gender
     * @return $this
     */
    public function setGender($gender)
    {
        return $this->setData(self::GENDER, $gender);
    }

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Set email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Get birthday
     *
     * @return string|null
     */
    public function getBirthday()
    {
        return $this->getData(self::BIRTHDAY);
    }

    /**
     * Set birthday
     *
     * @param string $birthday
     * @return $this
     */
    public function setBirthday($birthday)
    {
        return $this->setData(self::BIRTHDAY, $birthday);
    }

    /**
     * Get province
     *
     * @return string|null
     */
    public function getProvince()
    {
        return $this->getData(self::PROVINCE);
    }

    /**
     * Set province
     *
     * @param string $province
     * @return $this
     */
    public function setProvince($province)
    {
        return $this->setData(self::PROVINCE, $province);
    }

    /**
     * Get city name
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->getData(self::CITY);
    }

    /**
     * Set city name
     *
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * Get district name
     *
     * @return string|null
     */
    public function getDistrict()
    {
        return $this->getData(self::DISTRICT);
    }

    /**
     * Set district name
     *
     * @param string $district
     * @return $this
     */
    public function setDistrict($district)
    {
        return $this->setData(self::DISTRICT, $district);
    }
}