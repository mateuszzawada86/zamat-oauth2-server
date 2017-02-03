<?php

namespace Zamat\Bundle\OAuth2ServerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\DBAL\DBALException;
use Zamat\OAuth2\Exception\ScopeNotFoundException;

class CreateClientCommand extends ContainerAwareCommand
{

    /**
     * 
     * @return \Zamat\OAuth2\Command\CreateClientCommand
     */
    protected function configure()
    {
        $this
            ->setName('OAuth2:CreateClient')
            ->setDescription('Create a OAuth2 client')
            ->addArgument('identifier', InputArgument::REQUIRED, 'The client identifier')
            ->addArgument('redirect_uri', InputArgument::REQUIRED, 'The client redirect uris (comma separated)')
            ->addArgument('grant_types', InputArgument::OPTIONAL, 'Grant types to restrict the client to (comma separated)')
            ->addArgument('scopes', InputArgument::OPTIONAL, 'Scopes to restrict the client to (comma separated)')
        ;
    }

    /**
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $clientManager = $container->get('zamat_oauth2.client_manager');

        try {
            $client = $clientManager->createClient(
                $input->getArgument('identifier'),
                explode(',', $input->getArgument('redirect_uri')),
                explode(',', $input->getArgument('grant_types')),
                explode(',', $input->getArgument('scopes'))
            );
        } catch (DBALException $e) {
            $output->writeln('<fg=red>Unable to create client ' . $input->getArgument('identifier') . '</fg=red>');
            $output->writeln('<fg=red>' . $e->getMessage() . '</fg=red>');
            return 1;
        } catch (ScopeNotFoundException $e) {
            $output->writeln('<fg=red>Scope not found, please create it first</fg=red>');
            return 1;
        }

        $output->writeln('<fg=green>Client ' . $input->getArgument('identifier') . ' created with secret ' . $client->getClientSecret() . '</fg=green>');
    }
}
