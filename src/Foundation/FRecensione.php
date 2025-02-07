<?php
use Doctrine\ORM\EntityRepository;

class FRecensione extends EntityRepository {
    public function insertRecensione(ERecensione $recensione) {
        $em = getEntityManager();
        $em->persist($recensione);
        $em->flush();
    }
    
    public function getRecensioniByProdotto($idProdotto) {
        return $this->findBy(['prodotto' => $idProdotto]);
    }
    public function getAllRecensioni(){
        $dql = "SELECT r FROM ERecensione r";
        $query = getEntityManager()->createQuery($dql);
        return $query->getResult();

    }

    public function canWriteReview($idProdotto){
        $em = getEntityManager();
        $found_cliente = $em->find(ECliente::class, $_SESSION['utente']->getIdCliente());
        $qb = $em->createQueryBuilder();
        $result = $qb->select('COUNT(DISTINCT o.id_ordine)')
        ->from('EOrdine', 'o')
        ->join('o.q_prodotto_ordine', 'op')
        ->where('op.prodotto_id = :prodotto')
        ->andWhere('o.cliente = :cliente')
        ->setParameter('prodotto', $idProdotto)
        ->setParameter('cliente', $found_cliente)
        ->getQuery()
        ->getSingleScalarResult();

        return $result > 0;  // Restituisce true se il cliente ha acquistato il prodotto, false altrimenti
    
    }
}