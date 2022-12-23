<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Api;

/**
 * Customer social account CRUD interface.
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface SocialAccountRepositoryInterface
{
    /**
     * Save customer social account.
     *
     * @param \AlbertMage\Customer\Api\Data\SocialAccountInterface $socialAccount
     * @return \AlbertMage\Customer\Api\Data\SocialAccountInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\AlbertMage\Customer\Api\Data\SocialAccountInterface $socialAccount);

    /**
     * Retrieve customer social account.
     *
     * @param int $socialAccountId
     * @return \AlbertMage\Customer\Api\Data\SocialAccountInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($socialAccountId);

    /**
     * Retrieve customers social account matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \AlbertMage\Customer\Api\Data\SocialAccountSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete customer social account.
     *
     * @param \AlbertMage\Customer\Api\Data\SocialAccountInterface $socialAccount
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\AlbertMage\Customer\Api\Data\SocialAccountInterface $socialAccount);

    /**
     * Delete customer social account by ID.
     *
     * @param int $socialAccountId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($socialAccountId);
}
