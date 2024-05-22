<?php
session_start();
$idautor = $_SESSION["idautor"];
include("conection.php");

if(isset($_GET['idlibro'])) {
    $idlibro = $_GET['idlibro'];

    // Obtener los detalles del libro a eliminar
    $sql = "SELECT l.idlibro as idlibro, l.name as name, l.imagen as imagen, a.name as autor 
            FROM libro as l
            INNER JOIN autor as a ON l.idautor = a.idautor
            WHERE l.idlibro = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $idlibro);
    $stmt->execute();
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
        if(isset($_POST['eliminar_libro'])) {
            $sql2 = "DELETE FROM libro WHERE idlibro = ?";
            $stm = $conn->prepare($sql2);
            $stm->bindParam(1, $idlibro);
            $stm->execute();
            header("Location: autor.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Libro</title>
</head>
<body>
    <h1>Eliminar Libro</h1>
    <img src="assets/img/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="<?php echo htmlspecialchars($libro['name']); ?>">
    <p><strong>Nombre del libro:</strong> <?php echo htmlspecialchars($libro['name']); ?></p>
    <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
    <form method="post">
        <input type="hidden" name="idlibro" value="<?php echo $libro['idlibro']; ?>">
        <button type="submit" name="eliminar_libro">Eliminar Libro</button>
    </form>
</body>
</html>
