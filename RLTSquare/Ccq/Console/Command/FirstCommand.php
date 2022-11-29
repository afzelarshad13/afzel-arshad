<?php

namespace RLTSquare\Ccq\Console\Command;

use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FirstCommand extends Command
{
    private const NAME = 'name';

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('my:first:command');
        $this->setDescription('Commands to take argument a string and print it on console');
        $this->addOption(
            self::NAME,
            null,
            InputOption::VALUE_REQUIRED,
            'Name'
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
        // todo: implement CLI command logic here
        $exitCode = 0;
        if ($name = $input->getOption(self::NAME)) {
            $output->writeln('<info>Provided name is `' . $name . '`</info>');
        }

        $output->writeln('<info>Success message.</info>');
        $output->writeln('<comment>Some comment.</comment>');

        try {
            if (rand(0, 1)) {
                throw new LocalizedException(__('An error occurred.'));
            }
        } catch (LocalizedException $e) {
            $output->writeln(sprintf(
                '<error>%s</error>',
                $e->getMessage()
            ));
            $exitCode = 1;
        }

        return $exitCode;
    }
}
