<?php
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FSegnalazione::class)]
#[ORM\Table('segnalazione')]
//Per permettere più segnalazioni per recensione, ma una sola per utente:
#[ORM\UniqueConstraint(name: "unique_segnalazione", columns: ["id_utente", "id_recensione"])]
class  ESegnalazione {

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id_segnalazione = null;
    
    #[ORM\Column(type: 'string')]
    private $testo;

    #[ORM\ManyToOne(targetEntity: ECliente::class, inversedBy: 'segnalazioni')]
    #[ORM\JoinColumn(name: 'id_utente', referencedColumnName: 'id_cliente', nullable: false)]
    private ECliente|null $utente = null;

    #[ORM\ManyToOne(targetEntity: ERecensione::class, inversedBy: 'segnalazioni')]
    #[ORM\JoinColumn(name: 'id_recensione', referencedColumnName: 'id_recensione', nullable: false)]
    private ERecensione|null $recensione_segnalata = null;

    public function __construct($testo) {
        $this->testo = $testo;
    }

    /**
     * Get the value of id_segnalazione
     */ 
    public function getId_segnalazione()
    {
        return $this->id_segnalazione;
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

        return $this;
    }

    /**
     * Get the value of utente
     */ 
    public function getUtente()
    {
        return $this->utente;
    }

    /**
     * Set the value of utente
     *
     * @return  self
     */ 
    public function setUtente($utente)
    {
        $this->utente = $utente;

        return $this;
    }

    /**
     * Get the value of recensione_segnalata
     */ 
    public function getRecensioneSegnalata()
    {
        return $this->recensione_segnalata;
    }

    /**
     * Set the value of recensione_segnalata
     *
     * @return  self
     */ 
    public function setRecensioneSegnalata($recensione_segnalata)
    {
        $this->recensione_segnalata = $recensione_segnalata;

        return $this;
    }
}