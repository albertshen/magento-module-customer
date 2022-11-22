<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Api;

/**
 * Interface for managing customers accounts.
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface AccountManagementInterface
{
    /**
     * Create customer account. Perform necessary business operations like sending email.
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @param string $verifyCode
     * @param string $socialHash
     * @param string $redirectUrl
     * @return \Magento\Customer\Api\Data\CustomerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createAccount(
        \Magento\Customer\Api\Data\CustomerInterface $customer,
        $verifyCode,
        $socialHash = null,
        $redirectUrl = ''
    );

    /**
     * Create customer account using provided hashed password. Should not be exposed as a webapi.
     *
     * @api
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @param string $hash Password hash that we can save directly
     * @param string $redirectUrl URL fed to welcome email templates. Can be used by templates to, for example, direct
     *                            the customer to a product they were looking at after pressing confirmation link.
     * @return \Magento\Customer\Api\Data\CustomerInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided email is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createAccountWithPassword(
        \Magento\Customer\Api\Data\CustomerInterface $customer,
        $password = null,
        $redirectUrl = ''
    );

}
