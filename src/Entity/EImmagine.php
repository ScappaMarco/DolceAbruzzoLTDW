<?php
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:FImmagine::class)]
#[ORM\Table('immagine')]
class EImmagine{

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id_image = null;

    #[ORM\Column(type: 'string', length:70, columnDefinition: 'VARCHAR(70)')]
    private $name;

    #[ORM\Column(type: 'integer', columnDefinition: 'INT(9)')]
    private $size;

    #[ORM\Column(type: 'string', length:20, columnDefinition: 'VARCHAR(20)')]
    private $type;

    #[ORM\Column(type: 'blob')]
    private $imageData;

    #[ORM\ManyToOne(targetEntity: EProdotto::class, inversedBy:'immagini')]
    #[ORM\JoinColumn(name:'prodotto', referencedColumnName:'id_prodotto', nullable:true)]
    private EProdotto|null $prodotto = null;

    #[ORM\OneToOne(targetEntity: ERicetta::class, mappedBy:'immagine')]
    private ERicetta|null $ricetta = null;

    public function __construct($name, $size, $type, $imageData){
        $this->name = $name;
        $this->size = $size;
        $this->type = $type;
        $this->imageData = $imageData;
    }

    public function getEncodedData(){
        if(is_resource($this->imageData)){
            $data = stream_get_contents($this->imageData);
            return $data;
        }else{
            return $this->imageData;
        }
        
    }

    /**
     * Get the value of id_image
     */
    public function getIdImage()
    {
        return $this->id_image;
    }

    /**
     * Set the value of id_image
     */
    public function setIdImage($id_image)
    {
        $this->id_image = $id_image;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the value of size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get the value of imageData
     */
    public function getImageData()
    {
        return $this->imageData;
    }

    /**
     * Set the value of imageData
     */
    public function setImageData($imageData)
    {
        $this->imageData = $imageData;
    }

    /**
     * Get the value of id_prodotto
     */
    public function getProdotto(): ?EProdotto
    {
        return $this->prodotto;
    }

    /**
     * Set the value of id_prodotto
     */
    public function setProdotto(?EProdotto $prodotto)
    {
        $this->prodotto = $prodotto;
    }

    /**
     * Get the value of ricetta
     */ 
    public function getRicetta()
    {
        return $this->ricetta;
    }

    /**
     * Set the value of ricetta
     *
     * @return  self
     */ 
    public function setRicetta($ricetta)
    {
        $this->ricetta = $ricetta;

        return $this;
    }
}