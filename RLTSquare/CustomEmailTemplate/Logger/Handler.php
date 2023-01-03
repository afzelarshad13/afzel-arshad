<?php
declare(strict_types=1);

namespace RLTSquare\CustomEmailTemplate\Logger;

use Magento\Framework\Logger\Handler\Base as BaseHandler;
use Monolog\Logger;

/**
 * Custom Log File Handler
 */
class Handler extends BaseHandler
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::INFO;

    /**
     * File name
     * @var string
     */
    protected $fileName = '/var/log/rltsquare.log';
}

