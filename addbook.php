<?php
session_start();
$idautor = $_SESSION["idautor"];

if (isset($_SESSION["idautor"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include("conection.php");

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $bookname = $_POST["name"];
        $imagen = $_FILES["imagen"]["name"];
        $target_dir = "assets/img/";
        $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verificar si el archivo es una imagen
        $check = getimagesize($_FILES["imagen"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Verificar si el archivo ya existe
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Verificar el tamaño de la imagen
        if ($_FILES["imagen"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Guardar la imagen y actualizar la base de datos
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                try {
                    $sql = "INSERT INTO libro (name, imagen, idautor) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(1, $bookname);
                    $stmt->bindParam(2, $imagen);
                    $stmt->bindParam(3, $idautor);

                    if ($stmt->execute()) {
                        header("Location:autor.php");
                    } else {
                        echo "Error al añadir el libro";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
} else {
    echo "No hay un autor identificado en la sesión.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Libro</title>
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
        <h1 class="mb-3">Subir un nuevo libro</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nombre del libro</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen del Libro</label>
                <input type="file" class="form-control-file" name="imagen" id="imagen" required>
            </div>
            <input type="hidden" name="idautor" value="<?php echo $_SESSION['idautor']; ?>">
            <button type="submit" class="btn btn-primary">Añadir</button>
        </form>
    </div>
</body>
</html>
