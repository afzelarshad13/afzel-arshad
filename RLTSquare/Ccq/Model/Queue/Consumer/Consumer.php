<?php
declare(strict_types=1);

namespace RLTSquare\Ccq\Model\Queue\Consumer;

use Psr\Log\LoggerInterface;

/**
 * @author Afzel Arshad
 * consumer class for logging messages
 */
class Consumer
{
    /**
     *  Topic name
     */
    const TOPIC_NAME = 'rltsquare.hello.world';
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param  $request
     * @return void
     */
    public function processMessage($request): void
    {
        $name = $request->getName();
        $age = $request->getAge();
        $this->logger->debug('hello world from rltsquare_hello_world queue job : ' . $name . " " . $age);
    }
}
