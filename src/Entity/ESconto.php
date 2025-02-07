<?php
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FSconto::class)]
#[ORM\Table('sconto')]

class ESconto {

    #[ORM\Id]
    #[ORM\Column(type: 'string', length:10, columnDefinition:'VARCHAR(10)')]
    private string|null $codice_sconto = null;

    #[ORM\Column(type: 'integer')]
    private $valore_sconto;

    #[ORM\Column(type: 'boolean')]
    private bool $is_active = true;

    #[ORM\ManyToOne(targetEntity:ECliente::class, inversedBy:'sconti')]
    #[ORM\JoinColumn(name:'id_beneficiario', referencedColumnName:'id_cliente',nullable:false)]
    private ECliente|null $beneficiario = null;

    #[ORM\OneToOne(targetEntity:EOrdine::class, mappedBy:'codice_sconto')]
    private EOrdine|null $ordine = null;

    public function __construct($valore_sconto) {
        $this->valore_sconto = $valore_sconto;
    }

    public function isValid(): bool {
        return $this->is_active;
    }
    public function useSconto()
    {
        $this->is_active = false;
    }

    /**
     * Get the value of id_sconto
     */ 
    public function getCodiceSconto()
    {
        return $this->codice_sconto;
    }

    public function setCodiceSconto($codice_sconto)
    {
        $this->codice_sconto = $codice_sconto;
    }

    /**
     * Get the value of valore_sconto
     */ 
    public function getValore_sconto()
    {
        return $this->valore_sconto;
    }

    /**
     * Set the value of valore_sconto
     *
     * @return  self
     */ 
    public function setValore_sconto($valore_sconto)
    {
        $this->valore_sconto = $valore_sconto;

        return $this;
    }

    /**
     * Get the value of beneficiario
     */ 
    public function getBeneficiario()
    {
        return $this->beneficiario;
    }

    /**
     * Set the value of beneficiario
     *
     * @return  self
     */ 
    public function setBeneficiario($beneficiario)
    {
        $this->beneficiario = $beneficiario;

        return $this;
    }

    /**
     * Get the value of ordine
     */
    public function getOrdine(): ?EOrdine
    {
        return $this->ordine;
    }

    /**
     * Set the value of ordine
     */
    public function setOrdine(?EOrdine $ordine): self
    {
        $this->ordine = $ordine;

        return $this;
    }
}