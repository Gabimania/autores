<?php
if(isset($_POST["email"])){
    include("conection.php");
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $sql = "insert into autor(name, email, password) values(?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $pass);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        header("Location: login.php");
        exit();
    }
    else{
        $msg= "Error creating user";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos adicionales */
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            max-width: 400px;
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group input {
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            width: 100%;
        }
        .form-group button {
            border-radius: 5px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            width: 100%;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .error-msg {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form method="post">
            <div class="form-group">
                <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Register</button> 
            </div>
        </form>
        <?php
        if(isset($msg)){
            echo "<p class='error-msg'>".$msg."</p>";
        }
        ?>
    </div>
</body>
</html>
