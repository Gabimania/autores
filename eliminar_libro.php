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
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            padding: 0 15px;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Eliminar Libro</h1>
        <img src="assets/img/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="<?php echo htmlspecialchars($libro['name']); ?>" class="img-fluid mb-3">
        <p><strong>Nombre del libro:</strong> <?php echo htmlspecialchars($libro['name']); ?></p>
        <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
        <form method="post">
            <input type="hidden" name="idlibro" value="<?php echo $libro['idlibro']; ?>">
            <button type="submit" name="eliminar_libro" class="btn btn-danger">Eliminar Libro</button>
        </form>
    </div>
</body>
</html>
