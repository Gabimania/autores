
<?php
session_start();
$idautor = $_SESSION["idautor"];
include("conection.php");
$sql = " select l.idlibro as idlibro,l.name as name,l.imagen as imagen,a.idautor as idautor, a.name as autor from autor as a inner join libro as l on a.idautor = l.idautor";
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
    <a href="addbook.php">Añadir un libro</a>
    <a href="autoredit.php">Modificar mis datos</a>
    <h1>El rincón del libro</h1>
    <?php foreach ($libros as $libro): ?>
                <div class="book">
                    <h2><?php echo htmlspecialchars($libro['name']); ?></h2>
                    <img src="assets/img/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="<?php echo htmlspecialchars($libro['name']); ?>">
                    <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
                    <?php 
        
            if ($libro['idautor'] == $idautor) { ?>
                <!-- Botones de editar y eliminar que redirigen a otra vista -->
                <a href="editar_libro.php?idlibro=<?php echo $libro['idlibro']; ?>">Editar</a>
                <a href="eliminar_libro.php?idlibro=<?php echo $libro['idlibro']; ?>">Eliminar</a>
            <?php } ?>
                </div>

            <?php endforeach; ?>
</body>
</html>