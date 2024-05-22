<?php 
session_start();
if(isset($_SESSION["idautor"])){
    include("conection.php");
    
    $idautor = $_SESSION["idautor"];
    
    // Datos actuales del autor
    $sql = "SELECT name, email, password FROM autores.autor WHERE idautor = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $idautor);
    $stmt->execute();
    $datos = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Actualizamos valores o mantenemos los mismos
    $name = isset($_POST["name"]) ? $_POST["name"] : $datos["name"];
    $email = isset($_POST["email"]) ? $_POST["email"] : $datos["email"];
    $pass = isset($_POST["password"]) ? $_POST["password"] : $datos["password"];

    // Si se envían los datos del formulario se mantienen los mismos
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql2 = "UPDATE autores.autor SET name = ?, email = ?, password = ? WHERE idautor = ?";
        $stmt = $conn->prepare($sql2);
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $pass);
        $stmt->bindParam(4, $idautor);
        $stmt->execute();}}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar datos personales</title>
</head>
<body>
    <a href="autor.php">Volver</a>
    <h1>Modificar datos personales</h1>
    <form method="post">
    <input type="text" name="name" id="name" placeholder="Name" value="<?php echo $datos["name"] ?>">
    <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $datos["email"] ?>">
    <input type="password" name="password" id="password" placeholder="Password" value="<?php echo $datos["password"] ?>">
    <button type="submit">Modificar datos</button> 
</form>

</body>
</html>