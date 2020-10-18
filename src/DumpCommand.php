<?php

namespace TheIconicAPIDumper;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCommand extends Command
{
    function __construct(APIWrapper $api)
    {
        $this->wrapper = $api;
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

        $this->wrapper->setQuery($APIWrapperBuilder);
        $APIResponse = $this->wrapper->get();
        $output->writeln($APIResponse);
    }
}
