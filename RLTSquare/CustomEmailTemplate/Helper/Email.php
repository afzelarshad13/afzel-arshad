<?php

declare(strict_types=1);

namespace RLTSquare\CustomEmailTemplate\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Custom Module Email helper
 */
class Email extends AbstractHelper
{
    const XML_PATH_ENABLE_DISABLE = 'custom_email_template/general/enabledisable';
    const XML_PATH_NAME = 'custom_email_template/general/sender_name';
    const XML_PATH_EMAIL = 'custom_email_template/general/sender_email';
    const XML_PATH_EMAIL_TEMPLATE = 'custom_email_template/general/email_template';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @var StateInterface
     */
    protected StateInterface $inlineTranslation;

    /**
     * @var TransportBuilder
     */
    protected TransportBuilder $transportBuilder;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder
    ) {
        $this->scopeConfig = $context;
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getEnableFlag()
    {
        return $this->getConfigValue(self::XML_PATH_ENABLE_DISABLE, $this->getStore());
    }

    /**
     * Return store configuration value of your template field that which id you set for template
     *
     * @param string $path
     * @param int $storeId
     * @return mixed
     */
    protected function getConfigValue(string $path, int $storeId): mixed
    {
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Return store
     *
     * @return int
     * @throws NoSuchEntityException
     */
    public function getStore(): int
    {
        $store = $this->storeManager->getStore();
        $storeId = $store->getStoreId();
        return (int) $storeId;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getEmail()
    {
        return $this->getConfigValue(self::XML_PATH_EMAIL, $this->getStore());
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getName()
    {
        return $this->getConfigValue(self::XML_PATH_NAME, $this->getStore());
    }
    /**
     * @throws NoSuchEntityException
     */
    public function getCustomEmailTemplateId()
    {
        return $this->getConfigValue(self::XML_PATH_EMAIL_TEMPLATE, $this->getStore());
    }
}
