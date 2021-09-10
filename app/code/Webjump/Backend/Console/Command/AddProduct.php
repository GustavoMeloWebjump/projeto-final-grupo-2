<?php
namespace Webjump\Backend\Console\Command;

use Magento\Framework\Console\Cli;
use Magento\Framework\Event\ManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Mastering\SampleModule\Model\ItemFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Webjump\Backend\Model\Product\AddProduct as ModelAddProduct;

class AddProduct extends Command
{

    private ModelAddProduct $itemFactory;


    public function __construct(ModelAddProduct $itemFactory) {
        $this->itemFactory = $itemFactory;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('product:add');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->itemFactory->execute();

        return Cli::RETURN_SUCCESS;
    }
}
