<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AlbertMage\Catalog\Model\WeChat;

use Magento\Framework\App\ObjectManager;

/**
 *
 */
class Customer implements \AlbertMage\Customer\Api\WeChat\WeChatUserInterface
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
     * Initialize service
     *
     * @param string $application
     * @param string $platform
     */
    public function __construct(
        $application,
        $platform = null
    ) {
        $this->application = $application ?? 'miniprogram';
        $this->platform = $platform ?? 'WeChat';
    }

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
    public function getPlatform()
    {
        return $this->platform;
    }
}
