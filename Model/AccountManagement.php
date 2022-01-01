<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AlbertMage\Catalog\Model;

use Magento\Framework\Event\ManagerInterface;
use AlbertMage\Customer\Api\SocialRepositoryInterface;
use Magento\Framework\Exception\State\UserLockedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\InvalidEmailOrPasswordException;

/**
 * Handle various customer account actions
 */
class AccountManagement
{

    /**
     * @var AuthenticationInterface
     */
    protected $authentication;

    /**
     * @var ManagerInterface
     */
    private $eventManager;

    /**
     * @var SocialRepositoryInterface
     */
    private $socialRepository;

    /**
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        ManagerInterface $eventManager,
        SocialRepositoryInterface $socialRepository
    ) {
        $this->eventManager = $eventManager;
        $this->socialRepository = $socialRepository;
    }

    /**
     * Authenticate for WeChat miniprogram
     *
     * @param string $openid
     * @throws NoSuchEntityException If customer doesn't exist
     * @throws InvalidEmailOrPasswordException
     * @throws UserLockedException
     */
    public function authenticateForWeChatUser(\AlbertMage\Customer\Api\WeChat\WeChatUserInfoInterface $weChatUser)
    {
        try {
            if ($socialAccount = $this->socialRepository->getByOpenId($openid)) {
                
            }
        } catch (NoSuchEntityException $e) {
            throw new InvalidEmailOrPasswordException(__('Invalid login.'));
        }

        $customer = $socialAccount->getCustomer();

        if ($this->getAuthentication()->isLocked($customer->getId())) {
            throw new UserLockedException(__('The account is locked.'));
        }

        $this->eventManager->dispatch('customer_data_object_login', ['customer' => $customer]);

        return $customer;
    }

    /**
     * Get authentication
     *
     * @return AuthenticationInterface
     */
    private function getAuthentication()
    {
        if (!($this->authentication instanceof \Magento\Customer\Model\AuthenticationInterface)) {
            return \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Magento\Customer\Model\AuthenticationInterface::class
            );
        } else {
            return $this->authentication;
        }
    }
}
