<?php
//include "../BDD/Entite.php";
include "../Metier/attaquer.php";






// Dev By Mathis






if(isset($_POST['combat'])&&isset($_POST['idagresseur'])&&isset($_POST['idvictime']))
{
    if($_POST['combat']==1)
    {
        try
        {
            $bdd = new PDO('mysql:host=localhost; dbname=pfullstack; charset=utf8','root','');
            echo "reussi";
        }
        catch(Exception $e)
        {
            echo "erreur connexion à la base";
        }

        try
        {
            $idagresseur = $_POST['idagresseur'];
            $idvictime = $_POST['idvictime'];
            $dataagresseur = $bdd->query('SELECT id_entite FROM entite where id_entite="'.$idagresseur.'"'); //on verifie si les deux entités demandées existent en base
            $tabagresseur = $dataagresseur->fetch();
            $idagresseur = $tabagresseur['id_entite'];

            $datavictime = $bdd->query('SELECT id_entite FROM entite where id_entite="'.$idvictime.'"');
            $tabvictime = $datavictime->fetch();
            $idvictime = $tabvictime['id_entite'];

            $agresseur = new Entite($idagresseur,$bdd);
            $victime = new Entite($idvictime,$bdd);

            Attaquer($idagresseur,$idvictime,$bdd);


            $viepersoattaquant = $agresseur->getPdv(); //on récupère la vie de l'entité attaquant et de l'entité attaquée, ce sont les informations à retourner
            $viepersovictime = $victime->getPdv();
            $life = array('vie' => $viepersoattaquant, 'vie2' => $viepersovictime);

            echo json_encode($life);
            //$jsonretour = "{_Vie:vieperso1,_Vie:vieperso2}";
            //echo $jsonretour;

        }
        catch(Exception $e)
        {
            echo "erreur, la ou les entités n'existe/existent pas";
        }
    }
}





?>