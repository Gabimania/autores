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
</head>
<body>
    <a href="register.php">Registrase</a>
    <a href="login.php">Loguearse</a>
    <h1>El rincón del libro</h1>
    <?php foreach ($libros as $libro): ?>
                <div class="book">
                    <h2><?php echo htmlspecialchars($libro['name']); ?></h2>
                    <img src="assets/img/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="<?php echo htmlspecialchars($book['bookname']); ?>">
                    <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
                </div>
            <?php endforeach; ?>
</body>
</html>