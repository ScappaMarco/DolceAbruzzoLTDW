<?php
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class FSegnalazione extends EntityRepository {
    public function insertSegnalazione(ESegnalazione $segnalazione) {
        $em = getEntityManager();
        $em->persist($segnalazione);
        $em->flush();
    }
    
    public function getAllSegnalazioni($currentPage = 1, $pageSize = 5) {
        $query = $this->createQueryBuilder('s')
            ->setFirstResult(($currentPage - 1) * $pageSize)
            ->setMaxResults($pageSize)
            ->getQuery();

        $paginator = new Paginator($query, $fetchJoinCollection = true);

        return [
            'segnalazioni' => $paginator,
            'totalItems' => count($paginator),
            'currentPage' => $currentPage,
            'pageSize' => $pageSize,
            'totalPages' => ceil(count($paginator) / $pageSize)
        ];
    }
    public function findSegnalazioneByUtenteAndRecensione($idUtente, $idRecensione)
    {
        return $this->findOneBy([
            'utente' => $idUtente,
            'recensione_segnalata' => $idRecensione
        ]);
    }
}