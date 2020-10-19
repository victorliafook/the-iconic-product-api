<?php

namespace TheIconicAPIDumper;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TheIconicAPIDumper\Decorators\OrderByVideoCountDecorator;
use TheIconicAPIDumper\Decorators\VideoPreviewDecorator;

class DumpCommand extends Command
{
    public function __construct(APIWrapper $api)
    {
        $this->wrapper = $api;
        parent::__construct();
    }
    
    public function configure()
    {
        $this->setName('dump')
            ->setDescription('Prints the Product API query result')
            ->addOption('page', 'p', InputOption::VALUE_REQUIRED, 'The page number to be fetched')
            ->addOption('page-size', 's', InputOption::VALUE_REQUIRED, 'The number of entries on a page')
            ->addOption('gender', 'g', InputOption::VALUE_REQUIRED, 'Filter by gender')
            ->addOption('sort', 'so', InputOption::VALUE_REQUIRED, 'Sort');
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $APIWrapperBuilder = APIWrapper::createQueryBuilder();
        
        $gender = $input->getOption('gender');
        if (!empty($gender)) {
            $APIWrapperBuilder->gender($gender);
        }
        
        $page = $input->getOption('page');
        if (!empty($page)) {
            $APIWrapperBuilder->page($page);
        }
        
        $pageSize = $input->getOption('page-size');
        if (!empty($pageSize)) {
            $APIWrapperBuilder->pageSize($pageSize);
        }
        
        $sort = $input->getOption('sort');
        if (!empty($sort)) {
            $APIWrapperBuilder->sort($sort);
        }

        $this->wrapper->setQuery($APIWrapperBuilder);
        $productsResultSet = $this->wrapper->getProducts();
        
        $decoratedResponse = new OrderByVideoCountDecorator(new VideoPreviewDecorator($productsResultSet, $this->wrapper));
        
        $output->writeln($decoratedResponse->getContent());
        return Command::SUCCESS;
    }
}
