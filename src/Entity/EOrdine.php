<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FOrdine::class)]
#[ORM\Table('ordine')]
class EOrdine {

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id_ordine = null;

    #[ORM\Column(type: 'date')]
    private $data_ordine;

    #[ORM\Column(type: 'string')]
    private $stato_ordine;

    #[ORM\Column(type: 'integer')]
    private $quantita_tot_prodotti;

    #[ORM\Column(type: 'float', columnDefinition:'DOUBLE(7,2)')]
    private $importo_ordine;

    #[ORM\Column(type: 'integer')]
    private int $punti_fedelta_guadagnati = 0;

    #[ORM\OneToOne(targetEntity: ESconto::class, inversedBy:'ordine')]
    #[ORM\JoinColumn(name: 'codice_sconto', referencedColumnName: 'codice_sconto', nullable: true)]
    private ?ESconto $codice_sconto = null;

    #[ORM\ManyToOne(targetEntity:ECliente::class, inversedBy:'ordini')]
    #[ORM\JoinColumn(name:'id_cliente', referencedColumnName:'id_cliente',nullable:false)]
    private ECliente|null $cliente = null;

    #[ORM\ManyToOne(targetEntity: ECartaDiCredito::class, inversedBy:'ordini')]
    #[ORM\JoinColumn(name: 'carta_di_credito', referencedColumnName: 'numero_carta',nullable:false)]
    private ECartaDiCredito|null $carta_ordine = null;

    #[ORM\ManyToOne(targetEntity: EIndirizzo::class, inversedBy: 'ordini')]
    #[ORM\JoinColumn(name: 'indirizzo_spedizione', referencedColumnName: 'indirizzo')]
    #[ORM\JoinColumn(name: 'cap_spedizione', referencedColumnName: 'cap')]
    private EIndirizzo|null $indirizzo_spedizione = null;

    #[ORM\OneToMany(targetEntity: EOrdineProdotto::class, mappedBy: 'ordine_id')]
    private Collection $q_prodotto_ordine;
    
    public function __construct() {
        $this->data_ordine = new \DateTime();
        $this->stato_ordine = 'In elaborazione';
        $this->quantita_tot_prodotti = 0;
        $this->importo_ordine = 0.0;
        $this->q_prodotto_ordine = new ArrayCollection();
    }

    public function addQProdottoOrdine(EOrdineProdotto $ordineProdotto){
        if (!$this->q_prodotto_ordine->contains($ordineProdotto)) {
            $this->q_prodotto_ordine[] = $ordineProdotto;
            $ordineProdotto->setOrdineId($this);
        }
    }

    public function removeQProdottoOrdine(EOrdineProdotto $ordineProdotto){
        if ($this->q_prodotto_ordine->removeElement($ordineProdotto)) {
            // set the owning side to null (unless already changed)
            if ($ordineProdotto->getOrdineId() === $this) {
                $ordineProdotto->setOrdineId(null);
            }
        }
    }
    /**
     * Get the value of id_ordine
     */ 
    public function getId_ordine()
    {
        return $this->id_ordine;
    }
    

    /**
     * Get the value of data_ordine
     */ 
    public function getData_ordine()
    {
        return $this->data_ordine;
    }

    /**
     * Set the value of data_ordine
     *
     * @return  self
     */ 
    public function setData_ordine($data_ordine)
    {
        $this->data_ordine = $data_ordine;

        return $this;
    }

    /**
     * Get the value of stato_ordine
     */ 
    public function getStato_ordine()
    {
        return $this->stato_ordine;
    }

    /**
     * Set the value of stato_ordine
     *
     * @return  self
     */ 
    public function setStato_ordine($stato_ordine)
    {
        $this->stato_ordine = $stato_ordine;

        return $this;
    }

    /**
     * Get the value of quantita_tot_prodotti
     */ 
    public function getQuantita_tot_prodotti()
    {
        return $this->quantita_tot_prodotti;
    }

    /**
     * Set the value of quantita_tot_prodotti
     *
     * @return  self
     */ 
    public function setQuantita_tot_prodotti($quantita_tot_prodotti)
    {
        $this->quantita_tot_prodotti = $quantita_tot_prodotti;

        return $this;
    }

    /**
     * Get the value of importo_ordine
     */ 
    public function getImporto_ordine()
    {
        return $this->importo_ordine;
    }

    /**
     * Set the value of importo_ordine
     *
     * @return  self
     */ 
    public function setImporto_ordine($importo_ordine)
    {
        $this->importo_ordine = $importo_ordine;

        return $this;
    }

    /**
     * Get the value of carta_ordine
     */ 
    public function getCarta_ordine()
    {
        return $this->carta_ordine;
    }

    /**
     * Set the value of carta_ordine
     *
     * @return  self
     */ 
    public function setCarta_ordine($carta_ordine)
    {
        $this->carta_ordine = $carta_ordine;

        return $this;
    }

    /**
     * Get the value of indirizzo_spedizione
     */ 
    public function getIndirizzo_spedizione()
    {
        return $this->indirizzo_spedizione;
    }

    /**
     * Set the value of indirizzo_spedizione
     *
     * @return  self
     */ 
    public function setIndirizzo_spedizione($indirizzo_spedizione)
    {
        $this->indirizzo_spedizione = $indirizzo_spedizione;

        return $this;
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

        return $this;
    }

    /**
     * Get the value of q_prodotto_ordine
     */
    public function getQProdottoOrdine(): Collection
    {
        return $this->q_prodotto_ordine;
    }

    /**
     * Set the value of q_prodotto_ordine
     */
    public function setQProdottoOrdine(Collection $q_prodotto_ordine): self
    {
        $this->q_prodotto_ordine = $q_prodotto_ordine;

        return $this;
    }

    /**
     * Get the value of codice_sconto
     */
    public function getCodiceSconto(): ?ESconto
    {
        return $this->codice_sconto;
    }

    public function applicaSconto(ESconto $sconto){
        $this->codice_sconto = $sconto;
        $sconto_applicato = $this->importo_ordine * ($sconto->getValore_sconto() / 100);
        $this->importo_ordine -= $sconto_applicato;
        $sconto->useSconto(); // Disattiva lo sconto dopo l'uso
    }

    public function setPuntiFedeltaGuadagnati(int $punti): void {
        $this->punti_fedelta_guadagnati = $punti;
    }
}