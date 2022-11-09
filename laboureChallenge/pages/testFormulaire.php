<?php
require_once('../pages/layout/header.php');
require_once('../pages/layout/head.php');
require_once("../pages/connexiondb.php");
?>
<h1>les inscription des honoraire </h1>

<?php
//Selection de tous les chargé client
$requetC = "SELECT * FROM chargeclient";
$resultRequetC = $pdo->query($requetC);
//Selection de tous les honoraire
$requetH = "SELECT * FROM honoraire";
$resultRequetH = $pdo->query($requetH);

if ($resultRequetC && $resultRequetH) { //c'est les deux existe je fait 
    //formulaire html avec  list déroulante
}
?>
<div class="container">

    <div class="panel panel-primary barRecherche">
        <div class="panel-heading">Les effectifs du chargé clientèle :</div>
        <div class="panel-body">
            <form method="post" action="testFormulaire.php" class="form" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <select name="nom" class="form-control" id="selectChargeCn">
                </div>
                <?php
                while ($tabC = $resultRequetC->fetch()) {
                    echo '<option value="' . $tabC['idChargeClient'] . '">' . $tabC['nom'] . '</option>';
                } ?>
                </select>
                <div class="form-group">
                    <label for="nom">Prenom :</label>
                    <select name="prenom" class="form-control" id="selectChargeCp">
                </div>
                <?php
                while ($tabC = $resultRequetC->fetch()) {
                    echo '<option value="'. $tabC['idChargeClient'].'">'.$tabC['prenom'].'</option>';
                } ?>
                </select>

                <div class="form-group">
                    <label for="date">Date :</label>
                    <input type="date" name="date" placeholder="date" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="montant">Honoraire :</label>
                    <input type="number" name="montant" placeholder="" class="form-control" />
                </div>
                <input type="submit" name="submit" id="" value=" Enregistrer" class="btn btn-success"></span> </input><br>
        </div>
    </div>
</div>
</form>
<?php
//******vérifier que le bouton ajouter a bien été cliqué
if (isset($_POST['submit'])) {
    $nom = $_POST['nom'];
   $prenom = $_POST['prenom'];
    $date = $_POST['date'];
    $montant = $_POST['montant'];
    //    $moisHonoraire= $_POST['moisHonoraire'];
    //******verifier que tous les champs ont été remplis
    if (!empty($nom)  && !empty($prenom)  && !empty($date) && !empty($montant)) //&& !empty($moisHonoraire)
    {
        //*****requête d'ajout
        $requetC = "INSERT INTO honoraire(montant,date,idChargeClient) 

    SELECT montant,date,chargeclient.idChargeClient 
    
    FROM chargeclient AS C  
    
    INNER JOIN  honoraire AS H  
    
    ON C.idChargeClient = H.idChargeClient
     VALUES(:nom,:prenom,:date,:montat)";
        $requete = $pdo->prepare($requetC);

        $requete->bindValue(':nom', $nom);
       $requete->bindValue(':prenom', $prenom);
        $requete->bindValue(':date', $date);
        $requete->bindValue(':montant', $montant);
        // $requete->bindValue(':moisHonoraire',$moisHonoraire);
        $result = $requete->execute();
        if (!$result) {
            echo "probleme est survenu";
            header("location:admin.php");
        } else {
            echo "
           <script type=\"text/javascript\"> alert('bien enregistrer . identifiant:" . $pdo->lastInsertId() . "')</script>";
        }
    } else {
        echo "<script type=\"text/javascript\"> alert(' Veuillez remplir tous les champs !')</script>";
    }
}
?>