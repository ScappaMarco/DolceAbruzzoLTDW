<?php
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class FRicetta extends EntityRepository {
    
    public function insertRicetta(ERicetta $ricetta) {
        $em = getEntityManager();
        $em->persist($ricetta);
        $em->flush();
    }

    public function deleteRicetta($idRicetta) {
        $em = getEntityManager();
        $found_ricetta = $em->find(ERicetta::class, $idRicetta);
        $em->remove($found_ricetta);
        $em->flush();
    }

    public function updateRicetta(ERicetta $ricetta, $array_data) {
        $em = getEntityManager();
        $found_ricetta = $em->find(ERicetta::class, $ricetta->getId_ricetta());
        $found_ricetta->setTitolo($array_data['titolo']);
        $found_ricetta->setDescrizione($array_data['descrizione']);
        $found_ricetta->setIngredienti($array_data['ingredienti']);
        $found_ricetta->setProcedimento($array_data['procedimento']);
        $em->persist($found_ricetta);
        $em->flush();
    }

    public function updateImageRicetta(ERicetta $ricetta, EImmagine $immagine) {
        $em = getEntityManager();
        $found_ricetta = $em->find(ERicetta::class, $ricetta->getId_ricetta());
        $found_immagine = $em->find(EImmagine::class, $immagine->getIdImage());
        if($found_ricetta->getImmagine() != null) {
            $em->remove($found_ricetta->getImmagine());
        }
        $found_ricetta->setImmagine($found_immagine);
        $em->persist($found_ricetta);
        $em->flush();
    }

    public function deleteImageRicetta($ricettaId) {
        $em = getEntityManager();
        $found_ricetta = $em->find(ERicetta::class, $ricettaId);
        $em->remove($found_ricetta->getImmagine()); 
        $em->flush();
    }
    
    public function getAllRicette($currentPage = 1, $pageSize = 4) {
        $dql = "SELECT ricetta
                FROM ERicetta ricetta";
        $query = getEntityManager()->createQuery($dql)
        ->setFirstResult(($currentPage - 1) * $pageSize)
        ->setMaxResults($pageSize);

        $paginator = new Paginator($query, fetchJoinCollection: true);

        return [
        'ricette' => iterator_to_array($paginator),
        'n_ricette' => count($paginator),
        'currentPage' => $currentPage,
        'pageSize' => $pageSize,
        'totalPages' => ceil(count($paginator) / $pageSize)
        ];
    }

    public function getImageRicetta(ERicetta $ricetta) {
        $em = getEntityManager();
        $found_ricetta = $em->find(ERicetta::class, $ricetta->getId_ricetta());
        $found_image = $found_ricetta->getImmagine();
        return $found_image;
    }
}