<?php
/**
 * Created by PhpStorm.
 * User: diegofurtado
 * Date: 25/09/17
 * Time: 14:57
 */

namespace AppBundle\Commands;


use AppBundle\Entity\Email;
use AppBundle\Entity\Url;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CrawlerParameters
{

    /**
     * @var ObjectManager
     */
    private $orm;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(ObjectManager $objectManager, OutputInterface $outputInterface, ValidatorInterface $validatorInterface)
    {
        $this->orm = $objectManager;
        $this->output = $outputInterface;
        $this->validator = $validatorInterface;
    }

    /**
     * @param $repository
     * @return array
     */
    public function getAll($repository)
    {
        return $this->orm->getRepository('AppBundle:'.$repository)->findBy(['visitada' => false]);
    }

    /**
     * @param $id
     */
    public function editLink($id)
    {
        $link = $this->orm->getRepository('AppBundle:Url')->find($id);
        $link->setVisitada(true);

        $this->orm->persist($link);
        $this->orm->flush();
    }

    /**
     * @param $entity
     * @return bool
     * @throws \Exception
     */
    private function isValid($entity)
    {
        $errors = $this->validator->validate($entity);

        if (count($errors)) {
            $message = $this->getErrorMessages($errors);

            throw new \Exception(end($message));
        }

        return true;
    }

    /**
     * @param $errors
     * @return array
     */
    protected function getErrorMessages($errors) {
        $messages = array();

        foreach ($errors as $error) {
            $messages[$error->getPropertyPath()] = $error->getMessage();
        }

        return $messages;
    }

    /**
     * @param array $links
     * @return mixed
     */
    public function saveLinks(array $links)
    {
        return array_reduce(array_keys($links), function ($merge, $u) use($links) {
            $url = @file_get_contents($links[$u]);

            $this->output->writeln([($u + 1)." de ". (count($links) - 1)]);

            if ($url) {
                try {
                    $urlEntity = new Url();
                    $urlEntity->setNome($links[$u]);

                    if ($this->isValid($urlEntity)) {
                        $this->orm->persist($urlEntity);
                        $this->orm->flush();

                        return array_merge($merge, [$links[$u]]);
                    }
                } catch (\Exception $ex) {
                    $this->output->writeln([
                        "Erro ao salvar o link: ".$links[$u],
                        $ex->getMessage()
                    ]);
                    return $merge;
                }
            }

            return $merge;
        }, []);
    }

    /**
     * @param array $emails
     * @param $id
     * @return mixed
     */
    function saveEmails(array $emails, $id)
    {
        return array_reduce(array_keys($emails), function ($merge, $e) use($emails, $id) {
            $url = @file_get_contents($emails[$e]);

            $this->output->writeln([($e + 1)." de ". (count($emails) - 1)]);

            if ($url) {
                try {
                    $emailEntity = new Email();
                    $emailEntity->setNome($emails[$e])
                        ->setCodUrl($id);

                    if ($this->isValid($emailEntity)) {
                        $this->orm->persist($emailEntity);
                        $this->orm->flush();

                        return array_merge($merge, [$emails[$e]]);
                    }
                } catch (\Exception $ex) {
                    $this->output->writeln([
                        "Erro ao salvar o link: ".$emails[$e],
                        $ex->getMessage()
                    ]);
                    return $merge;
                }
            }

            return $merge;
        }, []);
    }
}