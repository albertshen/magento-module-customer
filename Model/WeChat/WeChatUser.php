<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AlbertMage\Customer\Model\WeChat;

use Magento\Framework\App\ObjectManager;

/**
 *
 */
class WeChatUser implements \AlbertMage\Customer\Api\WeChat\WeChatUserInterface
{

    /**
     * @var string
     */
    protected $application;

    /**
     * @var string
     */
    private $platform;

    /**
     * OpenId
     *
     * @var string
     */
    private $openId;

    /**
     * UnionId
     *
     * @var string
     */
    private $unionId;

    /**
     * @inheritdoc
     */
    public function getOpenId()
    {
        return $this->openId;
    }

    /**
     * @inheritdoc
     */
    public function setOpenId($openId)
    {
        return $this->openId = $openId;
    }

    /**
     * @inheritdoc
     */
    public function getUnionId()
    {
        return $this->unionId;
    }

    /**
     * @inheritdoc
     */
    public function setUnionId($unionId)
    {
        return $this->unionId = $unionId;
    }

    /**
     * @inheritdoc
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @inheritdoc
     */
    public function setApplication($application)
    {
        $this->application = $application;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @inheritdoc
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
        return $this;
    }
}
