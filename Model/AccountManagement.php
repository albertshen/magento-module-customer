<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AlbertMage\Catalog\Model;

/**
 * Handle various customer account actions
 */
class AccountManagement implements \Magento\Customer\Model\AccountManagement
{

    /**
     * Authenticate for WeChat miniprogram
     *
     * @param string $openid
     * @throws InputException
     */
    public function authenticateForWxmp($openid)
    {
        try {
            $customerId = 1;
            $customer = $this->customerRepository->getById($customerId);
        } catch (NoSuchEntityException $e) {
            throw new InvalidEmailOrPasswordException(__('Invalid login.'));
        }

        if ($this->getAuthentication()->isLocked($customerId)) {
            throw new UserLockedException(__('The account is locked.'));
        }

        $customerModel = $this->customerFactory->create()->updateData($customer);
        $this->eventManager->dispatch(
            'customer_customer_authenticated',
            ['model' => $customerModel, 'password' => $password]
        );

        $this->eventManager->dispatch('customer_data_object_login', ['customer' => $customer]);

        return $customer;
    }

}
