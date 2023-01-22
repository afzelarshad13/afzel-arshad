<?php
declare(strict_types=1);

namespace RLTSquare\ToDoInstructions\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class for getting configuration Values
 */
class Config
{
    /**
     * Constant CONFIG_PATH_ENABLED
     */
    const CONFIG_PATH_ENABLED = 'todo_instructions/todo_instructions/enabled';
    const CONFIG_PATH_ALLOWED_CUSTOMER_GROUP = 'todo_instructions/todo_instructions/allowed_customer_groups';

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param string $scopeType
     * @param string|null $scopeCode
     * @return bool
     */
    public function isEnabled(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_PATH_ENABLED, $scopeType, $scopeCode);
    }

    public function getApiUrl(string $scopeType = ScopeInterface::SCOPE_STORE, ?string $scopeCode = null): string
    {
        $value = $this->scopeConfig->getValue(self::CONFIG_PATH_ALLOWED_CUSTOMER_GROUP, $scopeType, $scopeCode);
        return ($value !== null) ? (string)$value : '';
    }
}
