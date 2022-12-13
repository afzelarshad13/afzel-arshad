<?php
declare(strict_types=1);

namespace RLTSquare\Unit3\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Environment Types
 */
class Types implements OptionSourceInterface
{
    /**
     * Lost basket hour options.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'production', 'label' => __('Production')],
            ['value' => 'staging', 'label' => __('Staging')],
            ['value' => 'developer', 'label' => __('Development')],
        ];
    }
}
