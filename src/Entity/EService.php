<?php
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FService::class)]
#[ORM\Table('service')]
class EService{
    
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\Column(type: 'string', columnDefinition: 'VARCHAR(30)')]
    private $controllore;

    #[ORM\Column(type: 'string', columnDefinition: 'VARCHAR(30)')]
    private $metodo;
    
    public function __construct($id,$controllore,$metodo) {
        $this->id = $id;
        $this->controllore = $controllore;
        $this->metodo = $metodo;
    }

    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?int $id)
    {
        $this->id = $id;
    }

    /**
     * Get the value of controllore
     */
    public function getControllore()
    {
        return $this->controllore;
    }

    /**
     * Set the value of controllore
     */
    public function setControllore($controllore)
    {
        $this->controllore = $controllore;
    }

    /**
     * Get the value of metodo
     */
    public function getMetodo()
    {
        return $this->metodo;
    }

    /**
     * Set the value of metodo
     */
    public function setMetodo($metodo)
    {
        $this->metodo = $metodo;
    }
}
?>