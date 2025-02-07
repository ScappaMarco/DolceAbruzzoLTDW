<?php
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FChef::class)]
#[ORM\Table('chef')]
class EChef{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id_chef = null;

    #[ORM\Column(type: 'string', length:50, columnDefinition: 'VARCHAR(50)')]
    private $nome;

    #[ORM\Column(type: 'string', length:70, columnDefinition: 'VARCHAR(70)')]
    private $cognome;

    #[ORM\Column(type: 'string', length:50, columnDefinition: 'VARCHAR(50)')]
    private $username;

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length:70, columnDefinition: 'VARCHAR(70)')]
    private $email;

    #[ORM\Column(type: 'string', length:10, columnDefinition: 'VARCHAR(10)')]
    private $cellulare;

    #[ORM\Column(type: 'string')]
    private $specializzazione;

    #[ORM\OneToMany(targetEntity:Ericetta::class, mappedBy:'chef_ricetta')]
    private Collection $ricette_pubblicate;

    #[ORM\JoinTable(name: 'chef_role')]
    #[ORM\JoinColumn(name: 'chef_id', referencedColumnName: 'id_chef')]
    #[ORM\InverseJoinColumn(name: 'role_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: ERole::class)]
    private Collection $roles;


    public function __construct($nome,$cognome,$username,$password,$email,$cellulare,$specializzazione) {
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->cellulare = $cellulare; 
        $this->specializzazione = $specializzazione;
        $this->ricette_pubblicate = new ArrayCollection();
    }

    /**
     * Get the value of specializzazione
     *
     * @return $specializzazione
     */
    public function getSpecializzazione()
    {
        return $this->specializzazione;
    }

    /**
     * Set the value of specializzazione
     *
     * @param $specializzazione
     */
    public function setSpecializzazione($specializzazione)
    {
        $this->specializzazione = $specializzazione;
    }

    /**
     * Get the value of ricette_pubblicate
     */ 
    public function getRicette_pubblicate()
    {
        return $this->ricette_pubblicate;
    }

    /**
     * Set the value of ricette_pubblicate
     *
     * @return  self
     */ 
    public function setRicette_pubblicate($ricette_pubblicate)
    {
        $this->ricette_pubblicate = $ricette_pubblicate;

        return $this;
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
     */
    public function setNome($nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of cognome
     */
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * Set the value of cognome
     */
    public function setCognome($cognome): self
    {
        $this->cognome = $cognome;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     */
    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of cellulare
     */
    public function getCellulare()
    {
        return $this->cellulare;
    }

    /**
     * Set the value of cellulare
     */
    public function setCellulare($cellulare): self
    {
        $this->cellulare = $cellulare;

        return $this;
    }

    /**
     * Get the value of id_chef
     */
    public function getIdChef(): ?int
    {
        return $this->id_chef;
    }

    /**
     * Set the value of id_chef
     */
    public function setIdChef(?int $id_chef): self
    {
        $this->id_chef = $id_chef;

        return $this;
    }

    /**
     * Get the value of ricette_pubblicate
     */
    public function getRicettePubblicate(): Collection
    {
        return $this->ricette_pubblicate;
    }

    /**
     * Set the value of ricette_pubblicate
     */
    public function setRicettePubblicate(Collection $ricette_pubblicate): self
    {
        $this->ricette_pubblicate = $ricette_pubblicate;

        return $this;
    }

    /**
     * Get the value of roles
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    /**
     * Set the value of roles
     */
    public function setRoles(Collection $roles)
    {
        $this->roles = $roles;
    }
}
?>