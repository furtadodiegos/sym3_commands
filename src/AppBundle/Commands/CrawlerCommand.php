<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 25/09/17
 * Time: 10:29
 */

namespace AppBundle\Commands;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlerCommand extends ContainerAwareCommand
{

    /**
     * string usada para a funcao preg_match_all
     *
     * @var string
     */
    private $pattern_link = '/<a .*?href="(.*)">/';

    /**
     * string usada para a funcao preg_match_all
     *
     * @var string
     */
    private $pattern_email = '/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i';

    public function configure()
    {
        $this->setName('crawler-start')
            ->setDescription('Crawler para buscar urls e emails de links salvos no banco de dados.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $crawler = new CrawlerParameters($this->getContainer()->get('doctrine')->getManager(), $output, $this->getContainer()->get('validator'));

        $response = array();

        $links = $crawler->getAll('Url');

        foreach ($links as $key => $link) {
            $url = @file_get_contents($link->getNome());

            if ($url) {
                //Links
                preg_match_all($this->pattern_link, $url, $l);

                if (count($l)) {
                    $output->writeln(["Salvando os links da url: ".$link->getNome()]);

                    $response[$link->getNome()]['links'] = $crawler->saveLinks($l[1]);
                }

                //Emails
                preg_match_all($this->pattern_email, $url, $e);
                if (count($e)) {
                    $output->writeln(["Salvando os emails da url: ".$link->getNome()]);

                    $response[$link->getNome()]['emails'] = $crawler->saveEmails($e[0], $link->getId());
                }

                $crawler->editLink($link->getId());
            }
        }

        print_r($response);

        $output->writeln('Acao concluida.');
        return;
    }
}
