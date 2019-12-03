<?php
    // Requête via CURL

    // Déclaration de l'url
    $url = "https://randomuser.me/api/?results=5";
    
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
        //var_dump( $data['results'] );
        //die; // Die va tuer le processus et s'arrêter exactement à cette ligne là

        // Renvoi du tableau JSON
        return (array) $data['results'];
    }

    /**
     * Recopie de la fonction requête mais spécifique à OpenWeatherAPI
     *
     * @param string $url
     * @return string
     * 
     * @todo: Gestion au cas où la ville n'est pas trouvée
     * @todo: Générer l'url Meteo dans cette fonction en modifiant le paramètre avec le nom de la ville
     * @todo: Renvoi de l'icone
     */
    function makeRequestMeteo ( string $url ) : string
    {
        // Vérifier au préalable sur Curl est activé!
        //phpinfo();

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
        //var_dump( $data['results'] );
        //die; // Die va tuer le processus et s'arrêter exactement à cette ligne là

        // Renvoi de la donnée
        //return (string) $data['list'][0]['weather'][0]['main'];

        // Renvoi de l'url de l'icône
        // https://openweathermap.org/weather-conditions
        $url = "http://openweathermap.org/img/wn/";
        $url .= $data['list'][0]['weather'][0]['icon'];
        $url .= "@2x.png";

        // Création de l'icone
        $icone = "<img src=\"" . $url . "\" alt=\"" . $data['list'][0]['weather'][0]['description'] . "\" />";

        return $icone;
    }

    // Appel de la fonction avec l'URL
    $tableauResultats = makeRequest( $url );

    // Initialiser la variable 
    $output = "";

    // Parcours du résultat avec foreach
    foreach( $tableauResultats as $resultat )
    {
        //var_dump( $resultat );

        /*
            'gender' => string 'male' (length=4)
            'name' => 
                array (size=3)
                'title' => string 'Mr' (length=2)
                'first' => string 'Daniel' (length=6)
                'last' => string 'Poulsen' (length=7)
            'location' => 
                array (size=7)
                'street' => 
                    array (size=2)
                    'number' => int 7789
                    'name' => string 'Agervej' (length=7)
                'city' => string 'København V' (length=12)
                'state' => string 'Danmark' (length=7)
                'country' => string 'Denmark' (length=7)
                'postcode' => int 69085
                'coordinates' => 
                    array (size=2)
                    'latitude' => string '-31.3425' (length=8)
                    'longitude' => string '-158.6462' (length=9)
                'timezone' => 
                    array (size=2)
                    'offset' => string '-3:00' (length=5)
                    'description' => string 'Brazil, Buenos Aires, Georgetown' (length=32)
            'email' => string 'daniel.poulsen@example.com' (length=26)
            'login' => 
                array (size=7)
                'uuid' => string '3d5c070a-9ef3-4aab-af80-2dc9bf2d02e4' (length=36)
                'username' => string 'orangebird256' (length=13)
                'password' => string 'zxcvbn' (length=6)
                'salt' => string 'J60mQORi' (length=8)
                'md5' => string '5501f5dc398ed6de3a294a6e93fa9162' (length=32)
                'sha1' => string '3e02511d4d56264388f40bbe335fc67bafa3ce78' (length=40)
                'sha256' => string '864bb46a47ec90af8215c551a2de355e6b5d6b67435ad1bb7a01dff70b73e32d' (length=64)
            'dob' => 
                array (size=2)
                'date' => string '1989-11-26T00:11:35.503Z' (length=24)
                'age' => int 30
            'registered' => 
                array (size=2)
                'date' => string '2015-08-26T04:58:45.965Z' (length=24)
                'age' => int 4
            'phone' => string '79180193' (length=8)
            'cell' => string '74226504' (length=8)
            'id' => 
                array (size=2)
                'name' => string 'CPR' (length=3)
                'value' => string '261189-9386' (length=11)
            'picture' => 
                array (size=3)
                'large' => string 'https://randomuser.me/api/portraits/men/57.jpg' (length=46)
                'medium' => string 'https://randomuser.me/api/portraits/med/men/57.jpg' (length=50)
                'thumbnail' => string 'https://randomuser.me/api/portraits/thumb/men/57.jpg' (length=52)
            'nat' => string 'DK' (length=2)
        */

        // On crée une nouvelle ligne de tableau avec le contenu
        $row = "<tr>";
            // Genre
            switch ($resultat['gender']) 
            {
                case "male":
                    $row .= "<td><span class=\"icon\"><i class=\"fas fa-male\"></i></span></td>";
                    break;
                case "female":
                    $row .= "<td><span class=\"icon\"><i class=\"fas fa-female\"></i></span></td>";
                    break;
                default:
                    $row .= "<td><span class=\"icon\"><i class=\"fas fa-genderless\"></i></span></td>";
                    break;
            }

            // Nom et Prénom
            $row .= "<td>Nom: " . $resultat['name']['first'] .
             " Prénom: " . $resultat['name']['last'] . "</td>";

            // Date de naissance
            $dob_timestamp = strtotime( $resultat['dob']['date'] );
            $dob_formatted = strftime( "%d/%m/%Y", $dob_timestamp);

            $row .= "<td>Date de naissance: " . $dob_formatted . "</td>";


            // Location City
            $row .= "<td>Ville: " . $resultat['location']['city'] . "</td>";


            // 1. Création du lien vers l'API avec le nom de la ville
                // https://openweathermap.org/current
                $urlMeteo = "http://api.openweathermap.org/data/2.5/forecast?APPID=ca18014071190091d4be752b98e34330&q=";
                $urlMeteo .= urlencode( $resultat['location']['city'] );
            
            // 2. Appel de la fonction qui va aller chercher le temps
                $r = makeRequestMeteo( $urlMeteo );

            // 3. Affichage du résultatOpenWeatherAPI
            $row .= "<td>" . $r . "</td>";


            // Image
            $row .= "<td><img src=\"" . $resultat['picture']['medium'] . "\" /></td>";
        // On ferme la ligne
        $row .= "</tr>";

        // Ici on ajoute du contenu à $output
        $output .= $row;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PHP With CURL</title>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
        <link rel="stylesheet" href="bulma.min.css" />
    </head>
    <body>
        <h1>Résultats dans un tableau</h1>

        <table class="table is-hoverable is-fullwidth">
            <?php echo $output; ?>
        </table>
    </body>
</html>