<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model\ResourceModel;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use AlbertMage\Customer\Model\SocialAccountRegistry;
use AlbertMage\Customer\Api\Data\SocialAccountInterface;
use AlbertMage\Customer\Api\Data\SocialAccountSearchResultInterfaceFactory;
use AlbertMage\Customer\Model\ResourceModel\SocialAccount;
use AlbertMage\Customer\Model\ResourceModel\SocialAccount\CollectionFactory;

/**
 * SocialAccount repository.
 *
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SocialAccountRepository implements \AlbertMage\Customer\Api\SocialAccountRepositoryInterface
{

    /**
     * @var \AlbertMage\Customer\Model\SocialAccountRegistry
     */
    protected $socialAccountRegistry;

    /**
     * @var \AlbertMage\Customer\Model\ResourceModel\SocialAccount
     */
    protected $socialAccountResourceModel;

    /**
     * @var \AlbertMage\Customer\Api\Data\SocialAccountSearchResultsInterfaceFactory
     */
    protected $socialAccountSearchResultsFactory;

    /**
     * @var \AlbertMage\Customer\Model\ResourceModel\SocialAccount\CollectionFactory
     */
    protected $socialAccountCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param \AlbertMage\Customer\Model\SocialAccountRegistry $socialAccountRegistry
     * @param \AlbertMage\Customer\Model\ResourceModel\SocialAccount $socialAccountResourceModel
     * @param \AlbertMage\Customer\Api\Data\SocialAccountSearchResultsInterfaceFactory $socialAccountSearchResultsFactory
     * @param \AlbertMage\Customer\Model\ResourceModel\SocialAccount\CollectionFactory $socialAccountCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \AlbertMage\Customer\Model\SocialAccountRegistry $socialAccountRegistry,
        \AlbertMage\Customer\Model\ResourceModel\SocialAccount $socialAccountResourceModel,
        \AlbertMage\Customer\Api\Data\SocialAccountSearchResultsInterfaceFactory $socialAccountSearchResultsFactory,
        \AlbertMage\Customer\Model\ResourceModel\SocialAccount\CollectionFactory $socialAccountCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->socialAccountRegistry = $socialAccountRegistry;
        $this->socialAccountResourceModel = $socialAccountResourceModel;
        $this->socialAccountSearchResultsFactory = $socialAccountSearchResultsFactory;
        $this->socialAccountCollectionFactory = $socialAccountCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save customer social account.
     *
     * @param SocialAccountInterface $socialAccount
     * @return SocialAccountInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(SocialAccountInterface $socialAccount)
    {
        $this->socialAccountResourceModel->save($socialAccount);
        return $socialAccount;
    }

    /**
     * Retrieve customer social account.
     *
     * @param int $socialAccountId
     * @return SocialAccountInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($socialAccountId)
    {
        $socialAccount = $this->socialAccountRegistry->retrieve($socialAccountId);
        return $socialAccount;
    }

    /**
     * Retrieve customer.
     *
     * @param int $openid
     * @return SocialAccountInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getOneByOpenId($openid)
    {
        /** @var Collection $collection */
        $collection = $this->socialAccountCollectionFactory->create();
        $collection->addFieldToFilter('openid', ['eq' => $openid]);
        if ($collection->getSize()) {
            return $collection->getFirstItem();
        }
        return null;
    }

    /**
     * Retrieve bound customer.
     *
     * @param int $unionId
     * @return SocialAccountInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getOneByBoundUionId($unionId)
    {
        /** @var Collection $collection */
        $collection = $this->socialAccountCollectionFactory->create();
        $collection->addFieldToFilter('unionid', ['eq' => $unionId]);
        $collection->addFieldToFilter('customer_id', ['neq' => 'NULL']);
        if ($collection->getSize()) {
            return $collection->getFirstItem();
        }
        return null;
    }

    /**
     * Retrieve not bound customer.
     *
     * @param int $unionId
     * @return SocialAccountInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByNotBoundUionId($unionId)
    {
        /** @var Collection $collection */
        $collection = $this->socialAccountCollectionFactory->create();
        $collection->addFieldToFilter('unionid', ['eq' => $unionId]);
        $collection->addFieldToFilter('customer_id', ['null' => true]);
        return $collection->getItems();
    }

    /**
     * Retrieve customer.
     *
     * @param int $uniqueId
     * @return SocialAccountInterface|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByUniqueId($uniqueId)
    {
        /** @var Collection $collection */
        $collection = $this->socialAccountCollectionFactory->create();
        $collection->addFieldToFilter('unique_hash', ['eq' => $uniqueId]);
        if ($collection->getSize()) {
            return $collection->getFirstItem();
        }
        return null;
    }

    /**
     * Is bound customer
     *
     * @param int $customerId
     * @return boolean
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function hasBoundCustomer($customerId, $platform = null, $application = null)
    {
        /** @var Collection $collection */
        $collection = $this->socialAccountCollectionFactory->create();
        $collection->addFieldToFilter('customer_id', ['eq' => $customerId]);
        if ($platform) {
            $collection->addFieldToFilter('platform', ['eq' => $platform]);
        }
        if ($application) {
            $collection->addFieldToFilter('application', ['eq' => $application]);
        }
        return $collection->getSize() ? true : false;
    }

    /**
     * Retrieve sociales matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \AlbertMage\Customer\Api\Data\SocialAccountSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var Collection $collection */
        $collection = $this->socialAccountCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var \AlbertMage\Customer\Api\Data\SocialAccountSearchResultsInterface $searchResults */
        $searchResults = $this->socialAccountSearchResultsFactory->create();
        $socialAccounts = [];
        /** @var \AlbertMage\Customer\Model\SocialAccount $socialAccountModel */
        foreach ($collection as $socialAccountModel) {
            $socialAccounts[] = $socialAccountModel->getDataModel();
        }
        $searchResults->setItems($socialAccounts);
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete customer socialAccount.
     *
     * @param SocialAccountInterface $socialAccount
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(SocialAccountInterface $socialAccount)
    {
        try {
            $this->socialAccountResourceModel->delete($socialAccount);
            $this->socialAccountRegistry->remove($socialAccountId);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * Delete customer social account by ID.
     *
     * @param int $socialId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($socialId)
    {
        $socialAccount = $this->socialAccountRegistry->retrieve($socialAccountId);
        $this->socialAccountResourceModel->delete($socialAccount);
        $this->socialAccountRegistry->remove($socialAccountId);
        return true;
    }
}
