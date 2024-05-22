<?php
include("conection.php");
$sql = "SELECT l.name, l.imagen, a.name as autor FROM autores.libro as l
inner join autores.autor as a 
on l.idautor = a.idautor";
$stmt = $conn->prepare($sql);
$stmt->execute();
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El rincón del Libro</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos adicionales */
        .book {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mt-4">
            <a href="register.php" class="btn btn-primary mr-2">Registrarse</a>
            <a href="login.php" class="btn btn-primary">Loguearse</a>
        </div>
        <h1 class="mt-4 mb-4 text-center">El rincón del libro</h1>
        <div class="row">
            <?php foreach ($libros as $libro): ?>
                <div class="col-md-4">
                    <div class="book">
                        <h2><?php echo htmlspecialchars($libro['name']); ?></h2>
                        <img src="assets/img/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="<?php echo htmlspecialchars($book['bookname']); ?>" class="img-fluid mb-3">
                        <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
