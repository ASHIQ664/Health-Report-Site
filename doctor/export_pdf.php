<?php
require_once '../dompdf/autoload.inc.php';
require '../config/db.php';

use Dompdf\Dompdf;
if(!isset($_GET['id'])) {
    die("No checkup ID provided");
}
$checkup_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT c.*, u.name AS patient_name FROM checkups c JOIN users u
ON c.user_id = u.id WHERE c.id = ?");
$stmt->execute([$checkup_id]);
$checkup = $stmt->fetch();

if(!$checkup){
    die("Checkup not found");
}
$html = '
<h2>Checkup Report</h2>
<p><strong>Patient Name:</strong> '. htmlspecialchars($checkup['patient_name']). '</p>
<p><strong>Phone:</strong>'. htmlspecialchars($checkup['phone']).'</p>
<p><strong>Temperature:</strong>'. htmlspecialchars($checkup['temperature']).'</p>
<p><strong>Blood Pressure:</strong>'. htmlspecialchars($checkup['blood_pressure']).'</p>
<p><strong>SugarLevel:</strong>'. htmlspecialchars($checkup['sugar_level']).'</p>
<p><strong>Pain Level:</strong>'. htmlspecialchars($checkup['pain_level']).'</p>
<p><strong>Medicines:</strong>'. nl2br(htmlspecialchars($checkup['medicines'])).'</p>
<p><strong>Feeling:</strong>'. nl2br(htmlspecialchars($checkup['feeling'])).'</p>
<p><strong>Date:</strong>'. $checkup['created_at'].'</p>';

$dompdf = new Dompdf();
$dompdf->loadhtml($html);
$dompdf->setPaper('A4','potrait');
$dompdf->render();
$dompdf->stream("Checkup_Report.pdf",["Attachment"=> false]);?>