<?php

require_once '../include/connexionBDD.php';
// connexion avec la base de données

$derby_name_session;

try {

    //Préparation de la requête
    $res = $dbh->prepare("SELECT derby_name, mdp, id FROM player WHERE derby_name = '$_POST[derby_name]' AND mdp = '$_POST[mdp]'");
    $res->execute();
    $membre = $res->fetch(PDO::FETCH_ASSOC);

    //echo json_encode($membre);

    if (($_POST['derby_name'] == $membre['derby_name']) && ($_POST['mdp'] == $membre['mdp'])) {
        //Démarage de la session
        session_start();

        setcookie("id", $membre['id']); // genere un cookie contenant l'id du membre
        setcookie("derby_name", $membre['derby_name']); // genere un cookie contenant le login du membre
        //TO DO géstion de l'id de session
        //session_id($membre['id']);

        $derby_name_session = utf8_decode($membre['derby_name']);
        $id_session = $membre['id'];

        $_SESSION['id'] = $membre['id'];
        $_SESSION['derby_name'] = $derby_name_session;
        
//        $_SESSION['PHPSESSID'] = $id_session;


        echo $derby_name_session; // on 'retourne' la valeur 1 au javascript si la connexion est bonne
//        echo(json_encode($derby_name_session));
    } else {
        echo NULL; // on 'retourne' la valeur 0 au javascript si la connexion n'est pas bonne
    }

    $res = null;
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
