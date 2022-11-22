<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Api;

/**
 * Interface SocialUserInterface
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface SocialUserInterface
{
    /**
     * Get OpenId
     *
     * @return string
     */
    public function getOpenId();

    /**
     * Set OpenId
     *
     * @param string
     * @return SocialUserInterface
     */
    public function setOpenId($openId);

    /**
     * Get UnionId
     *
     * @return string
     */
    public function getUnionId();

    /**
     * Set UnionId
     *
     * @param string
     * @return SocialUserInterface
     */
    public function setUnionId($openId);

    /**
     * Get Application
     *
     * @return string
     */
    public function getApplication();

    /**
     * Set Application
     * 
     * @param string
     * @return this
     */
    public function setApplication($application);

    /**
     * Get Platform
     *
     * @return string
     */
    public function getPlatform();

    /**
     * Set Platform
     * 
     * @param string
     * @return this
     */
    public function setPlatform($platform);

}
