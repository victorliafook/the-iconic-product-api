<?php

namespace TheIconicAPIDumper;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCommand extends Command
{
    function __construct(APIWrapper $api)
    {
        $this->wrapper = $api;
        parent::__construct();
    }
    
    public function configure()
    {
        $this->setName('dump')
            ->setDescription('Greet a user based on the time of the day.')
            ->addArgument('page', InputArgument::OPTIONAL, 'The page number to be fetched')
            ->addArgument('page-size', InputArgument::OPTIONAL, 'The number of entries on a page')
            ->addArgument('gender', InputArgument::OPTIONAL, 'Filter by gender')
            ->addArgument('sort', InputArgument::OPTIONAL, 'Sort');
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $APIWrapperBuilder = APIWrapper::createQueryBuilder();
        
        $gender = $input->getArgument('gender');
        if (!empty($gender)) {
            $APIWrapperBuilder->gender($gender);
        }
        
        $page = $input->getArgument('page');
        if (!empty($page)) {
            $APIWrapperBuilder->page($page);
        }
        
        $pageSize = $input->getArgument('page-size');
        if (!empty($pageSize)) {
            $APIWrapperBuilder->pageSize($pageSize);
        }
        
        $sort = $input->getArgument('sort');
        if (!empty($sort)) {
            $APIWrapperBuilder->sort($sort);
        }

        $this->wrapper->setQuery($APIWrapperBuilder);
        $APIResponse = $this->wrapper->getProducts();
        
        $decoratedResponse = new OrderByVideoCountDecorator(new VideoPreviewDecorator($APIResponse, $this->wrapper));
        
        $output->writeln($this->getResponseContent($decoratedResponse));
        return Command::SUCCESS;
    }
    
    private function getResponseContent(APIResponseInterface $response)
    {
        return $response->getContent();
    }
}
