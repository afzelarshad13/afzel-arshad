<?php
declare(strict_types=1);

namespace RLTSquare\Unit3\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Custom helper Class for configuration values
 */
class MultiWebsiteConfiguration extends AbstractHelper
{
    const XML_PATH_ENABLE = 'unit3/unit3/enable';
    const XML_PATH_USERNAME = 'unit3/unit3/username';
    const XML_PATH_PASSWORD = 'unit3/unit3/password';
    const XML_PATH_ENVIRONMENT_TYPE = 'unit3/unit3/environment_type';

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
    public function getEnable()
    {
        return $this->getConfigValue(self::XML_PATH_ENABLE, $this->getStore());
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
    public function getPassword()
    {
        return $this->getConfigValue(self::XML_PATH_PASSWORD, $this->getStore());
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getUserName()
    {
        return $this->getConfigValue(self::XML_PATH_USERNAME, $this->getStore());
    }
    /**
     * @throws NoSuchEntityException
     */
    public function getEnvironmentTypes()
    {
        return $this->getConfigValue(self::XML_PATH_ENVIRONMENT_TYPE, $this->getStore());
    }
}
