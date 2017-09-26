<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Email
 *
 * @ORM\Table(name="email", indexes={@ORM\Index(name="fk_email_url_idx", columns={"cod_url"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Email")
 * @UniqueEntity(
 *    fields={"nome"},
 *    message="Este email ja esta cadastrado."
 * )
 */
class Email
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
     * @ORM\Column(name="nome", type="string", length=255, nullable=false)
     */
    private $nome;

    /**
     * @var \Url
     *
     * @ORM\ManyToOne(targetEntity="Url")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cod_url", referencedColumnName="id")
     * })
     */
    private $codUrl;



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
     * @return Email
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
     * Set codUrl
     *
     * @param \AppBundle\Entity\Url $codUrl
     *
     * @return Email
     */
    public function setCodUrl(\AppBundle\Entity\Url $codUrl = null)
    {
        $this->codUrl = $codUrl;

        return $this;
    }

    /**
     * Get codUrl
     *
     * @return \AppBundle\Entity\Url
     */
    public function getCodUrl()
    {
        return $this->codUrl;
    }
}
