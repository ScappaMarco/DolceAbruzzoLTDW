<?php
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class FProdotto extends EntityRepository {
    public function insertProdotto(EProdotto $prodotto){
        $em = getEntityManager();
        $em->persist($prodotto);
        $em->flush();
    }
    public function deleteProdotto($prodotto) {
        $em = getEntityManager();
        $found_prodotto = $em->find(EProdotto::class, $prodotto);
        $em->remove($found_prodotto);
        $em->flush();
    }
    public function updateProdotto(EProdotto $prodotto, $array_data){
        $em = getEntityManager();
        $found_prodotto = $em->find(EProdotto::class, $prodotto->getIdProdotto());
        $found_prodotto->setNome($array_data['nome']);
        $found_prodotto->setDescrizione($array_data['descrizione']);
        $found_prodotto->setIngredienti($array_data['ingredienti']);
        $found_prodotto->setPrezzo($array_data['prezzo']);
        $found_prodotto->setPunti_fedelta($array_data['punti_fedelta']);
        $found_prodotto->setQuantitaDisp($array_data['quantita_disp']);
        $em->persist($found_prodotto);
        $em->flush();
    }
    public function updateImageProdotto(EProdotto $prodotto, EImmagine $immagine){
        $em = getEntityManager();
        $found_prodotto = $em->find(EProdotto::class, $prodotto->getIdProdotto());
        $found_image =  $em->find(EImmagine::class, $immagine->getIdImage());
        $found_prodotto->addImage($found_image);
        $em->persist($found_prodotto);
        $em->flush();
    }
    public function updateCatProdotto(EProdotto $prodotto, ECategoria $categoria){
        $em = getEntityManager();
        $found_prodotto = $em->find(EProdotto::class, $prodotto->getIdProdotto());
        $found_categoria = $em->find(ECategoria::class, $categoria->getNomeCategoria());
        $found_prodotto->setNomeCategoria($found_categoria);
        $em->persist($found_prodotto);
        $em->flush();
    }
    public function getAllProducts($currentPage = 1, $pageSize = 4, $minPrice = null, $maxPrice = null, $isGlutenFree = false){
        $dql = "SELECT prodotto
                FROM EProdotto prodotto
                JOIN prodotto.nome_categoria categoria
                WHERE 1=1";
        
        $parameters = [];
        
        if ($minPrice !== null) {
            $dql .= " AND prodotto.prezzo >= :minPrice";
            $parameters['minPrice'] = $minPrice;
        }
        
        if ($maxPrice !== null) {
            $dql .= " AND prodotto.prezzo <= :maxPrice";
            $parameters['maxPrice'] = $maxPrice;
        }
        
        if ($isGlutenFree) {
            $dql .= " AND prodotto.is_gluten_free = :isGlutenFree";
            $parameters['isGlutenFree'] = true;
        }
        
        $query = getEntityManager()->createQuery($dql)
            ->setFirstResult(($currentPage - 1) * $pageSize)
            ->setMaxResults($pageSize);
        
        foreach ($parameters as $key => $value) {
            $query->setParameter($key, $value);
        }
    
        $paginator = new Paginator($query, fetchJoinCollection: true);
    
        return [
            'prodotti' => iterator_to_array($paginator),
            'n_prodotti' => count($paginator),
            'currentPage' => $currentPage,
            'pageSize' => $pageSize,
            'totalPages' => ceil(count($paginator) / $pageSize)
        ];
    }
    
    public function getAllProductsByCat($categoria, $currentPage = 1, $pageSize = 4, $minPrice = null, $maxPrice = null, $isGlutenFree = false){
        $dql = "SELECT prodotto
                FROM EProdotto prodotto
                JOIN prodotto.nome_categoria categoria
                WHERE categoria.nome_categoria = :categoria";
        
        $parameters = ['categoria' => $categoria];
        
        if ($minPrice !== null) {
            $dql .= " AND prodotto.prezzo >= :minPrice";
            $parameters['minPrice'] = $minPrice;
        }
        
        if ($maxPrice !== null) {
            $dql .= " AND prodotto.prezzo <= :maxPrice";
            $parameters['maxPrice'] = $maxPrice;
        }
        
        if ($isGlutenFree) {
            $dql .= " AND prodotto.is_gluten_free = :isGlutenFree";
            $parameters['isGlutenFree'] = true;
        }
        
        $query = getEntityManager()->createQuery($dql)
            ->setFirstResult(($currentPage - 1) * $pageSize)
            ->setMaxResults($pageSize);
        
        foreach ($parameters as $key => $value) {
            $query->setParameter($key, $value);
        }
    
        $paginator = new Paginator($query, fetchJoinCollection: true);
    
        return [
            'prodotti' => iterator_to_array($paginator),
            'n_prodotti' => count($paginator),
            'currentPage' => $currentPage,
            'pageSize' => $pageSize,
            'totalPages' => ceil(count($paginator) / $pageSize)
        ];
    }
    public function getLatestProducts(){
        $dql = "SELECT prodotto.id_prodotto, prodotto.nome, prodotto.prezzo, categoria.nome_categoria
                FROM EProdotto prodotto
                JOIN prodotto.nome_categoria categoria
                ORDER BY prodotto.id_prodotto DESC";
        $query = getEntityManager()->createQuery($dql)
        ->setMaxResults(4);
        return $query->getResult();
    }
    public function getProductById($idProdotto){
        $dql = "SELECT prodotto, categoria.nome_categoria
                FROM EProdotto prodotto
                JOIN prodotto.nome_categoria categoria
                WHERE prodotto.id_prodotto = ?1";
        $query = getEntityManager()->createQuery($dql);
        $query->setParameter(1, $idProdotto);
        return $query->getSingleResult();
    }
}