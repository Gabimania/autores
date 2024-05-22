<?php
session_start();
$idautor = $_SESSION["idautor"];
include("conection.php");
$sql = "SELECT l.idlibro as idlibro, l.name as name, l.imagen as imagen, a.idautor as idautor, a.name as autor FROM autor as a INNER JOIN libro as l ON a.idautor = l.idautor";
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
  
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 0 15px;
        }
        .book {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .book img {
            width: 100%;
            border-radius: 5px;
        }
        .book h2 {
            margin-top: 0;
        }
        .book p {
            margin-bottom: 0;
        }
        .book-links {
            margin-top: 10px;
        }
        .book-links a {
            display: inline-block;
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .book-links a:hover {
            color: #0056b3;
        }

        
    </style>
</head>

<body>
    <div class="container">
        <a href="addbook.php" class="btn btn-primary">Añadir un libro</a>
        <a href="autoredit.php" class="btn btn-secondary">Modificar mis datos</a>
        <h1 class="mt-3">El rincón del libro</h1>
        <?php foreach ($libros as $libro): ?>
            <div class="book">
                <h2><?php echo htmlspecialchars($libro['name']); ?></h2>
                <img src="assets/img/<?php echo htmlspecialchars($libro['imagen']); ?>" alt="<?php echo htmlspecialchars($libro['name']); ?>">
                <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
                <?php if ($libro['idautor'] == $idautor) { ?>
                    <div class="book-links">
                        <!-- Botones de editar y eliminar que redirigen a otra vista -->
                        <a href="editar_libro.php?idlibro=<?php echo $libro['idlibro']; ?>" class="btn btn-primary text-white">Editar</a>
                        <a href="eliminar_libro.php?idlibro=<?php echo $libro['idlibro']; ?>" class="btn btn-danger text-white">Eliminar</a>
                    </div>
                <?php } ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>
