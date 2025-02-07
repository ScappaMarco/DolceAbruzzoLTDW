<?php
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: FRecensione::class)]
#[ORM\Table('recensione')]

class ERecensione {

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id_recensione = null;

    #[ORM\Column(type: 'string')]
    private $testo;

    #[ORM\Column(type: 'integer')]
    private $valutazione;

    #[ORM\ManyToOne(targetEntity:EProdotto::class, inversedBy:'recensioni')]
    #[ORM\JoinColumn(name:'id_prodotto', referencedColumnName:'id_prodotto',nullable:false)]
    private EProdotto|null $prodotto = null;

    #[ORM\ManyToOne(targetEntity:ECliente::class, inversedBy:'recensioni')]
    #[ORM\JoinColumn(name:'id_cliente', referencedColumnName:'id_cliente',nullable:false)]
    private ECliente|null $cliente = null;

    #[ORM\OneToMany(targetEntity: ESegnalazione::class, mappedBy: 'recensione_segnalata')]
    private Collection $segnalazioni;

    public function __construct($testo, $valutazione) {
        $this->testo = $testo;
        $this->valutazione = $valutazione;
        $this->segnalazioni = new ArrayCollection();
    }
    
    /**
     * Get the value of id_recensione
     */ 
    public function getId_recensione()
    {
        return $this->id_recensione;
    }
    
    /**
     * Get the value of testo
     */ 
    public function getTesto()
    {
        return $this->testo;
    }

    /**
     * Set the value of testo
     *
     * @return  self
     */ 
    public function setTesto($testo)
    {
        $this->testo = $testo;
    }
    
    /**
     * Get the value of valutazione
     */ 
    public function getValutazione()
    {
        return $this->valutazione;
    }

    /**
     * Set the value of valutazione
     *
     * @return  self
     */ 
    public function setValutazione($valutazione)
    {
        $this->valutazione = $valutazione;
    }

    /**
     * Get the value of prodotto
     */ 
    public function getProdotto()
    {
        return $this->prodotto;
    }

    /**
     * Set the value of prodotto
     *
     * @return  self
     */ 
    public function setProdotto($prodotto)
    {
        $this->prodotto = $prodotto;
    }

    /**
     * Get the value of cliente
     */ 
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set the value of cliente
     *
     * @return  self
     */ 
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    }

    public function getSegnalazioni(): Collection
    {
        return $this->segnalazioni;
    }

    public function addSegnalazione(ESegnalazione $segnalazione)
    {
        if (!$this->segnalazioni->contains($segnalazione)) {
            $this->segnalazioni[] = $segnalazione;
            $segnalazione->setRecensioneSegnalata($this);
        }
    }

    public function removeSegnalazione(ESegnalazione $segnalazione)
    {
        if ($this->segnalazioni->removeElement($segnalazione)) {
            // set the owning side to null (unless already changed)
            if ($segnalazione->getRecensioneSegnalata() === $this) {
                $segnalazione->setRecensioneSegnalata(null);
            }
        }
    }
}