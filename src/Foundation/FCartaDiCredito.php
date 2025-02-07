<?php
use Doctrine\ORM\EntityRepository;

class FCartaDiCredito extends EntityRepository {
    public function findCartaDiCredito($numero_carta) {
        $dql = "SELECT carta_di_credito FROM ECartaDiCredito carta_di_credito WHERE carta_di_credito.numero_carta = ?1";
        $query = getEntityManager()->createQuery($dql);
        $query->setParameter(1, $numero_carta);
        $query->setMaxResults(1);
        return $query->getResult();
    }
    public function insertCartaDiCredito($array_data) {
        $em = getEntityManager();
        $new_carta = new ECartaDiCredito();
        $new_carta->setNome_titolare($array_data['nome']);
        $new_carta->setCognome_titolare($array_data['cognome']);
        $new_carta->setData_scadenza($array_data['scadenza']);  // Ora questo è già nel formato MM/YY
        $new_carta->setNumero_carta($array_data['numeroCarta']);
        $new_carta->setCcv($array_data['ccv']);
        $new_carta->setGestore_carta($array_data['gestore']);
        
        $cliente = $em->find(ECliente::class, $_SESSION['utente']->getIdCliente());
        $new_carta->setProprietario($cliente);
        
        $em->persist($new_carta);
        $em->flush();
    }

    public function getAllCarteCredito($idUtente)
    {
        return $this->createQueryBuilder('c')
            ->where('c.proprietario = :idUtente')
            ->setParameter('idUtente', $idUtente)
            ->orderBy('c.is_deleted', 'ASC')
            ->addOrderBy('c.numero_carta', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function deleteCartaDiCredito($numeroCarta) {
        $em = getEntityManager();
        $carta = $em->find(ECartaDiCredito::class, $numeroCarta);
        if ($carta) {
            $em->remove($carta);
            $em->flush();
        }
    }
    public function findAllActive()
    {
        return $this->createQueryBuilder('c')
            ->where('c.is_deleted = :isDeleted')
            ->setParameter('isDeleted', false)
            ->getQuery()
            ->getResult();
    }

    public function softDelete(ECartaDiCredito $carta)
    {
        $carta->setDeleted(true);
        getEntityManager()->flush();
    }

    public function canBeHardDeleted($numeroCarta): bool
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $count = $qb->select('COUNT(o.id_ordine)')
            ->from('EOrdine', 'o')
            ->where('o.carta_ordine = :numeroCarta')
            ->setParameter('numeroCarta', $numeroCarta)
            ->getQuery()
            ->getSingleScalarResult();

        return $count === 0;
    }
}