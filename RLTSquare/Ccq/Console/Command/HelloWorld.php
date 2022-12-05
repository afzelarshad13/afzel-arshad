<?php
declare(strict_types=1);

namespace RLTSquare\Ccq\Console\Command;

use Exception;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RLTSquare\Ccq\Api\Data\CcqInterface;

/**
 * @author Afzel Arshad
 * Cli command for message queue
 */
class HelloWorld extends Command
{
    /**
     *  Topic name
     */
    const TOPIC_NAME = 'rltsquare.hello.world';

    /**
     * const name int|string
     */
    private const NAME = 'name';
    /**
     * const age int|string
     */
    private const AGE = 'age';
    /**
     * @var PublisherInterface
     */
    protected PublisherInterface $publisher;
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;
    /**
     * @var Json
     */
    protected Json $json;
    /**
     * @var CcqInterface
     *
     */
    protected CcqInterface $cq;


    /**
     * @param PublisherInterface $publisher
     * @param LoggerInterface $logger
     * @param Json $json
     * @param CcqInterface $cq
     */
    public function __construct(
        PublisherInterface $publisher,
        LoggerInterface $logger,
        Json $json,
        CcqInterface $cq
    ) {
        $this->publisher = $publisher;
        $this->logger = $logger;
        $this->json = $json;
        $this->cq = $cq;
        parent::__construct();
    }

    /**
     *  OutputInterfaceInitialization of the command.
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('rltsquare:hello:world');
        $this->setDescription('Commands to take 2 argument a string and num and print it on console');
        $this->addArgument(
            self::NAME,
            null,
            InputArgument::OPTIONAL,
            'NAME'
        );
        $this->addArgument(
            self::AGE,
            null,
            InputArgument::OPTIONAL,
            'AGE'
        );
        parent::configure();
    }

    /**
     * CLI command description.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $exitCode = 0;
        try {
            $name = $input->getArgument(self::NAME);
            $age = $input->getArgument(self::AGE);
            $this->cq->setName($name);
            $this->cq->setAge($age);

            $output->writeln('<info>Provided name is `' . $name . '`</info>');
            $output->writeln('<info>Provided age is `' . $age . '`</info>');
            $this->publisher->publish(self::TOPIC_NAME, $this->cq);
            $output->writeln('<info>Success message.</info>');
            $this->logger->info($name . ' ' . $age . ' has been published');
        } catch (Exception $e) {
            $output->writeln(sprintf(
                '<error>%s</error>',
                $e->getMessage()
            ));
            $exitCode = 1;
        }
        return $exitCode;
    }
}
