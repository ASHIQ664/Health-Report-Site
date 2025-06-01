<?php
session_start();
require'../config/db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'doctor'){
    header("Location:../login.php");
    exit();
}
$search = $_GET['search']??'';
if(!empty($search)){
    
    $stmt = $pdo->prepare("Select c.id,c.full_name, c.created_at, u.email FROM checkups c JOIN users u ON
    c.user_id = u.id LEFT JOIN doctor_feedback f on f.checkup_id = c.id WHERE f.id IS NULL AND c.full_name LIKE ? ORDER BY
    c.created_at DESC");
    $stmt->execute(["%$search%"]);
}
else{
    $stmt = $pdo->query("SELECT c.id, c.full_name, c.created_at, u.email, f.id AS feedback_id FROM checkups c JOIN users u ON c.user_id = u.id
    LEFT JOIN doctor_feedback f ON f.checkup_id = c.id WHERE f.id IS NULL ORDER BY c.created_at DESC");
}
$checkups = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <title> Doctor Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Inter', sans-serif;
            background-color: #f2f4f7;
            margin: 0;
            padding: 40px;
        }
        h2 {
            color: #1a202c;
            margin-bottom: 25px;
            font-size: 32px;
            animation: fadeInup 0.5s ease-out;
        }
        form {
            margin-bottom: 20px;
            animation: fadeInUp 0.6s ease-out;
        }
        input[type="text"]{
            padding: 10px 14px;
            font-size: 15px;
            border: 1px solid #d1d5db;
            borer-radius: 6px;
            width: 260px;
            margin-right: 10px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus{
            outline: none;
            border-color: #2563eb;
        }
        button{
            padding: 10px 16px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            background-color: #2563eb;
            color: white;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s ;
        }
        button:hover {
            background-color: #1d4ed8;
            transform: scale(1.05);
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
            animation: fadeInUp 0.8s ease-out;
        }
        th {
            background-color: #1e40af;
            color: white;
            padding: 14px 18px;
            font-size: 13px;
            text-transform: uppercase;
            text-align: left;
            border-radius: 8px 8px 0 0;
        }
        tr {
            background-color: white;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, background-color 0.3s;
            border-radius: 12px;
            overflow: hidden;
        }
        tr:hover{
            background-color: #f9fafb;
            transform: scale(1.01);
        }
        td {
           padding: 16px 18px;
           font-size: 15px;
           color: #2d3748;
           border-bottom: 1px solid #e5e7eb;
        }
        tr td:first-child {
            border-left: 5px solid #3b82f6;
            border-radius: 8px 0 0 8px;  
        }
        tr td:last-child {
            border-radius: 0 8px 8px 0;
        }
        .status {
            display: inline-block;
            padding: 4px 10px;
            background-color: #f97316;
            color: white;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: bold;
        }
        .action-link {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
            position: relative;
            transition: color 0.3s;
        }
        .action-link::after {
            content:'';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 0%;
            height: 2px;
            background-color: #2563eb;
            transition: width 0.3s;
        }
        .action-link:hover {
            color: #1d4ed8;
            transform: translateX(2px);
        }
        .action-link:hover:after {
            width: 100%;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @media (max-width: 768px){
            table, thead, tbody, th, td, tr{
                display: block;
            }
            th{
                display: none;
            }
            td {
                border-radius: 8px;
                margin-bottom: 10px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            }
            td::before {
                content: attr(data-label);
                font-weight: bold;
                display: block;
                margin-bottom: 4px;
            }
        }
    </style>
</head>
<body>
    <h2>Doctor Dashboard</h2>
<form method="GET">
    <input type="text" name="search" placeholder="Search by patient name" value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Search</button>
    <a href="dashboard.php"><button type="button">Reset</button></a>
</form>
<br>
    <table cellpadding="10">
        <tr>
            <th>Patient Name</th>
            <th>Email</th>
            <th>Date</th>
            <th>Action</th>
            <th>Status</th>
</tr>
<?php foreach($checkups as $row):?>
    <tr style="animation-delay: <?= 0.1 * $i ?>s;">
        <td data-label="Patient Name"><?= htmlspecialchars($row['full_name']) ?></td>
        <td data-label="Email"><?= htmlspecialchars($row['email']) ?></td>
        <td data-label="Date"><?= htmlspecialchars($row['created_at']) ?></td>
        <td data-label="Action"><a class="action-link" href="view_checkup.php?id=<?= $row['id'] ?>">View & Respond </a></td>
        <td class="status"><span class="status">Pending</span></td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
        