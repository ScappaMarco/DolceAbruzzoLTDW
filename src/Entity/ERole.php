<?php
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: FRole::class)]
#[ORM\Table('role')]
class ERole{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\Column(type: 'string', columnDefinition: 'VARCHAR(30)')]
    private $name;

    #[ORM\Column(type: 'string', columnDefinition: 'TEXT')]
    private $descrizione;

    #[ORM\JoinTable(name: 'role_service')]
    #[ORM\JoinColumn(name: 'role_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'service_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: EService::class)]
    private Collection $services;

    public function __construct($id,$name,$descrizione) {
        $this->id = $id;
        $this->name = $name;
        $this->descrizione = $descrizione;
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
     * Get the value of descrizione
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    /**
     * Set the value of descrizione
     */
    public function setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;
    }

    /**
     * Get the value of services
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    /**
     * Set the value of services
     */
    public function setServices(Collection $services)
    {
        $this->services = $services;
    }
}

?>