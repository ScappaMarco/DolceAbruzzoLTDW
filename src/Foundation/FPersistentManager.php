<?php
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class FPersistentManager{

    /**
     * Singleton Class
     */
     private static $instance;
     private $repositories = [];


     private function __construct(){


     }

     public static function getInstance(){
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get the repository for an entity.
     *
     * @param string $entityClass
     * @return EntityRepository
     */
    public function getRepository(string $entityClass): EntityRepository
    {
        if (!isset($this->repositories[$entityClass])) {
            $this->repositories[$entityClass] = getEntityManager()->getRepository($entityClass);
        }

        return $this->repositories[$entityClass];
    }

    /**
     * Persist an entity.
     *
     * @param object $entity
     */
    public function persist($entity): void
    {
       getEntityManager()->persist($entity);
    }

    /**
     * Remove an entity.
     *
     * @param object $entity
     */
    public function remove($entity): void
    {
       getEntityManager()->remove($entity);
    }

    /**
     * Flush the changes to the database.
     */
    public function flush(): void
    {
       getEntityManager()->flush();
    }

    /**
     * Clear the EntityManager.
     */
    public function clear(): void
    {
       getEntityManager()->clear();
    }

    /**
     * Find an entity by its identifier.
     *
     * @param string $entityClass
     * @param mixed $id
     * @return object|null
     */
    public function find(string $entityClass, $id)
    {
        return $this->getRepository($entityClass)->find($id);
    }

    /**
     * Find all entities of a class.
     *
     * @param string $entityClass
     * @return array
     */
    public function findAll(string $entityClass): array
    {
        return $this->getRepository($entityClass)->findAll();
    }

    /**
     * Find entities by criteria.
     *
     * @param string $entityClass
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function findBy(string $entityClass, array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->getRepository($entityClass)->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Find one entity by criteria.
     *
     * @param string $entityClass
     * @param array $criteria
     * @return object|null
     */
    public function findOneBy(string $entityClass, array $criteria)
    {
        return $this->getRepository($entityClass)->findOneBy($criteria);
    }
    public function findUtente($utente){
        /** Se $cliente è un oggetto richiamerà findCliente($cliente->getEmail())
         * altrimenti se è una stringa (cioè se è una email) richiamerà findCliente($cliente)
         */
        if($utente instanceof ECliente){
            if(is_object($utente)){
                return getEntityManager()->getRepository('ECliente')->findCliente($utente->getEmail());
            }else if(is_string($utente)){
                return getEntityManager()->getRepository('ECliente')->findCliente($utente);
            }else{
                return null;
            }
        }else if($utente instanceof EChef){
            if(is_object($utente)){
                return getEntityManager()->getRepository('EChef')->findChef($utente->getEmail());
            }else if(is_string($utente)){
                return getEntityManager()->getRepository('EChef')->findChef($utente);
            }else{
                return null;
            }
        } else if(is_string($utente)){
            if(getEntityManager()->getRepository('ECliente')->findCliente($utente) != null){
                return getEntityManager()->getRepository('ECliente')->findCliente($utente);
            }else if(getEntityManager()->getRepository('EChef')->findChef($utente) != null){
                return getEntityManager()->getRepository('EChef')->findChef($utente);
            }else{
                return null;
            }       
        }
    }
    public function insertNewUtente($new_utente){
        if($new_utente instanceof ECliente){
            getEntityManager()->getRepository('ECliente')->insertNewCliente($new_utente);
        }else if($new_utente instanceof EChef){
            getEntityManager()->getRepository('EChef')->insertNewChef($new_utente);
        } 
        
    }
    public function updatePass($utente, $new_password){
        if($utente instanceof ECliente){
            getEntityManager()->getRepository('ECliente')->updatePass($utente, $new_password);
        }else if($utente instanceof EChef){
            getEntityManager()->getRepository('EChef')->updatePass($utente, $new_password);
        } 
    }
    public function updateUtente($utente, $array_data){
        if($utente instanceof ECliente){
            getEntityManager()->getRepository('ECliente')->updateCliente($utente, $array_data);
        }else if($utente instanceof EChef){
            getEntityManager()->getRepository('EChef')->updateChef($utente, $array_data);
        } 
    }
    public function deleteUtente($utente){
        if($utente instanceof ECliente){
            getEntityManager()->getRepository('ECliente')->deleteCliente($utente);
        }else if($utente instanceof EChef){
            getEntityManager()->getRepository('EChef')->deleteChef($utente);
        } 
    }
    public function insertProdotto($prodotto){
        getEntityManager()->getRepository('EProdotto')->insertProdotto($prodotto);
    }
    public function deleteProdotto($prodotto){
        getEntityManager()->getRepository('EProdotto')->deleteProdotto($prodotto);
    }
    public function updateProdotto($prodotto, $array_data) {
        getEntityManager()->getRepository('EProdotto')->updateProdotto($prodotto, $array_data);
    }
    public function insertRicetta($ricetta){
        getEntityManager()->getRepository('ERicetta')->insertRicetta($ricetta);
    }
    public function deleteRicetta($ricetta) {
        getEntityManager()->getRepository('ERicetta')->deleteRicetta($ricetta);
    }
    public function updateRicetta($ricetta, $array_data) {
        getEntityManager()->getRepository('ERicetta')->updateRicetta($ricetta, $array_data);
    }
    public function getAllImages($prodotto){
        return getEntityManager()->getRepository('EImmagine')->getAllImages($prodotto);
    }
    public function getImageRicetta($ricetta) {
        return getEntityManager()->getRepository('ERicetta')->getImageRicetta($ricetta);
    }
    public function getAllProducts($currentPage, $is_gluten_free = false){
        return getEntityManager()->getRepository('EProdotto')->getAllProducts($currentPage, $is_gluten_free);
    }
    public function getAllProductsByCat($categoria, $currentPage, $is_gluten_free = false){
        return getEntityManager()->getRepository('EProdotto')->getAllProductsByCat($categoria, $currentPage, $is_gluten_free);
    }
    public function getLatestProducts(){
        return getEntityManager()->getRepository('EProdotto')->getLatestProducts();
    }
    public function getProductById($idProdotto) {
        return getEntityManager()->getRepository('EProdotto')->getProductById($idProdotto);
    }
    public function getAllRicette($currentPage){
        return getEntityManager()->getRepository('ERicetta')->getAllRicette($currentPage);
    }
    public function insertImmagine($immagine){
        getEntityManager()->getRepository('EImmagine')->insertImmagine($immagine);
    }
    public function findImage($image){
        return getEntityManager()->getRepository('EImmagine')->findImage($image);
    }
    public function findCategoria($categoria){
        return getEntityManager()->getRepository('ECategoria')->findCategoria($categoria);
    }
    public function updateCatProdotto($prodotto, $categoria){
        getEntityManager()->getRepository('EProdotto')->updateCatProdotto($prodotto, $categoria);
    }
    public function updateImageProdotto($prodotto, $immagine){
        getEntityManager()->getRepository('EProdotto')->updateImageProdotto($prodotto,$immagine);
    }
    public function updateImageRicetta($ricetta, $image) {
        getEntityManager()->getRepository('ERicetta')->updateImageRicetta($ricetta, $image);
    }
    public function deleteAllImages($productId){
        getEntityManager()->getRepository('EImmagine')->deleteAllImages($productId);
    }

    public function checkForRecipeChanges($postData, $idRicetta) {
        $em = getEntityManager();
        $found_ricetta = $em->find(ERicetta::class, $idRicetta);
        $modified = false;
        
        if(trim($found_ricetta->getTitolo()) != trim($postData['titolo'])) {
            $modified = true;
        }
        
        if(trim($found_ricetta->getDescrizione()) != trim($postData['descrizione'])) {
            $modified = true;
        }
        
        if(trim($found_ricetta->getIngredienti()) != trim($postData['ingredienti'])) {
            $modified = true;
        }
        
        if(trim($found_ricetta->getProcedimento()) != trim($postData['procedimento'])) {
            $modified = true;
        }
        return $modified;
    }
    public function checkForProductChanges($postData, $productId){
        $em = getEntityManager();
        $found_prodotto = $em->find(EProdotto::class, $productId);
        $modified = false;

        if(trim( $found_prodotto->getNome()) != trim($postData['nome'])) {
            $modified = true;
        }
        
        if(trim($found_prodotto->getDescrizione()) != trim($postData['descrizione'])) {
            $modified = true;
        }
        
        if(trim($found_prodotto->getIngredienti()) != trim($postData['ingredienti'])) {
            $modified = true;
        }
        
        if(trim($found_prodotto->getPrezzo()) != trim($postData['prezzo'])) {
            $modified = true;
        }

        if(trim($found_prodotto->getPunti_fedelta()) != trim($postData['punti_fedelta'])) {
            $modified = true;
        }

        if(trim($found_prodotto->getQuantitaDisp()) != trim($postData['quantita_disp'])) {
            $modified = true;
        }
        return $modified;
    }
    
    /* public function getListProducts($categoria = "all",$currentPage, $is_gluten_free = false){
        if($categoria == "all"){
            $array_prodotti = FPersistentManager::getInstance()->getAllProducts($currentPage, $is_gluten_free);
        }else{
            $array_prodotti = FPersistentManager::getInstance()->getAllProductsByCat($categoria, $currentPage, $is_gluten_free);
        }
        return $array_prodotti;
    }
        */
    public function getListProducts($currentPage, $pageSize = 4, $minPrice = null, $maxPrice = null, $isGlutenFree = false){
        return getEntityManager()->getRepository('EProdotto')->getAllProducts($currentPage, $pageSize, $minPrice, $maxPrice, $isGlutenFree);
    }
    
    public function getListProductsByCat($categoria, $currentPage, $pageSize = 4, $minPrice = null, $maxPrice = null, $isGlutenFree = false){
        return getEntityManager()->getRepository('EProdotto')->getAllProductsByCat($categoria, $currentPage, $pageSize, $minPrice, $maxPrice, $isGlutenFree);
    }
    public function getLatestProductsHome(){

        $array_prodotti = FPersistentManager::getInstance()->getLatestProducts();
    
        for($i = 0; $i < sizeof($array_prodotti); $i++){
            $prod_item = FPersistentManager::getInstance()->find(EProdotto::class,$array_prodotti[$i]['id_prodotto']);
            $array_immagini = FPersistentManager::getInstance()->getAllImages($prod_item);
            foreach($array_immagini as $immagine) {
                $array_prodotti[$i]['images'] = $immagine;
            }
        }
        return $array_prodotti;
    }

    public function getListRicette($currentPage) {
        $array_ricette = FPersistentManager::getInstance()->getAllRicette($currentPage);
        /*
        if($array_ricette != null){
            for($i = 0; $i < sizeof($array_ricette); $i++) {
                $ricetta_item = FPersistentManager::getInstance()->find(ERicetta::class, $array_ricette[$i]['id_ricetta']);
                $immagine_ricetta = $ricetta_item->getImmagine();
                $immagine_ricetta->setImageData(stream_get_contents($immagine_ricetta->getImageData()));
    
                $array_ricette[$i]['image'] = $immagine_ricetta;
            }
        }
        */
        return $array_ricette;
    }
    public function getAllCategories(){
        return getEntityManager()->getRepository('ECategoria')->getAllCategories();
    }

    public function getPuntiFedeltaByCliente($cliente) {
        return getEntityManager()->getRepository('ECliente')->getPuntiFedeltaByCliente($cliente);
    }

    public function insertSconto($sconto, $stringa_sconto) {
        getEntityManager()->getRepository('ESconto')->insertSconto($sconto, $stringa_sconto);
    }

    public function sottraiPuntiFedelta($cliente, $punti_fedelta_da_sottrarre) {
        getEntityManager()->getRepository('ECliente')->sottraiPuntiFedelta($cliente, $punti_fedelta_da_sottrarre);
    }
    public function insertIndirizzo($array_data){
        getEntityManager()->getRepository('EIndirizzo')->insertIndirizzo($array_data);
    }
    public function getAllIndirizziUtente($idUtente){
        return getEntityManager()->getRepository('EIndirizzo')->getAllIndirizziUtente($idUtente);
    }
    public function deleteIndirizzo($indirizzo){
        getEntityManager()->getRepository('EIndirizzo')->deleteIndirizzo($indirizzo);
    }
    public function findIndirizzo($indirizzo, $cap){
        return getEntityManager()->getRepository('EIndirizzo')->findIndirizzo($indirizzo, $cap);
    }
    public function insertCartaDiCredito($array_data) {
        getEntityManager()->getRepository('ECartaDiCredito')->insertCartaDiCredito($array_data);
    }

    public function getAllCarteCredito($idUtente) {
        return getEntityManager()->getRepository('ECartaDiCredito')->getAllCarteCredito($idUtente);
    }

    public function deleteCartaDiCredito($numeroCarta) {
        getEntityManager()->getRepository('ECartaDiCredito')->deleteCartaDiCredito($numeroCarta);
    }
    public function getOrdiniUtente()
    {
        return getEntityManager()->getRepository('EOrdine')->findOrdiniUtente($_SESSION['utente']->getIdCliente());
    }

    public function creaOrdine($indirizzo, $cap, $numeroCarta, $carrello, $codiceSconto)
    {
        return getEntityManager()->getRepository('EOrdine')->creaOrdine($indirizzo, $cap, $numeroCarta, $carrello, $codiceSconto);
    }
    public function findCartaDiCredito($numero_carta){
        return getEntityManager()->getRepository('ECartaDiCredito')->findCartaDiCredito($numero_carta);
    }
    public function findAllActiveIndirizzi() {
        return getEntityManager()->getRepository('EIndirizzo')->findAllActive();
    }

    public function softDeleteIndirizzo(EIndirizzo $indirizzo) {
        $indirizzo->setDeleted(true);
        getEntityManager()->flush();
    }

    public function canIndirizzoBeHardDeleted($indirizzo, $cap): bool {
        return getEntityManager()->getRepository('EIndirizzo')->canBeHardDeleted($indirizzo, $cap);
    }

    public function findAllActiveCarteDiCredito() {
        return getEntityManager()->getRepository('ECartaDiCredito')->findAllActive();
    }

    public function softDeleteCartaDiCredito(ECartaDiCredito $carta) {
        $carta->setDeleted(true);
        getEntityManager()->flush();
    }

    public function canCartaDiCreditoBeHardDeleted($numeroCarta): bool {
        return getEntityManager()->getRepository('ECartaDiCredito')->canBeHardDeleted($numeroCarta);
    }
    public function riattivaIndirizzo(EIndirizzo $indirizzo) {
        $indirizzo->setDeleted(false);
        getEntityManager()->flush();
    }

    public function riattivaCarta(ECartaDiCredito $carta) {
        $carta->setDeleted(false);
        getEntityManager()->flush();
    }
    public function verificaSconto(string $codice): ?ESconto {
        $sconto = getEntityManager()->find(ESconto::class, $codice);
    
        if ($sconto && $sconto->isValid()) {
            return $sconto;
        }
    
        return null;
    }
    public function getAllCodiciScontoCliente(){
        return getEntityManager()->getRepository('ESconto')->getAllCodiciScontoCliente();
    }
    public function getAllPendingOrders()
    {
        return getEntityManager()->getRepository('EOrdine')->findAllPendingOrders();
    }

    public function updateOrderStatus($orderId, $newStatus)
    {
        getEntityManager()->getRepository('EOrdine')->updateOrderStatus($orderId, $newStatus);
    }
    public function insertRecensione(ERecensione $recensione) {
        return getEntityManager()->getRepository('ERecensione')->insertRecensione($recensione);
    }
    
    public function getRecensioniByProdotto($idProdotto) {
        return getEntityManager()->getRepository('ERecensione')->getRecensioniByProdotto($idProdotto);
    }
    public function getAllRecensioni(){
        return getEntityManager()->getRepository('ERecensione')->getAllRecensioni();
    }
    
    public function insertSegnalazione(ESegnalazione $segnalazione) {
        return getEntityManager()->getRepository('ESegnalazione')->insertSegnalazione($segnalazione);
    }
    
    public function getAllSegnalazioni($currentPage = 1, $pageSize = 5) {
        return getEntityManager()->getRepository('ESegnalazione')->getAllSegnalazioni($currentPage, $pageSize);
    }
    
    public function findSegnalazioneByUtenteAndRecensione($idUtente, $idRecensione) {
        return getEntityManager()->getRepository('ESegnalazione')->findSegnalazioneByUtenteAndRecensione($idUtente, $idRecensione);
    }
    public function getAllUtenti($currentPage = 1, $pageSize = 5) {
        return getEntityManager()->getRepository('ECliente')->getAllUtenti($currentPage, $pageSize);
    }
    public function cercaProdotti($query, $currentPage = 1, $pageSize = 4){
        $em = getEntityManager();
        $qb = $em->createQueryBuilder();
        
        $qb->select('p')
        ->from('EProdotto', 'p')
        ->where($qb->expr()->orX(
            $qb->expr()->like('p.nome', ':query'),
            $qb->expr()->like('p.descrizione', ':query'),
            $qb->expr()->like('p.ingredienti', ':query')
        ))
        ->setParameter('query', '%' . $query . '%')
        ->setFirstResult(($currentPage - 1) * $pageSize)
        ->setMaxResults($pageSize);

        $paginator = new Paginator($qb->getQuery(), $fetchJoinCollection = true);

        return [
            'prodotti' => iterator_to_array($paginator),
            'n_prodotti' => count($paginator),
            'currentPage' => $currentPage,
            'pageSize' => $pageSize,
            'totalPages' => ceil(count($paginator) / $pageSize)
        ];
    }
    public function canWriteReview($idProdotto){
        return getEntityManager()->getRepository('ERecensione')->canWriteReview($idProdotto);
    }
}
?>