<?php
include("conection.php");
session_start();
if (isset($_POST["email"])) {
    $sql = "select * from autor where email = ? and password = ?";
    $email = $_POST["email"];
    $password = $_POST["password"];
    $stm = $conn->prepare($sql);
    $stm->bindParam(1, $email);
    $stm->bindParam(2, $password);
    $stm->execute();
    if ($stm->rowCount() > 0) {
        $result = $stm->fetch(PDO::FETCH_ASSOC);
        $idautor = $result["idautor"];
        $_SESSION["idautor"] = $idautor;
        $_SESSION["name"] = $name;
        header("Location: autor.php");
    }else{
        $error = "Invalid Credentials";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form method="post">
        <input type="email" name="email" id="email" placeholder="Email">
        <input type="password" name="password" id="password" placeholder="Password">
        <input type="submit" value="Sing in">
    </form>
</body>

</html>