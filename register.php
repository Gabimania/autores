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
        }}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form method="post">
    <input type="text" name="name" id="name" placeholder="Name">
    <input type="email" name="email" id="email" placeholder="Email">
    <input type="password" name="password" id="password" placeholder="Password">
    <button type="submit">New</button> 
    </form>
    <?php
    if(isset($msg)){
        echo "<p>".$msg."</p>";
    }
    ?>
</body>
</html>