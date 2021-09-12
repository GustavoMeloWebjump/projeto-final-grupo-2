<?php
namespace Webjump\Backend\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Webjump\Backend\Model\Product\CreateRelation as ProductRelation;


/**
 * @codeCoverageIgnore
 */
class CreateRelation extends Command
{

    /**
     * @var ProductRelation
     */
    private ProductRelation $itemRelation;


    public function __construct(ProductRelation $itemRelation) {
        $this->itemRelation = $itemRelation;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('product:relation');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->itemRelation->execute();

        return Cli::RETURN_SUCCESS;
    }
}
