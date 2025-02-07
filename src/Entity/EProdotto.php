<?php
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FProdotto::class)]
#[ORM\Table('prodotto')]
class EProdotto {
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id_prodotto = null;

    #[ORM\Column(type: 'string')]
    private $nome;

    #[ORM\Column(type: 'string', columnDefinition: 'TEXT')]
    private $descrizione;

    #[ORM\Column(type: 'string', columnDefinition: 'TEXT')]
    private $ingredienti;

    #[ORM\Column(type: 'float', columnDefinition: 'DOUBLE(7,2)')]
    private $prezzo;

    #[ORM\Column(type: 'integer', columnDefinition:'INT(3)')]
    private $punti_fedelta;
    
    #[ORM\Column(type: 'integer')]
    private $quantita_disp;

    #[ORM\Column(type: 'boolean')]
    private $is_gluten_free;

    #[ORM\OneToMany(targetEntity:EImmagine::class, mappedBy:'prodotto')]
    private Collection $immagini;

    #[ORM\ManyToOne(targetEntity: ECategoria::class, inversedBy:'prodotti')]
    #[ORM\JoinColumn(name:'nome_categoria', referencedColumnName:'nome_categoria',nullable:false)]
    private ECategoria $nome_categoria;

    #[ORM\OneToMany(targetEntity:ERecensione::class, mappedBy:'prodotto')]
    private Collection $recensioni;

    #[ORM\OneToMany(targetEntity: EOrdineProdotto::class, mappedBy: 'prodotto_id')]
    private Collection $q_prodotto_ordine;

    public function __construct($nome, $descrizione, $ingredienti, $prezzo, $punti_fedelta, $quantita_disp, $is_gluten_free) {
        $this->nome = $nome;
        $this->descrizione = $descrizione;
        $this->ingredienti = $ingredienti;
        $this->prezzo = $prezzo;
        $this->punti_fedelta = $punti_fedelta;
        $this->quantita_disp = $quantita_disp;
        $this->is_gluten_free = $is_gluten_free;
        $this->immagini = new ArrayCollection();
        $this->recensioni = new ArrayCollection();
        $this->q_prodotto_ordine = new ArrayCollection();
    }

    /**
     * Get the value of id_prodotto
     *
     * @return $id_prodotto
     */
    public function getIdProdotto()
    {
        return $this->id_prodotto;
    }

    /**
     * Set the value of id_prodotto
     *
     * @param $id_prodotto
     */
    public function setIdProdotto($id_prodotto)
    {
        $this->id_prodotto = $id_prodotto;
    }

    /**
     * Get the value of nome
     */ 
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     *
     * @return  self
     */ 
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of descrizione
     */ 
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    /**
     * Set the value of descrizione
     *
     * @return  self
     */ 
    public function setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;

        return $this;
    }

    /**
     * Get the value of ingredienti
     */ 
    public function getIngredienti()
    {
        return $this->ingredienti;
    }

    /**
     * Set the value of ingredienti
     *
     * @return  self
     */ 
    public function setIngredienti($ingredienti)
    {
        $this->ingredienti = $ingredienti;

        return $this;
    }

    /**
     * Get the value of prezzo
     */ 
    public function getPrezzo()
    {
        return $this->prezzo;
    }

    /**
     * Set the value of prezzo
     *
     * @return  self
     */ 
    public function setPrezzo($prezzo)
    {
        $this->prezzo = $prezzo;

        return $this;
    }

    /**
     * Get the value of punti_fedelta
     */ 
    public function getPunti_fedelta()
    {
        return $this->punti_fedelta;
    }

    /**
     * Set the value of punti_fedelta
     *
     * @return  self
     */ 
    public function setPunti_fedelta($punti_fedelta)
    {
        $this->punti_fedelta = $punti_fedelta;

        return $this;
    }

    /**
     * Get the value of nome_categoria
     */
    public function getNomeCategoria(): ECategoria
    {
        return $this->nome_categoria;
    }

    /**
     * Set the value of nome_categoria
     */
    public function setNomeCategoria(ECategoria $nome_categoria): self
    {
        $this->nome_categoria = $nome_categoria;

        return $this;
    }

    /**
     * Get the value of recensioni
     */ 
    public function getRecensioni()
    {
        return $this->recensioni;
    }

    /**
     * Set the value of recensioni
     *
     * @return  self
     */ 
    public function setRecensioni($recensioni)
    {
        $this->recensioni = $recensioni;

        return $this;
    }

    /**
     * Get the value of immagini
     */
    public function getImmagini(): Collection
    {
        return $this->immagini;
    }

    public function addImage(EImmagine $image): self
    {
        if (!$this->immagini->contains($image)) {
            $this->immagini[] = $image;
            $image->setProdotto($this);
        }

        return $this;
    }

    public function removeImage(EImmagine $image): self
    {
        if ($this->immagini->removeElement($image)) {
            // Set the owning side to null (unless already changed)
            if ($image->getProdotto() === $this) {
                $image->setProdotto(null);
            }
        }

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
     * Get the value of quantita_disp
     */
    public function getQuantitaDisp()
    {
        return $this->quantita_disp;
    }

    /**
     * Set the value of quantita_disp
     */
    public function setQuantitaDisp($quantita_disp): self
    {
        $this->quantita_disp = $quantita_disp;

        return $this;
    }

    /**
     * Get the value of is_gluten_free
     */
    public function getIsGlutenFree()
    {
        return $this->is_gluten_free;
    }

    /**
     * Set the value of is_gluten_free
     */
    public function setIsGlutenFree($is_gluten_free): self
    {
        $this->is_gluten_free = $is_gluten_free;

        return $this;
    }
}
?>