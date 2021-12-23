<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace AlbertMage\Catalog\Model\WeChat;

use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;
use Magento\Customer\Model\AccountManagement;
use Magento\Framework\Webapi\Rest\Request;

/**
 *
 */
class CustomerTokenService
{

    /**
     * Token Model
     *
     * @var TokenModelFactory
     */
    private $tokenModelFactory;

    /**
     * @var AccountManagement
     */
    private $accountManagement;

    /**
     * @var \Magento\Framework\Webapi\Rest\Request
     */
    protected $_request;

    /**
     * @var Magento\Framework\Event\ManagerInterface
     */
    private $eventManager;

    /**
     * Initialize service
     *
     * @param TokenModelFactory $tokenModelFactory
     * @param AccountManagement $accountManagement
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     */
    public function __construct(
        TokenModelFactory $tokenModelFactory,
        AccountManagement $accountManagement,
        Request $request,
        ManagerInterface $eventManager = null
    ) {
        $this->tokenModelFactory = $tokenModelFactory;
        $this->accountManagement = $accountManagement;
        $this->_request = $request;
        $this->eventManager = $eventManager ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(ManagerInterface::class);
    }

    /**
     * @inheritdoc
     */
    public function createCustomerAccessToken()
    {
        try {
            $customerDataObject = $this->accountManagement->authenticateForWxmp($this->wxLogin());
        } catch (\Exception $e) {
            throw new AuthenticationException(
                __(
                    'The account sign-in was incorrect or your account is disabled temporarily. '
                    . 'Please wait and try again later.'
                )
            );
        }
        $this->eventManager->dispatch('customer_login', ['customer' => $customerDataObject]);
        return ['token' => $this->tokenModelFactory->create()->createCustomerToken($customerDataObject->getId())->getToken()];
        
    }

    private function wxLogin()
    {
        $code = $this->_request->getParam('code');
        $openid = 'sadsafsaf';
        return $openid;
    }


}
