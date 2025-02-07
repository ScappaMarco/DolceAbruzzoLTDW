<?php
use Doctrine\ORM\EntityRepository;

class FOrdine extends EntityRepository {

    //funzioni specializzate per il tipo di stato dell'ordine
    /*
    public function findOrdiniConsegnati() {
        $dql = "SELECT ordine FROM EOrdine ordine WHERE ordine.stato_ordine = 'consegnato'";
        $query = getEntityManager()->createQuery($dql);
        return $query->getResult();
    }

    public function findLOrdiniInConsegna() {
        $dql = "SELECT ordine FROM EOrdine ordine WHERE ordine.stato_ordine = 'in consegna'";
        $query = getEntityManager()->createQuery($dql);
        return $query->getResult();
    }

    public function findOrdiniSpediti() {
        $dql = "SELECT ordine FROM EOrdine ordine WHERE ordine.stato_ordine = 'spedito'";
        $query = getEntityManager()->createQuery($dql);
        return $query->getResult();
    }
    */

    public function findOrdiniUtente($idCliente)
    {
        return $this->findBy(['cliente' => $idCliente], ['id_ordine' => 'DESC']);
    }

    public function creaOrdine($indirizzo, $cap, $numeroCarta, $carrello, $codiceSconto = null){
        $em = getEntityManager();
        $em->beginTransaction(); // Inizia una transazione

        try {
            $cliente = $em->find(ECliente::class, $_SESSION['utente']->getIdCliente());
            $indirizzoObj = $em->find(EIndirizzo::class, ['indirizzo' => $indirizzo, 'cap' => $cap]);
            if (!$indirizzoObj) {
                throw new \Exception("Indirizzo non trovato");
            }
            $cartaObj = $em->find(ECartaDiCredito::class, $numeroCarta);

            $ordine = new EOrdine();
            $ordine->setCliente($cliente);
            $ordine->setIndirizzo_spedizione($indirizzoObj);
            $ordine->setCarta_ordine($cartaObj);

            $totale = 0;
            $quantitaTotale = 0;
            $puntiFedelta = 0;

            foreach ($carrello as $idProdotto => $quantita) {
                $prodotto = $em->find(EProdotto::class, $idProdotto);
                $ordineProdotto = new EOrdineProdotto();
                $ordineProdotto->setOrdineId($ordine);
                $ordineProdotto->setProdottoId($prodotto);
                $ordineProdotto->setQuantitaOrdinataProdotto($quantita);
                $puntiFedelta += $prodotto->getPunti_fedelta() * $quantita;
                $em->persist($ordineProdotto);

                $ordine->addQProdottoOrdine($ordineProdotto);

                $totale += $prodotto->getPrezzo() * $quantita;
                $quantitaTotale += $quantita;

                // Aggiorna la quantità disponibile del prodotto
                $prodotto->setQuantitaDisp($prodotto->getQuantitaDisp() - $quantita);
                $em->persist($prodotto);
            }

            $ordine->setImporto_ordine($totale);
            $ordine->setQuantita_tot_prodotti($quantitaTotale);

            // Applica lo sconto se presente
            if (!empty($codiceSconto)) {
                $sconto = FPersistentManager::getInstance()->verificaSconto($codiceSconto);
                if ($sconto != null) {
                    $ordine->applicaSconto($sconto);
                    $em->persist($sconto); // Persisti le modifiche allo sconto
                }
            }

            $ordine->setPuntiFedeltaGuadagnati($puntiFedelta);

            $em->persist($ordine);
            $em->flush();

            // Aggiorna i punti fedeltà del cliente
            $cliente->setPuntiFedelta($cliente->getPuntiFedelta() + $puntiFedelta);
            $_SESSION['utente']->setPuntiFedelta($cliente->getPuntiFedelta());
            $em->persist($cliente);
            $em->flush();

            $em->commit();
            return $ordine;
        } catch (Exception $e) {
            $em->rollback(); // Annulla la transazione in caso di errore
            throw $e; // Rilancia l'eccezione per gestirla nel controller
        }
    }
    public function findAllPendingOrders()
    {
        return $this->findBy(['stato_ordine' => ['In elaborazione', 'Preso in carico', 'Spedito']], ['data_ordine' => 'DESC']);
    }

    public function updateOrderStatus($orderId, $newStatus)
    {
        $order = $this->find($orderId);
        if ($order) {
            $order->setStato_ordine($newStatus);
            getEntityManager()->flush();
        }
    }
}