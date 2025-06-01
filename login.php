<?php
session_start();
require 'config/db.php';
$email = $password="";
$errors = [];

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if(empty($email) || empty($password)) {
        $errors[] = "Both email and password are requires.";
    }
    else{
        $stmt = $pdo->prepare("Select * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if($user && password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];

            //redirect by role
            if ($user['role'] == 'doctor'){
                header("Location: doctor/dashboard.php");
            }
            else{
                header("Location: patient/dashboard.php");
            }
            exit();
        } else{
            $errors[] = "Invalid email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Badar Al Samma Self Checkup </title>
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
            color: white;
            padding: 20px;
            text-align: center;
        }
        .login-container{
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-in-out;
        }
        .login-container h2{
            text-align: center;
            color: #004466;
            margin-bottom: 20px;
        }
        .login-container label{
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }
        .login-container input[type="email"],
        .login-container input[type="password"]{
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }
        .login-container button{
            width: 100%;
            padding: 12px;
            background-color: #2563eb;
            color:white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37,99,235,0.25);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .login-container button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(37,99,235,0.35)
        }
        @keyframes fadeIn{
            from{ opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }
        .login-container p a{
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
        .login-container p a:hover {
            background-color:#1d4ed8;
            color: white;
        }
    </style>
</head>
<body>
    <header>
    <h2>Self Checkup Login</h2>
    </header>
    <div class = "login-container">
        <h2>Login</h2>

    <?php if(!empty($errors)):?>
        <ul style="color: red;">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach;?>
            </ul>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>

    <p> No account? <a href="register.php"> Register here </a>.</p>
        </div>
    </body>
    </html>

    