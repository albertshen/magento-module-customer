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
     * Create customer account.
     *
     * @param $phone
     * @param string $verifyCode
     * @param string $socialHash
     * @return \AlbertMage\Customer\Api\Data\CustomerTokenInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createAccount(
        $phone,
        $verifyCode,
        $socialHash = null
    );

}
