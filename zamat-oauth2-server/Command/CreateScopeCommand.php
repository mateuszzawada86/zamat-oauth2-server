<?php

namespace Zamat\Bundle\OAuth2ServerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\DBAL\DBALException;

class CreateScopeCommand extends ContainerAwareCommand
{
    
    /**
     * 
     * @return \Zamat\OAuth2\Command\CreateScopeCommand
     */   
    protected function configure()
    {
        $this
            ->setName('OAuth2:CreateScope')
            ->setDescription('Create a scope for use in OAuth2')
            ->addArgument('scope', InputArgument::REQUIRED, 'The scope key/name')
            ->addArgument('description', InputArgument::REQUIRED, 'The scope description used on authorization screen')
        ;
        
    }

    /**
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return type
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $scopeManager = $container->get('zamat_oauth2.scope_manager');

        try {
            $scopeManager->createScope($input->getArgument('scope'), $input->getArgument('description'));
        } catch (DBALException $e) {
            $output->writeln('<fg=red>Unable to create scope ' . $input->getArgument('scope') . '</fg=red>');
            return;
        }

        $output->writeln('<fg=green>Scope ' . $input->getArgument('scope') . ' created</fg=green>');
    }
}
