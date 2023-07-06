<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlbertMage\Customer\Api\Data;

/**
 * Customer interface.
 * @api
 * @since 100.0.2
 */
interface CustomerInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';

    const PHONE = 'phone';

    const NICKNAME = 'nickname';

    const PICTURE = 'picture';

    const FIRSTNAME = 'firstname';

    const LASTNAME = 'lastname';

    const GENDER = 'gender';

    const EMAIL = 'email';

    const BIRTHDAY = 'birthday';

    const PROVINCE = 'province';

    const CITY = 'city';

    const DISTRICT = 'district';

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
     * Get phone number
     *
     * @return string|null
     */
    public function getPhone();

    /**
     * Set phone number
     *
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone);

    /**
     * Get nickname
     *
     * @return string|null
     */
    public function getNickname();

    /**
     * Set nickname
     *
     * @param string $nickname
     * @return $this
     */
    public function setNickname($nickname);

    /**
     * Get picture
     *
     * @return string|null
     */
    public function getPicture();

    /**
     * Set picture
     *
     * @param string $picture
     * @return $this
     */
    public function setPicture($picture);

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
     * Get gender
     *
     * @return int|null
     */
    public function getGender();

    /**
     * Set gender
     *
     * @param int $gender
     * @return $this
     */
    public function setGender($gender);

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Set email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * Get birthday
     *
     * @return string|null
     */
    public function getBirthday();

    /**
     * Set birthday
     *
     * @param string $birthday
     * @return $this
     */
    public function setBirthday($birthday);

    /**
     * Get province
     *
     * @return string|null
     */
    public function getProvince();

    /**
     * Set province
     *
     * @param string $province
     * @return $this
     */
    public function setProvince($province);

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

}
