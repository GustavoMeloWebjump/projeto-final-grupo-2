<?php
namespace Webjump\Backend\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Webjump\Backend\Setup\Patch\Data\InstallCategories;

class Apply extends Command
{
    public function __construct(InstallCategories $installCategories) {
        $this->installCategories = $installCategories;
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('backend:apply');
        $this->setDescription('Trying to make it work.');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->installCategories->apply();
    }
}