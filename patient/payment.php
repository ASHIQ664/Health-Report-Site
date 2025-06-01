<?php
session_start();
require '../config/db.php';

if(!isset($_SESSION['user_id']) || !isset($_SESSION['checkup_data'])) {
    header("location: ../login.php");
    exit();
}

$data = $_SESSION['checkup_data'];
$user_id = $_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD'] ==="POST"){
    $stmt = $pdo->prepare("INSERT INTO checkups
    (user_id, full_name, phone, temperature, blood_pressure,
    sugar_level, pain_level, medicines, feeling) VALUES (?,?,?,?,?,?,?,?,?)");

    $stmt->execute([
        $user_id,
        $data['full_name'],
        $data['phone'],
        $data['temperature'],
        $data['blood_pressure'],
        $data['sugar_level'],
        $data['pain_level'],
        $data['medicines'],
        $data['feeling']
    ]);
    $checkup_id = $pdo->lastInsertId();
    $paymentStmt = $pdo->prepare("Insert INTO payments(user_id, checkup_id, amount, status) VALUES(?,?,?,'paid')");
    $paymentStmt->execute([$user_id, $checkup_id, 5.00]);

    unset($_SESSION['checkup_data']);
    header("location: thank_you.php");
    exit();
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Inter', sans-serif;
            background-color: #f2f9ff;
            margin: 0;
            padding: 0;
        }
        .container{
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            position: relative;
        }
        h2{
            text-align: center;
            color: #004466;
            margin-bottom: 20px;
        }
        .progress-bar-fill {
            width: 100%;
            background-color: #007acc;
            height: 100%;
        }
        .step-label{
            text-align: center;
            font-size: 14px;
            color: #007acc;
            font-weight: 600;
            margin-bottom: 30px;
        }
        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
        }
        input[type="text"], input[type="number"]{
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }
        button {
            width: 100%;
            padding: 14px;
            background-color: #2563eb;
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(37,99,235,0.25);
            transition: background-color 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 20px;
        }
        button:hover {
             transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(37,99,235,0.35);
        }
        .back-link {
            position: absolute;
            top: 15px;
            left: 20px;
            font-size: 14px;
            text-decoration: none;
            color: #007acc;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <a href="checkup_form.php" class = "back-link">&larr; Back</a>
    <h2>Payment Page </h2>
    <div class = "progress-bar">
        <div class = "progress-bar-fill"></div>
</div>
<div class="step-label">Step 2 of 2: Confirm Payment</div>
    <p>This is the payment page</p>
    <form method="POST">
        <label>Name on Card:</label><br>
        <input type="text" name="card_name" placeholder="Your Name" required><br><br>

        <label> Card Number: </label>
        <input type="text" name="card_number" placeholder=  "1234 5678 9012 3456" maxlength="19" required>
        <div style="display: flex; gap:10px;">
            <div style = "flex: 1;">
                <label>Expiry Date:</label>
                <input type="text" name="expiry" placeholder="MM/YY" maxlength="5" required>
    </div>
    <div style="flex: 1;">
        <label>CVV:</label>
        <input type="text" name="cvv" placeholder="123" maxlength="4" required>
    </div>
    </div>

        <label>Amount</label><br>
        <input type="text" value="5.000 OMR" readonly><br><br>

        <button type="submit">Pay now</button>
</form>
</body>
</html>