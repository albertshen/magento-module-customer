<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Registry for Social models
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SocialRegistry
{
    /**
     * @var Social[]
     */
    protected $registry = [];

    /**
     * @var SocialFactory
     */
    protected $socialFactory;

    /**
     * @param SocialFactory $socialFactory
     */
    public function __construct(SocialFactory $socialFactory)
    {
        $this->socialFactory = $socialFactory;
    }

    /**
     * Get instance of the Social Model identified by id
     *
     * @param int $socialId
     * @return Social
     * @throws NoSuchEntityException
     */
    public function retrieve($socialId)
    {
        if (isset($this->registry[$socialId])) {
            return $this->registry[$socialId];
        }
        $social = $this->socialFactory->create();
        $social->load($socialId);
        if (!$social->getId()) {
            throw NoSuchEntityException::singleField('socialId', $socialId);
        }
        $this->registry[$socialId] = $social;
        return $social;
    }

    /**
     * Remove an instance of the Social Model from the registry
     *
     * @param int $socialId
     * @return void
     */
    public function remove($socialId)
    {
        unset($this->registry[$socialId]);
    }

    /**
     * Replace existing Social Model with a new one
     *
     * @param Social $social
     * @return $this
     */
    public function push(Social $social)
    {
        $this->registry[$social->getId()] = $social;
        return $this;
    }
}
