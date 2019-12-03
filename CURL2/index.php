<?php
    // Définition de l'URL d'appel
    define ('URL', "https://n161.tech/api/dummyapi/post");

    /**
     * Déclaration d'une fonction qui va :
     *  faire la requête et renvoyer le résultat sous forme de tableau
     *
     * @param string $url
     * @return array
     */
    function makeRequest ( string $url ) : array
    {
        // Vérifier au préalable sur Curl est activé!
        //phpinfo();

        // Doc de CURL
        // https://www.php.net/manual/fr/book.curl.php

        // Initialisation de cURL
        $ch = curl_init();

        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Au cas où on a un souci avec le SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);

        // Execute
        $result = curl_exec($ch);

        // En cas d'erreur
        if ( $result === false )
        {
            // Affichage de l'erreur
            var_dump ( curl_error($ch) );
        }

        // Closing
        curl_close($ch);

        // Decodage du JSON reçu
        $data = json_decode($result, true);

        // Attention à vérifier ce que vous renvoie l'API!
        //var_dump( $data );
        //die; // Die va tuer le processus et s'arrêter exactement à cette ligne là

        // Renvoi du tableau JSON
        return (array) $data['data'];
    }

    /**
     * Analyse des données fournies
     * Le résultat sera une string contenant du code HTML à afficher
     *
     * @param array $datas
     * @return string
     */
    function parseDatas ( array $datas ) : string
    {
        // Initialiser la variable 
        $output = "";

        // Parcours du résultat avec foreach
        foreach( $datas as $resultat )
        {
            /*
                <div class="cell">
                    <div class="card">
                        <img src="assets/img/generic/rectangle-1.jpg">
                        <div class="card-section">
                        <h4>This is a row of cards.</h4>
                        <p>This row of cards is embedded in an X-Y Block Grid.</p>
                        </div>
                    </div>
                </div>
            */

            // Utilisation de la fonction https://devdocs.io/php/function.vsprintf

            // On définit le format de sortie
            $format = '<div class="cell">
                            <div class="card">
                                <img src="%s">
                                <div class="card-section">
                                    <h4>%s</h4>
                                    <p>%s</p>
                                </div>
                            </div>
                        </div>';
                        
            $row = vsprintf(
                $format,
                array(
                    $resultat['image'],
                    $resultat['owner']['nameTitle'] . " " . $resultat['owner']['firstName'] . " " . $resultat['owner']['lastName'],
                    $resultat['message']
                )
            );

            // Ici on ajoute du contenu à $output
            $output .= $row;
        }

        return (string) $output;
    }

    // Appel de la fonction makeRequest. On récupère un tableau
    $posts = makeRequest( URL );

    // On récupère du code HTML
    $output = parseDatas ( $posts );
?>
<!-- Partie visuelle -->
<!-- Ici on utilisera le framework Fundation https://foundation.zurb.com/ -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHP with Curl version 2</title>
        <link rel="stylesheet" href="assets/css/foundation.css">
        <link rel="stylesheet" href="assets/css/app.css">
    </head>
    <body>
        <div class="grid-container">
            <h1>Utilisation de l'API <a href="https://n161.tech/t/dummyapi/explorer/#post">Dummy API</a></h1>
            <div class="grid-x grid-margin-x small-up-2 medium-up-3">       

                    <?php echo $output; ?>
                    
                </div>
            </div>
        </div>
        

        <!-- Scripts de Foundation -->
        <script src="assets/js/vendor/jquery.js"></script>
        <script src="assets/js/vendor/what-input.js"></script>
        <script src="assetsjs/vendor/foundation.js"></script>
        <script src="assets/js/app.js"></script>
    </body>
</html>


