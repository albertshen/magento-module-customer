<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AlbertMage\Customer\Model;

use Magento\Framework\App\ObjectManager;
use Magento\Customer\Api\Data\CustomerInterface;
use AlbertMage\Customer\Api\SocialRepositoryInterface;

/**
 *
 */
class AccountManagement implements \AlbertMage\Customer\Api\AccountManagementInterface
{

    /**
     * @var SocialRepositoryInterface
     */
    private $socialRepository;

    /**
     * Initialize service
     *
     * @param SocialRepositoryInterface $socialRepository
     */
    public function __construct(
        SocialRepositoryInterface $socialRepository
    ) {
        $this->socialRepository = $socialRepository;
    }

    /**
     * @inheritdoc
     */
    public function createAccount(CustomerInterface $customer, $verifyCode, $socialHash = null, $redirectUrl = '')
    {
        
    }

    /**
     * @inheritdoc
     */
    public function createAccountWithPassword(CustomerInterface $customer, $password = null, $socialHash = null, $redirectUrl = '')
    {

    }

}
