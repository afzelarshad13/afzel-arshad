<?php
declare(strict_types=1);

namespace RLTSquare\ToDoInstructions\Model\Adminhtml\System\Config\Source\Customer;

use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Group implements OptionSourceInterface
{
    /**
     * @param CollectionFactory $groupCollectionFactory
     */
    public function __construct(CollectionFactory $groupCollectionFactory)
    {
        $this->groupCollectionFactory = $groupCollectionFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $options = [];
        foreach ($this->groupCollectionFactory->create()->loadData()->toOptionArray() as $code) {
            $options[] = [
                'value' => $code['value'],
                'label' => $code['label'],
            ];
        }
        return $options;
    }
}
