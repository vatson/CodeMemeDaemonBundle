<?php

namespace CodeMeme\Bundle\CodeMemeDaemonBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\Command;

use CodeMeme\Bundle\CodeMemeDaemonBundle\Daemon;

class ExampleStartCommand extends Command
{
    
    protected function configure()
    {   
        $this->setName('example:start')
             ->setDescription('Starts the example daemon')
             ->setHelp(<<<EOT
The <info>{$this->getName()}</info> Run the example daemon in the background.
EOT
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $daemon = new Daemon($this->container->getParameter('example.daemon.options'));
        $daemon->start();
        
        while ($daemon->isRunning()) {
            $this->container->get('example.control')->run();
        }
        
        $daemon->stop();
    }

}