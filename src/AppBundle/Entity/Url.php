<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Url
 *
 * @ORM\Table(name="url")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Url")
 * @UniqueEntity(
 *    fields={"nome"},
 *    message="Esta url ja esta cadastrada."
 * )
 */
class Url
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=false, unique=true)
     */
    private $nome;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visitada", type="boolean", nullable=false)
     */
    private $visitada = '0';



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Url
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set visitada
     *
     * @param boolean $visitada
     *
     * @return Url
     */
    public function setVisitada($visitada)
    {
        $this->visitada = $visitada;

        return $this;
    }

    /**
     * Get visitada
     *
     * @return boolean
     */
    public function getVisitada()
    {
        return $this->visitada;
    }
}
