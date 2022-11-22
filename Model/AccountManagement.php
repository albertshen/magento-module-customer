<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\App\ObjectManager;
use Magento\Customer\Api\Data\CustomerInterface;
use AlbertMage\Customer\Api\SocialRepositoryInterface;

/**
 * @author Albert Shen <albertshen1206@gmail.com>
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
