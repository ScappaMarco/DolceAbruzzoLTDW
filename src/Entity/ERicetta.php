<?php
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\JoinColumn;
use PhpParser\Node\Name;

#[ORM\Entity(repositoryClass:FRicetta::class)]
#[ORM\Table('ricetta')]
class ERicetta {
    
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id_ricetta = null;

    #[ORM\Column(type: 'string')]
    private $titolo;

    #[ORM\Column(type: 'string', columnDefinition:'TEXT')]
    private $ingredienti;

    #[ORM\Column(type: 'string', columnDefinition:'TEXT')]
    private $procedimento;

    #[ORM\Column(type: 'string', columnDefinition:'TEXT')]
    private $descrizione;

    #[ORM\Column(type: 'integer')]
    private $difficolta;

    #[ORM\OneToOne(targetEntity: EImmagine::class, inversedBy: 'ricetta', cascade:['remove','persist'])]
    #[ORM\JoinColumn(name:"immagine", referencedColumnName:"id_image")]
    private EImmagine|null $immagine = null;

    #[ORM\ManyToOne(targetEntity:Echef::class, inversedBy:'ricette_pubblicate')]
    #[ORM\JoinColumn(name:'chef', referencedColumnName:'id_chef')]
    private EChef $chef_ricetta;

    public function __construct($titolo, $ingredienti, $procedimento, $descrizione) {
        $this->titolo = $titolo;
        $this->ingredienti = $ingredienti;
        $this->procedimento = $procedimento;
        $this->descrizione = $descrizione;
    }

    /**
     * Get the value of id_ricetta
     */ 
    public function getId_ricetta()
    {
        return $this->id_ricetta;
    }

    /**
     * Get the value of titolo
     */ 
    public function getTitolo()
    {
        return $this->titolo;
    }

    /**
     * Set the value of titolo
     *
     * @return  self
     */ 
    public function setTitolo($titolo)
    {
        $this->titolo = $titolo;
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
    }

    /**
     * Get the value of procedimento
     */ 
    public function getProcedimento()
    {
        return $this->procedimento;
    }

    /**
     * Set the value of procedimento
     *
     * @return  self
     */ 
    public function setProcedimento($procedimento)
    {
        $this->procedimento = $procedimento;
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
    }

    /**
     * Get the value of immagine
     */ 
    public function getImmagine()
    {
        return $this->immagine;
    }

    /**
     * Set the value of immagine
     *
     */ 
    public function setImmagine($immagine)
    {
        $this->immagine = $immagine;
    }


    /**
     * Get the value of numero_chef_ricetta
     */
    public function getChefRicetta()
    {
        return $this->chef_ricetta;
    }

    /**
     * Set the value of numero_chef_ricetta
     */
    public function setChefRicetta($chef)
    {
        $this->chef_ricetta = $chef;
    }

    /**
     * Get the value of difficolta
     */
    public function getDifficolta()
    {
        return $this->difficolta;
    }

    /**
     * Set the value of difficolta
     */
    public function setDifficolta($difficolta)
    {
        $this->difficolta = $difficolta;
    }
}