<?php

namespace RLTSquare\Ccq\Model\Queue\Handler;

use RLTSquare\Ccq\Api\Data\CcqInterface;

/**
 * Handler class to implements CcqInterface
 */
class Handler implements CcqInterface
{
    /**
     * @var mixed
     */
    protected mixed $name;
    /**
     * @var mixed
     */
    protected mixed $age;

    /**
     * @inheritDoc
     */
    public function getAge(): mixed
    {
        return $this->age;
    }

    /**
     * @inheritDoc
     */
    public function setAge(int|string $age)
    {
        $this->age = $age;
    }

    /**
     * @inheritDoc
     */
    public function getName(): mixed
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function setName(int|string $name)
    {
        $this->name = $name;
    }
}
