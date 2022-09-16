<?php
require_once "config.php";
$id = $nom = $prenom = $email = '';

if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['id'])  && !empty($_POST["id"])) {
    $nom = htmlspecialchars(stripslashes(trim($_POST['nom'])));
    $prenom = htmlspecialchars(stripslashes(trim($_POST['prenom'])));
    $email = htmlspecialchars(stripslashes(trim($_POST['email'])));
    $id = $_POST['id'];

    $nom = mysqli_real_escape_string($link, $nom);
    $prenom = mysqli_real_escape_string($link, $prenom);
    $email = mysqli_real_escape_string($link, $email);
    $sql = "UPDATE Etudiants SET nom=?, prenom=?, email=? WHERE id=?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssi", $param_nom, $param_prenom, $param_email, $param_id);

        $param_nom = $nom;
        $param_prenom = $prenom;
        $param_email = $email;
        $param_id = $id;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Records updated successfully. Redirect to landing page
            header("location: bienvenue.php");
            exit();
        } else {
            echo "ERROR: Essaie encore.";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else {
    //echo "C'est ici que je vais selection les infos de la ligne via l'id pour afficher dans les champs de saisie.";
    if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
        $query = "SELECT * FROM Etudiants WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = trim($_GET["id"]);
            if (mysqli_stmt_execute($stmt)) {
                $resultats = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($resultats) == 1) {
                    $ligne = mysqli_fetch_array($resultats, MYSQLI_ASSOC);
                    $id = $ligne["id"];
                    $nom = $ligne["nom"];
                    $prenom = $ligne["prenom"];
                    $email = $ligne["email"];
                }
            } else {
                header("location:error.php");
                exit();
            }
        } else {
            header("location:error.php");
            exit();
        }
    } else {
        header("location:error.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier</title>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

</body>
<div class="main-container">
    <p>
    <h2>Modification des informations d'un étudiant.</h2>
    </p>
    <div class="form-body">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div>
                <label>Nom</label> <input type="text" name="nom" value="<?php echo $nom ?>">
            </div>
            <div>
                <label>Prénom</label> <input type="text" name="prenom" value="<?php echo $prenom ?>">
            </div>
            <div>
                <label>Email</label> <input type="text" name="email" value="<?php echo $email ?>">
            </div>
            <div>
                <input type="hidden" name="id" value="<?php echo $id ?>">
            </div>
            <div class="btns">
                <input type="submit" value="Valider">
                <a style="margin-left:20px" href="bienvenue.php">Annuler</a>
            </div>
        </form>
    </div>
</div>

</html>