<?php
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FCliente::class)]
#[ORM\Table('cliente')]
class ECliente{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id_cliente = null;

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

    #[ORM\Column(type: 'integer', columnDefinition:'INT(3)')]
    private $punti_fedelta;

    #[ORM\OneToMany(targetEntity:EOrdine::class, mappedBy:'cliente')]
    private Collection $ordini;

    #[ORM\OneToMany(targetEntity:EIndirizzo::class, mappedBy:'cliente_residente')]
    private Collection $indirizzi;

    #[ORM\OneToMany(targetEntity:ERecensione::class, mappedBy:'cliente')]
    private Collection $recensioni;

    #[ORM\OneToMany(targetEntity:ECartaDiCredito::class, mappedBy:'proprietario')]
    private Collection $carte_di_credito;

    #[ORM\OneToMany(targetEntity:ESconto::class, mappedBy:'beneficiario')]
    private Collection $sconti;

    #[ORM\OneToMany(targetEntity:ESegnalazione::class, mappedBy:'utente')]
    private Collection $segnalazioni;

    #[ORM\JoinTable(name: 'cliente_role')]
    #[ORM\JoinColumn(name: 'cliente_id', referencedColumnName: 'id_cliente')]
    #[ORM\InverseJoinColumn(name: 'role_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: ERole::class)]
    private Collection $roles;

    public function __construct($nome,$cognome,$username,$password,$email,$cellulare,$punti_fedelta) {
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->cellulare = $cellulare; 
        $this->punti_fedelta = $punti_fedelta;
        $this->ordini = new ArrayCollection();
        $this->carte_di_credito = new ArrayCollection();
        $this->recensioni = new ArrayCollection();
        $this->sconti = new ArrayCollection();
        $this->segnalazioni = new ArrayCollection();
    }
    
    /**
     * Get the value of punti_fedelta
     *
     * @return $punti_fedelta
     */
    public function getPuntiFedelta()
    {
        return $this->punti_fedelta;
    }

    /**
     * Set the value of punti_fedelta
     *
     * @param $punti_fedelta
     */
    public function setPuntiFedelta($punti_fedelta)
    {
        $this->punti_fedelta = $punti_fedelta;
    }

    /**
     * Get the value of indirizzi
     */ 
    public function getIndirizzi()
    {
        return $this->indirizzi;
    }

    /**
     * Set the value of indirizzi
     *
     * @return  self
     */ 
    public function setIndirizzi($indirizzi)
    {
        $this->indirizzi = $indirizzi;

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
     * Get the value of sconti
     */ 
    public function getSconti()
    {
        return $this->sconti;
    }

    /**
     * Set the value of sconti
     *
     * @return  self
     */ 
    public function setSconti($sconti)
    {
        $this->sconti = $sconti;

        return $this;
    }

    /**
     * Get the value of segnalazioni
     */ 
    public function getSegnalazioni()
    {
        return $this->segnalazioni;
    }

    /**
     * Set the value of segnalazioni
     *
     * @return  self
     */ 
    public function setSegnalazioni($segnalazioni)
    {
        $this->segnalazioni = $segnalazioni;

        return $this;
    }
    
    /**
     * Get the value of ordini
     */ 
    public function getOrdini()
    {
        return $this->ordini;
    }

    /**
     * Set the value of ordini
     *
     * @return  self
     */ 
    public function setOrdini($ordini)
    {
        $this->ordini = $ordini;

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
     * Get the value of carte_di_credito
     */
    public function getCarteDiCredito(): Collection
    {
        return $this->carte_di_credito;
    }

    /**
     * Set the value of carte_di_credito
     */
    public function setCarteDiCredito(Collection $carte_di_credito): self
    {
        $this->carte_di_credito = $carte_di_credito;

        return $this;
    }

    /**
     * Get the value of id_cliente
     */
    public function getIdCliente(): ?int
    {
        return $this->id_cliente;
    }

    /**
     * Set the value of id_cliente
     */
    public function setIdCliente(?int $id_cliente): self
    {
        $this->id_cliente = $id_cliente;

        return $this;
    }
    public function toString() : String{
        return $this->getNome()."\n".
                $this->getCognome()."\n".
                $this->getUsername()."\n". 
                $this->getPassword()."\n". 
                $this->getEmail()."\n".
                $this->getCellulare()."\n".
                $this->getPuntiFedelta();
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