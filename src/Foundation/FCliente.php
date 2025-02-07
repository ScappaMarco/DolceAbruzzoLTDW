<?php
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\Tools\Pagination\Paginator;

class FCliente extends EntityRepository {

    public function findCliente($email){
        $dql = "SELECT cliente FROM ECliente cliente WHERE cliente.email = ?1";
        $query = getEntityManager()->createQuery($dql);
        $query->setParameter(1, $email);
        $query->setMaxResults(1);
        return $query->getResult();
    }
    public function insertNewCliente(ECliente $cliente){
        $em = getEntityManager();
        $em->persist($cliente);
        $em->flush();
    }

    public function deleteCliente(ECliente $cliente) {
        $em = getEntityManager();
        /**
         * Poiché l'entità da eliminare risulta detached, l'entity manager deve
         * recuperarla e poi rimuoverla però recuperandola con il Persistent Manager
         * si riceve comunque l'errore che l'entità è detached, cioè non gestita dal
         * entity Manager. Quindi nel controllore recupero tramite il Persistent Manager 
         * l'oggetto cliente dalla sessione che passo al metodo deleteCliente. 
         * Successivamente recupero di nuovo l'oggetto (per evitare l'errore dell'entity manager)
         * così da farlo gestire dall'entity manager e poi richiamare il metodo remove
         */
        $found_cliente = $em->find(ECliente::class, $cliente->getIdCliente());
        $em->remove($found_cliente);
        $em->flush();
    }
    public function updatePass(ECliente $cliente, $new_password){
        $em = getEntityManager();
        $found_cliente = $em->find(ECliente::class, $cliente->getIdCliente());
        $found_cliente->setPassword(password_hash($new_password, PASSWORD_DEFAULT));
        //Aggiorno la sessione
        $_SESSION['utente']->setPassword(password_hash($new_password, PASSWORD_DEFAULT));
        $em->persist($found_cliente);
        $em->flush();
    }
    public function updateCliente(ECliente $cliente, $array_data = null){
        $em = getEntityManager();
        if($array_data != null){
            $found_cliente = $em->find(ECliente::class, $cliente->getIdCliente());
            $found_cliente->setNome($array_data['nome']);
            $found_cliente->setCognome($array_data['cognome']);
            $found_cliente->setUsername($array_data['username']);
            $found_cliente->setCellulare($array_data['cellulare']);
            //Aggiorno la sessione
            $_SESSION['utente']->setNome($array_data['nome']);
            $_SESSION['utente']->setCognome($array_data['cognome']);
            $_SESSION['utente']->setUsername($array_data['username']);
            $_SESSION['utente']->setCellulare($array_data['cellulare']);
            $em->persist($found_cliente);
        }else{
            $em->persist($cliente);
        }
        $em->flush();
    }
    public function getPuntiFedeltaByCliente(ECliente $cliente) {
        $em = getEntityManager();
        $found_cliente = $em->find(ECliente::class, $cliente->getIdCliente());
        $punti_fedelta = $found_cliente->getPuntiFedelta();
        return $punti_fedelta;
    }

    public function sottraiPuntiFedelta(ECliente $cliente, $punti_fedelta_da_sottrarre){
        $em = getEntityManager();
        $found_cliente = $em->find(ECliente::class, $cliente->getIdCliente());
        $found_cliente->setPuntiFedelta($found_cliente->getPuntiFedelta() - $punti_fedelta_da_sottrarre);
        //Aggiorno la sessione
        $_SESSION['utente']->setPuntiFedelta($found_cliente->getPuntiFedelta());
        $em->persist($found_cliente);
        $em->flush();
    }
    public function getAllUtenti($currentPage = 1, $pageSize = 5) {
        $query = $this->createQueryBuilder('c')
            ->orderBy('c.id_cliente', 'ASC')
            ->setFirstResult(($currentPage - 1) * $pageSize)
            ->setMaxResults($pageSize)
            ->getQuery();

        $paginator = new Paginator($query, $fetchJoinCollection = true);

        return [
            'utenti' => $paginator,
            'totalItems' => count($paginator),
            'currentPage' => $currentPage,
            'pageSize' => $pageSize,
            'totalPages' => ceil(count($paginator) / $pageSize)
        ];
    }
}
?>