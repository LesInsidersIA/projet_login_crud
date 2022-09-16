<?php
require_once "config.php";

if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $sql = "DELETE FROM Etudiants WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_id);

        $param_id = trim($_POST["id"]);
        if (mysqli_stmt_execute($stmt)) {
            header("location: bienvenue.php");
            exit();
        } else {
            echo "ERROR: Essaie encore.";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression</title>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <div class="main-container">
        <div>
            <h2>Suppréssion d'un étudiant. <h2>
        </div>
        <div class="form-body">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <p>Voulez-vous vraiment supprimer l'étudiant ?</p>
                <div>
                    <input type="hidden" name="id" value="<?php echo trim($_GET['id']); ?>">
                    <p>
                        <input class="confirm-btn" type="submit" value="Yes">
                        <a href="bienvenue.php"> Non </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

</body>

</html>