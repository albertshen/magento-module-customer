<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Api;

/**
 * Customer social CRUD interface.
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface SocialRepositoryInterface
{
    /**
     * Save customer social.
     *
     * @param \AlbertMage\Customer\Api\Data\SocialInterface $social
     * @return \AlbertMage\Customer\Api\Data\SocialInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\AlbertMage\Customer\Api\Data\SocialInterface $social);

    /**
     * Retrieve customer social.
     *
     * @param int $socialId
     * @return \AlbertMage\Customer\Api\Data\SocialInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($socialId);

    /**
     * Retrieve customers social matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \AlbertMage\Customer\Api\Data\SocialSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete customer social.
     *
     * @param \AlbertMage\Customer\Api\Data\SocialInterface $social
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\AlbertMage\Customer\Api\Data\SocialInterface $social);

    /**
     * Delete customer social by ID.
     *
     * @param int $socialId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($socialId);
}
