<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\Customer\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use AlbertMage\Customer\Api\Data\SocialInterface;
use AlbertMage\Customer\Api\Data\SocialSearchResultInterfaceFactory;
use AlbertMage\Customer\Model\ResourceModel\Social;
use AlbertMage\Customer\Model\ResourceModel\Social\CollectionFactory;

/**
 * Social repository.
 *
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SocialRepository implements \AlbertMage\Customer\Api\SocialRepositoryInterface
{

    /**
     * @var \AlbertMage\Customer\Model\SocialFactory
     */
    protected $socialFactory;

    /**
     * @var \AlbertMage\Customer\Model\SocialRegistry
     */
    protected $socialRegistry;

    /**
     * @var \AlbertMage\Customer\Model\ResourceModel\Social
     */
    protected $socialResourceModel;

    /**
     * @var \AlbertMage\Customer\Api\Data\SocialSearchResultsInterfaceFactory
     */
    protected $socialSearchResultsFactory;

    /**
     * @var \AlbertMage\Customer\Model\ResourceModel\Social\CollectionFactory
     */
    protected $socialCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param \AlbertMage\Customer\Model\SocialFactory $socialFactory
     * @param \AlbertMage\Customer\Model\SocialRegistry $socialRegistry
     * @param \AlbertMage\Customer\Model\ResourceModel\Social $socialResourceModel
     * @param \AlbertMage\Customer\Api\Data\SocialSearchResultsInterfaceFactory $socialSearchResultsFactory
     * @param \AlbertMage\Customer\Model\ResourceModel\Social\CollectionFactory $socialCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \AlbertMage\Customer\Model\SocialFactory $socialFactory,
        \AlbertMage\Customer\Model\SocialRegistry $socialRegistry,
        \AlbertMage\Customer\Model\ResourceModel\Social $socialResourceModel,
        \AlbertMage\Customer\Api\Data\SocialSearchResultsInterfaceFactory $socialSearchResultsFactory,
        \AlbertMage\Customer\Model\ResourceModel\Social\CollectionFactory $socialCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->socialFactory = $socialFactory;
        $this->socialRegistry = $socialRegistry;
        $this->socialResourceModel = $socialResourceModel;
        $this->socialSearchResultsFactory = $socialSearchResultsFactory;
        $this->socialCollectionFactory = $socialCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save customer social.
     *
     * @param SocialInterface $social
     * @return SocialInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\AlbertMage\Customer\Api\Data\SocialInterface $social)
    {
        $this->socialResourceModel->save($social);
        return $social;
    }

    /**
     * Retrieve customer social.
     *
     * @param int $socialId
     * @return SocialInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($socialId)
    {
        $social = $this->socialRegistry->retrieve($socialId);
        return $social;
    }

    /**
     * Retrieve customer.
     *
     * @param int $openid
     * @return SocialInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getOneByOpenId($openid)
    {
        /** @var Collection $collection */
        $collection = $this->socialCollectionFactory->create();
        $collection->addFieldToFilter('openid', ['eq' => $openid]);
        if ($collection->getSize()) {
            foreach($collection as $item) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Retrieve bound customer.
     *
     * @param int $unionId
     * @return SocialInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getOneByBoundUionId($unionId)
    {
        /** @var Collection $collection */
        $collection = $this->socialCollectionFactory->create();
        $collection->addFieldToFilter('unionid', ['eq' => $unionId]);
        $collection->addFieldToFilter('customer_id', ['neq' => 'NULL']);
        if ($collection->getSize()) {
            foreach($collection as $item) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Retrieve not bound customer.
     *
     * @param int $unionId
     * @return SocialInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByNotBoundUionId($unionId)
    {
        /** @var Collection $collection */
        $collection = $this->socialCollectionFactory->create();
        $collection->addFieldToFilter('unionid', ['eq' => $unionId]);
        $collection->addFieldToFilter('customer_id', ['null' => true]);
        return $collection->getItems();
    }

    /**
     * Retrieve customer.
     *
     * @param int $uniqueId
     * @return SocialInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByUniqueId($uniqueId)
    {
        /** @var Collection $collection */
        $collection = $this->socialCollectionFactory->create();
        $collection->addFieldToFilter('unique_hash', ['eq' => $uniqueId]);
        return $collection->getItems();
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
        $collection = $this->socialCollectionFactory->create();
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
     * Retrieve customers sociales matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \AlbertMage\Customer\Api\Data\SocialSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var Collection $collection */
        $collection = $this->socialCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var \AlbertMage\Customer\Api\Data\SocialSearchResultsInterface $searchResults */
        $searchResults = $this->socialSearchResultsFactory->create();
        $searchResults->setItems($sociales);
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete customer social.
     *
     * @param SocialInterface $social
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(SocialInterface $social)
    {
        try {
            $this->socialResourceModel->delete($social);
            $this->socialRegistry->remove($socialId);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * Delete customer social by ID.
     *
     * @param int $socialId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($socialId)
    {
        $social = $this->socialRegistry->retrieve($socialId);
        $this->socialResourceModel->delete($social);
        $this->socialRegistry->remove($socialId);
        return true;
    }
}
