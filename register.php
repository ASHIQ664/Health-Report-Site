<?php
require 'config/db.php';

$name = $email = $password = $confirm_password = "";
$errors = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name =  trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];


if(empty($name) || empty($email) || empty($password) || empty($confirm_password)){
    $errors[] = "All fields are required.";
}
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors[] = "Invlaid Email Format.";
}
if($password !== $confirm_password){
    $errors[] = "Password do not match.";
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE email=?");
$stmt->execute([$email]);
if($stmt->rowCount()>0){
    $errors[] = "Email is already registered.";
}

if(empty($errors)){
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users(name,email,password,role) VALUES(?,?,?,'patient')");
    if($stmt->execute([$name,$email,$hashedPassword])){
        header("Location:login.php");
        exit();
    }
    else{
        $errors[] = "Registration is Failed. Please Try again";
    }
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Register - Badar Al Samma Self Checkup </title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<style>
    *{
        box-sizing: border-box;
    }
    body{
        font-family: 'Inter', 'Segoe UI', sans-serif;
        background-color: #f0f8ff;
        margin: 0;
        color: #333;
    }
    header{
        background-color: #1e3a8a;
        color:white;
        text-align: center;
        padding: 20px;
    }
    .register-container {
        max-width: 400px;
        margin: 80px auto;
        background: #fff;
        padding: 40px 30px;
        border-radius: 10px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        animation: fadeIn 0.8s ease-in-out;
    }
    .register-container h2{
        text-align: center;
        color: #004466;
        margin-bottom: 20px
    }
    .register-container label{
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }
    .register-container input[type="text"], .register-container input[type="email"], .register-container input[type="password"]{
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
    }
    .register-container button {
        width: 100%;
        padding: 12px;
        background-color: #2563eb;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(37,99,235,0.25)
        transition: background-color 0.2s ease, box-shadow 0.2s ease;
    }
    .register-container button:hover{
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(37,99,235,0.35);
    }
    @keyframes fadeIn {
        from{ opacity: 0; transform: translateY(20px);}
        to{ opacity: 1; transform: translateY(0);}}
    
    .register-container p a{
        color: #1d4ed8;
        font-weight: 600;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 6px;
        border: 1px solid #1d4ed8;
        display: inline-block;
        margin-top: 12px;
        transition: all 0.3s ease;
    }
    .register-container p a:hover {
        background-color: #1d4ed8;
        color: white;
    }
    
</style>
</head>
<body>
    <header>
    <h1> Patient Registration</h1>
</header>
    <div class="register-container">
    <?php if(!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label> Password:</label><br>
        <input type="password" name="password" required><br><br>
        <label>Confirm Password:</label><br>
        <input type="password" name="confirm_password" required><br><br>

        <button type="submit">Register</button>
    </form>

    <p> Already have an account? <a href="login.php">Login here</a>.</p>
            </div>
    </body>
    </html>
