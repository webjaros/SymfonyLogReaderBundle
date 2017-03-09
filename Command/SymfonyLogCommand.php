<?php

namespace WebJaros\SymfonyLogReaderBundle\Command;

use AppBundle\Entity\Email\Message;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Client\Email\Parser\Header;
use WebJaros\SymfonyLogReaderBundle\Entity\Record;
use WebJaros\SymfonyLogReaderBundle\Parser\FileParser;

class SymfonyLogCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('webjaros:symfony-log')
            ->setDescription('Parses symfony logs')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileParser = new FileParser();

        $fileParser->setPath(
            $this->getContainer()->get('kernel')->getLogDir()
            . DIRECTORY_SEPARATOR
            . $this->getContainer()->getParameter("kernel.environment")
            . '.log'
        );

        $entityManager = $this->getContainer()->get('doctrine')->getManager();

        try {
            foreach ($fileParser->parseAndReturn() as $record) {
                $entityManager->persist($record);
            }
        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
            exit;
        }

        $entityManager->flush();
    }


}
