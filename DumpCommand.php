<?php

namespace TheIconicAPIDumper;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCommand
{
    function __construct(APIWrapper $api)
    {
        $this->wrapper = $api;
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $APIResponse = $this->wrapper->get();
        $output->writeln($APIResponse);
    }
}
