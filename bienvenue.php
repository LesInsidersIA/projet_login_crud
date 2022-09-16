<?php
// On initialise une session
session_start();

// On vérifie si l'utilisateur est connecté, si non, on le redirige vers la page login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bienvenue</title>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="main-container">
        <div>
            <h1 class="my-5">Bonjour, <b><?php echo ucfirst(htmlspecialchars($_SESSION["utilisateur"])); ?></b>. </h1>
            <h1>Bienvenue dans le système de gestion des étudiants du DWWM Vervins M2I</h1>
        </div>

        <div>
            <div>
                <h2>Liste des étudiants</h2>
                <p>
                    AJOUTER ETUDIANT <a href="ajouter.php"><img src="assets/add_etudiant.png" alt="Ajouter étudiant"></a>
                </p>
            </div>

            <div class="list-etudiants">
                <?php
                require_once "config.php";
                $requete = "SELECT * FROM Etudiants";
                if ($resultats = mysqli_query($link, $requete)) {
                    if (mysqli_num_rows($resultats) > 0) {
                        echo "<table class='table-container'>";

                        echo "<thead>";
                        echo "<tr>";
                        echo "<th style='width: 50px';> ID </th>";
                        echo "<th style='width: 120px'> NOM </th>";
                        echo "<th style='width: 120px'> PRENOM </th>";
                        echo "<th style='width: 150px'> EMAIL </th>";
                        echo "<th style='width: 200px'> ACTION</th>";
                        echo "<tr>";
                        echo "</thead>";

                        while ($ligne = mysqli_fetch_array($resultats)) {
                            echo "<tr>";
                            echo "<td style='width: 50px'>" . $ligne['id'] . "</td>";
                            echo "<td style='width: 120px'>" . $ligne['nom'] . "</td>";
                            echo "<td style='width: 120px'>" . $ligne['prenom'] . "</td>";
                            echo "<td style='width: 150px'>" . $ligne['email'] . "</td>";
                            echo "<td style='width: 200px'>";
                            echo '<a style="margin-right: 10px" href="lire.php?id=' . $ligne['id'] . '" title="lire"> <img alt="voir" src="assets/read.png" width=25" height="25"> </a>';
                            echo '<a style="margin-right: 10px" href="modifier.php?id=' . $ligne['id'] . '" title="modifier"><img alt="modifier" src="assets/update.png" width=25" height="25"> </a>';
                            echo '<a style="margin-right: 10px" href="supprimer.php?id=' . $ligne['id'] . '" title="supprimer"><img alt="supprimer" src="assets/delete.png" width=25" height="25"> </a>';
                            echo "</td>";
                            echo "<tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "Aucun donnée n'a été trouvé. <br/>";
                    }
                    mysqli_free_result($resultats);
                } else {
                    echo "ERROR : La connexion n'a pas été établie. <br/>";
                }
                ?>
            </div>
        </div>
        <div>
            <p>
                <a href="reset_mdp.php" class="reset-link">REINITIALISER LE MOT DE PASSE</a>
                <a href="logout.php" class="logout-link">SE DECONNECTER</a>
            </p>
        </div>

    </div>
</body>

</html>