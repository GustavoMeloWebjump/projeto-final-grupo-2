<?php
namespace Webjump\Backend\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Webjump\Backend\Model\Product\AddProduct as ModelAddProduct;
use Webjump\Backend\Model\Product\CreateRelation;

/**
 * @codeCoverageIgnore
 */
class AddProduct extends Command
{

    /**
     * @var ModelAddProduct
     */
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
