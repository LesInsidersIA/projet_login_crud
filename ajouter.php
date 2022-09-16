<?php
require_once "config.php";

if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email'])) {
    $nom = htmlspecialchars(stripslashes(trim($_POST['nom'])));
    $prenom = htmlspecialchars(stripslashes(trim($_POST['prenom'])));
    $email = htmlspecialchars(stripslashes(trim($_POST['email'])));

    if (
        preg_match("/^[a-zA-Z-' +àèéëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ+ ]*$/", $nom)
        && preg_match("/^[a-zA-Z-' +àèéëïöüÿÄËÏÖÜŸçÇßØøÅåÆæœ+ ]*$/", $prenom)
        && filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {

        $nom = mysqli_real_escape_string($link, $nom);
        $prenom = mysqli_real_escape_string($link, $prenom);
        $email = mysqli_real_escape_string($link, $email);

        $sql = "INSERT INTO Etudiants (nom, prenom, email) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Lie les variables aux espaces réservées (?) dans le modèle d’instruction SQL.
            mysqli_stmt_bind_param($stmt, "sss", $nomInsert, $prenomInsert, $emailInsert);

            $nomInsert = $nom;
            $prenomInsert = $prenom;
            $emailInsert = $email;
            if (mysqli_stmt_execute($stmt)) {
                header("location: bienvenue.php");
                exit();
            }
        } else {
            echo "ERREUR: Impossible d’exécuter la requête: $sql. " . mysqli_error($link);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter étudiant</title>
    <link href="css/style.css" rel="stylesheet">


</head>

<body>
    <div class="main-container">
        <div>
            <p>
            <h2>Enregistrement d'un étudiant.</h2>
            </p>
            <p>Veuillez remplir ce formulaire pour enregistrer un nouveau étudiant.</p>
        </div>
        <div class="form-body">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <div>
                    <label>Nom</label> <input type="text" name="nom" value="">
                </div>
                <div>
                    <label>Prénom</label> <input type="text" name="prenom" value="">
                </div>
                <div>
                    <label>Email</label> <input type="text" name="email" value="">
                </div>
                <div class="btns">
                    <input type="submit" value="Enregistrer">
                    <a style="margin-left:20px" href="bienvenue.php">Annuler</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>