<?php
class CFrontController{

    public function run(){
        session_start();
        $URL = parse_url($_SERVER['REQUEST_URI'])['path'];
        $URL = explode('/', $URL);

        array_shift($URL);
        
        $file = "./src/Controller/C".ucfirst($URL[1]).".php";

        $controllerClass = "C".ucfirst($URL[1]);
        $methodName = !empty($URL[2]) ? $URL[2] : ' ';
        
        if(file_exists($file)){
            require_once $file;
            // Check if the method exists in the controller
            if (method_exists($controllerClass, $methodName)) {

                // Controlla se il metodo è ad accesso pubblico
                if (!$this->isPublic($URL[1], $methodName)) {
                    // Start the session if not already started
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    if(!isset($_SESSION['utente'])){
                        //L'utente non è loggato
                        header('Location: /Dolce_Abruzzo/utente/login');
                        exit;
                    }else if($_SESSION['services'][$URL[1]][$methodName]['hasAccess'] != true){
                        //L'utente non ha i permessi
                        header('Location: /Dolce_Abruzzo/utente/login');
                        exit;
                    }
                }
                 // Call the method
                 $params = array_slice($URL, 3); // Get optional parameters
                
                 // Riformatto i parametri url nel caso abbiano spazi non codificati
                 $decodedParams = array_map('urldecode', $params);
                 
                 call_user_func_array([$controllerClass, $methodName], $decodedParams);
            
            }else {
                // Method not found, handle appropriately (e.g., show 404 page)
                header('Location: /Dolce_Abruzzo/utente/home');
            }

        } else{
            header('Location: /Dolce_Abruzzo/utente/home');
        }
    }
    private function isPublic($controller, $method) {
        // Define your public routes here
        $publicRoutes = [
            'utente' => ['home', 'login', 'logout', 'signUp','termsAndConditions','about','contatti','elencoRicette', 'vediRicetta'],
            'gestioneAcquisti' => ['shop', 'infoProdotto', 'cart', 'aggiungiAlCarrello', 'rimuoviDaCarrello', 'aggiornaQuantitaCarrello', 'svuotaCarrello', 'ricerca'],
            // Add more public controllers and methods as needed
        ];
        if(isset($_SESSION['accessDenied']) && $_SESSION['accessDenied']){
            $publicRoutes = [
                'utente' => ['home', 'login', 'logout'],
            ];
        }
        if(isset($_SESSION['utente']) && ($_SESSION['utente'] instanceof EChef || $_SESSION['utente']->getRoles()->current()->getName() == 'admin')){
            $publicRoutes = [
                'utente' => ['home', 'login', 'logout', 'signUp','termsAndConditions','about','contatti','elencoRicette', 'vediRicetta'],
            ];
        }

        return isset($publicRoutes[$controller]) && in_array($method, $publicRoutes[$controller]);
    }
}

?>