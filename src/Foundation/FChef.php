<?php
use Doctrine\ORM\EntityRepository;

class FChef extends EntityRepository {
    public function findChef($email) {
        $dql = "SELECT chef FROM EChef chef WHERE chef.email = ?1";
        $query = getEntityManager()->createQuery($dql);
        $query->setParameter(1, $email);
        $query->setMaxResults(1);
        return $query->getResult();
    }
    public function insertNewChef(EChef $chef){
        $em = getEntityManager();
        $em->persist($chef);
        $em->flush();
    }

    public function deleteChef(EChef $chef) {
        $em = getEntityManager();
        $found_chef = $em->find(EChef::class, $chef->getIdChef());
        $em->remove($found_chef);
        $em->flush();
    }
    public function updatePass(EChef $chef, $new_password){
        $em = getEntityManager();
        $found_chef = $em->find(EChef::class, $chef->getIdChef());
        $found_chef->setPassword(password_hash($new_password, PASSWORD_DEFAULT));
        //Aggiorno la sessione
        $_SESSION['utente']->setPassword(password_hash($new_password, PASSWORD_DEFAULT));
        $em->persist($found_chef);
        $em->flush();
    }
    public function updateChef(EChef $chef, $array_data){
        $em = getEntityManager();
        $found_chef = $em->find(EChef::class, $chef->getIdChef());
        $found_chef->setNome($array_data['nome']);
        $found_chef->setCognome($array_data['cognome']);
        $found_chef->setUsername($array_data['username']);
        $found_chef->setCellulare($array_data['cellulare']);
        //Aggiorno la sessione
        $_SESSION['utente']->setNome($array_data['nome']);
        $_SESSION['utente']->setCognome($array_data['cognome']);
        $_SESSION['utente']->setUsername($array_data['username']);
        $_SESSION['utente']->setCellulare($array_data['cellulare']);
        $em->persist($found_chef);
        $em->flush();
    }
}