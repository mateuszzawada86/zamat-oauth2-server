<?php

namespace Zamat\Bundle\OAuth2ServerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\DBAL\DBALException;

class CreateUserCommand extends ContainerAwareCommand
{
    
    /**
     * 
     * @return \Zamat\OAuth2\Command\CreateScopeCommaCreateUserCommandnd
     */   
    protected function configure()
    {
        $this
            ->setName('OAuth2:CreateUser')
            ->setDescription('Create a basic OAuth2 user')
            ->addArgument('username', InputArgument::REQUIRED, 'The users unique username')
            ->addArgument('password', InputArgument::REQUIRED, 'The users password (plaintext)')
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
        $userProvider = $container->get('zamat_oauth.user.provider');

        try {
            $userProvider->createUser($input->getArgument('username'), $input->getArgument('password'));
        } catch (DBALException $e) {
            $output->writeln('<fg=red>Unable to create user ' . $input->getArgument('username') . '</fg=red>');

            return;
        }

        $output->writeln('<fg=green>User ' . $input->getArgument('username') . ' created</fg=green>');
    }
}
