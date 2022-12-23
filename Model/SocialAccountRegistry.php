<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Registry for Social account models
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SocialAccountRegistry
{
    /**
     * @var SocialAccount[]
     */
    protected $registry = [];

    /**
     * @var SocialAccountFactory
     */
    protected $socialAccountFactory;

    /**
     * @param SocialAccountFactory $socialAccountFactory
     */
    public function __construct(SocialAccountFactory $socialAccountFactory)
    {
        $this->socialAccountFactory = $socialAccountFactory;
    }

    /**
     * Get instance of the SocialAccount Model identified by id
     *
     * @param int $socialAccountId
     * @return SocialAccount
     * @throws NoSuchEntityException
     */
    public function retrieve($socialAccountId)
    {
        if (isset($this->registry[$socialAccountId])) {
            return $this->registry[$socialAccountId];
        }
        $socialAccount = $this->socialAccountFactory->create();
        $socialAccount->load($socialAccountId);
        if (!$socialAccount->getId()) {
            throw NoSuchEntityException::singleField('socialId', $socialAccountId);
        }
        $this->registry[$socialAccountId] = $socialAccount;
        return $socialAccount;
    }

    /**
     * Remove an instance of the Social Account Model from the registry
     *
     * @param int $socialAccountId
     * @return void
     */
    public function remove($socialAccountId)
    {
        unset($this->registry[$socialAccountId]);
    }

    /**
     * Replace existing Social Model with a new one
     *
     * @param Social $socialAccount
     * @return $this
     */
    public function push(SocialAccount $socialAccount)
    {
        $this->registry[$socialAccount->getId()] = $socialAccount;
        return $this;
    }
}
