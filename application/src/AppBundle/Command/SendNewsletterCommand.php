<?php
/**
 * Created by PhpStorm.
 * User: Gaetan
 * Date: 13/06/2017
 * Time: 19:48
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Constraints\DateTime;

class SendNewsletterCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "app/console")
            ->setName('app:send-newsletter')
            // the short description shown while running "php app/console list"
            ->setDescription('Evois toutes les newsletters du jour.')

            // the full command description shown when running the command with
            // the "--help" option
            //->setHelp('This command allows you to create a user...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Envois des newsletters');

        $mailer     = $this->getContainer()->get('mailer');

        $orm = $this->getContainer()->get('doctrine');
        $newsletters = $orm->getRepository('AppBundle:Newsletter')->getNewsletterToSend();
        foreach ($newsletters as $newsletter) {
            foreach ($newsletter->getInscriptions() as $i) {
                $message = new \Swift_Message('Newsletter du ' . (new \DateTime())->format('d-m-Y'));
                $message->setFrom($this->getContainer()->getParameter('mailer_from'))
                    ->setTo($i->getDestinataire()->getEmail())
                    ->setContentType("text/html")
                    ->setBody($newsletter->getContenus()->get(0)->getContenuHTML())
                ;

                try {
                    $mailer->send($message);
                } catch (\Exception $e) {
                    $io->error("Impossible d'envoyer le mail à l'adresse " . $i->getDestinataire()->getEmail());
                    $io->error($e->getMessage());
                }
            }

            $newsletter->incrementeDateEnvoi();
        }

        $transport  = $mailer->getTransport();

        if ($transport instanceof \Swift_Transport_SpoolTransport) {
            $spool = $transport->getSpool();
            if ($spool instanceof \Swift_ConfigurableSpool) {
                $spool->setMessageLimit($input->getOption('message-limit'));
                $spool->setTimeLimit($input->getOption('time-limit'));
            }
            if ($spool instanceof \Swift_FileSpool) {
                if (null !== $input->getOption('recover-timeout')) {
                    $spool->recover($input->getOption('recover-timeout'));
                } else {
                    $spool->recover();
                }
            }
            $sent = $spool->flushQueue($this->getContainer()->get('swiftmailer.transport.real'));

            $io->success(sprintf('%s email(s) envoyé(s)', $sent));
        }

    }
}