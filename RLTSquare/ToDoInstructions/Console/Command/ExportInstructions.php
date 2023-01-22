<?php
declare(strict_types=1);

namespace RLTSquare\ToDoInstructions\Console\Command;

use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportInstructions extends Command
{
    /**
     * Constant variable for customer id
     */
    const ARG_NAME_ID = 'id';
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $orderCollection;

    /**
     * @param CollectionFactory $orderCollection
     * @param string|null $name
     */
    public function __construct(
        CollectionFactory $orderCollection,
        string $name = null
    ) {
        parent::__construct($name);
        $this->orderCollection = $orderCollection;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('todo-instructions:run')
            ->setDescription('Export Todo Instructions')
            ->addArgument(
                self::ARG_NAME_ID,
                InputArgument::REQUIRED,
                "Customer Id"
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $customerId = (int)$input->getArgument(self::ARG_NAME_ID);
        $exportDetailsCollection = $this->orderCollection->create()
            ->addFieldToFilter('customer_id', $customerId)
            ->addFieldToSelect('todo_instructions');
        $output->writeln(print_r($exportDetailsCollection->getData(), true));
        return 0;
    }
}
