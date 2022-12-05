<?php
declare(strict_types=1);

namespace RLTSquare\Ccq\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * @api
 * @since 100.0.2
 *
 * Interface CcqInterface
 *
 * @package RLTSquare\Ccq\Api\Data
 */
interface CcqInterface extends ExtensibleDataInterface
{
    /**
     * Name mixed
     */
    const NAME = 'name';
    /**
     * Age mixed
     */
    const AGE = 'age';

    /**
     * Set Age
     *
     * @param int|string $age
     * @return $this
     */
    public function setAge(int|string $age);

    /**
     * @return mixed
     */
    public function getAge(): mixed;

    /**
     * Set  Name
     *
     * @param int|string $name
     * @return $this
     */
    public function setName(int|string $name);

    /**
     * @return mixed
     */
    public function getName(): mixed;
}
