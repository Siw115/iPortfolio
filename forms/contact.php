<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/plain');

// Alleen POST-verzoeken toestaan
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    echo "Alleen POST-verzoeken zijn toegestaan.";
    exit;
}

// Gegevens ophalen
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validatie
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    http_response_code(400);
    echo "Alle velden zijn verplicht.";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Ongeldig e-mailadres.";
    exit;
}

// Bericht samenstellen
$to = "siwani1155@gmail.com";  // Ontvanger
$headers  = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$body  = "Je hebt een nieuw bericht ontvangen via het contactformulier:\n\n";
$body .= "Naam: $name\n";
$body .= "E-mail: $email\n";
$body .= "Onderwerp: $subject\n";
$body .= "Bericht:\n$message\n";

// Versturen
if (mail($to, $subject, $body, $headers)) {
    echo "OK";
} else {
    http_response_code(500);
    echo "Er is iets fout gegaan bij het verzenden.";
}
?>
