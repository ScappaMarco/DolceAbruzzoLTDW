<?php
use Doctrine\ORM\EntityRepository;

class FSconto extends EntityRepository {
    public function insertSconto(ESconto $sconto, $stringa_sconto) {
        $em = getEntityManager();
        $found_cliente = $em->find(ECliente::class, $_SESSION['utente']->getIdCliente());
        $sconto->setBeneficiario($found_cliente);
        $sconto->setCodiceSconto($stringa_sconto);
        $em->persist($sconto);
        $em->flush();
    }
    public function getAllCodiciScontoCliente() {
        $em = getEntityManager();
        $found_cliente = $em->find(ECliente::class, $_SESSION['utente']->getIdCliente());
        return $found_cliente->getSconti()->toArray();
    }
}