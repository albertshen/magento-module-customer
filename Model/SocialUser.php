<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\App\ObjectManager;

/**
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SocialUser implements \AlbertMage\Customer\Api\SocialUserInterface
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
     * Initialize service
     *
     * @param string $application
     * @param string $platform
     */
    public function __construct(
        $application = null,
        $platform = null
    ) {
        $this->application = $application ?? 'miniprogram';
        $this->platform = $platform ?? 'WeChat';
    }

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
