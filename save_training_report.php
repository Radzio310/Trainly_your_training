<?php
session_start();
$id = $_SESSION['user_id'];

require_once "config.php";

// Stwórz połączenie z bazą danych
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

// Sprawdzenie połączenia
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Odbieranie danych z żądania POST
$data = json_decode(file_get_contents("php://input"), true);

$trainingId = $data['Training_ID'];
$date = $data['Date'];
$trainingTime = $data['Training_time'];
$exercises = json_encode($data['Exercises'], JSON_UNESCAPED_UNICODE); // Dodaj flagę JSON_UNESCAPED_UNICODE

// Przygotowanie zapytania SQL
$sql = "INSERT INTO history (User_ID, Training_ID, Date, Training_time, Exercises)
VALUES ('$id', '$trainingId', '$date', '$trainingTime', '$exercises')";

if (mysqli_query($conn, $sql)) {
    header("Location: userpage.php?train=training_saved");
} else {
    header("Location: userpage.php?train=error");
}

// Zamknięcie połączenia
$conn->close();
?>
