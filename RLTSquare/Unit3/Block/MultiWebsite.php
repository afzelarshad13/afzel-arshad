<?php
declare(strict_types=1);

namespace RLTSquare\Unit3\Block;

use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template\Context;
use RLTSquare\Unit3\Helper\MultiWebsiteConfiguration;
use RLTSquare\Unit3\Model\Config\Source\Types;

/**
 * block class for getting configuration values
 */
class MultiWebsite extends \Magento\Framework\View\Element\Template
{
    /**
     * @var EncryptorInterface
     */
    protected EncryptorInterface $decryptor;

    /**
     * @var MultiWebsiteConfiguration
     */
    protected MultiWebsiteConfiguration $helper;
    /**
     * @var Types
     */
    protected Types $types;

    /**
     * @param Context $context
     * @param MultiWebsiteConfiguration $helper
     * @param Types $types
     * @param EncryptorInterface $decryptor
     * @param array $data
     */
    public function __construct(
        Context                   $context,
        MultiWebsiteConfiguration $helper,
        Types                     $types,
        EncryptorInterface        $decryptor,
        array                     $data = []
    ) {
        $this->helper = $helper;
        $this->types = $types;
        $this->decryptor = $decryptor;
        parent::__construct($context, $data);
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getEnable()
    {
        return $this->helper->getEnable();
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getUsername()
    {
        return $this->helper->getUserName();
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getPassword(): string
    {
        return $this->decryptor->decrypt($this->helper->getPassword());
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getEnvironmentTypes()
    {
        $options = $this->types->toOptionArray();
        $type = $this->helper->getEnvironmentTypes();
        foreach ($options as $option) {
            if ($type == $option['value']) {
                return $option['label']->getText();
            }
        }
        return 'Default Type';
    }
}
