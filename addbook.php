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
</head>
<body>
    <h1>Subir un nuevo libro</h1>
    <form method="post" action="" enctype="multipart/form-data">
        <label>Nombre del libro</label>
        <input type="text" name="name" id="name" required>
        <label>Imagen del Libro</label>
        <input type="file" name="imagen" id="imagen" required>
        <input type="hidden" name="idautor" value="<?php echo $_SESSION['idautor']; ?>">
        <input type="submit" name="submit" value="Añadir">
    </form>

    <?php if (isset($msg)) { echo $msg; } ?>
</body>
</html>
