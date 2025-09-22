<?php
$host = "localhost";
$db = "quizDB";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$sql = "SELECT * FROM questions WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $options = [
        "A" => $row['option_a'],
        "B" => $row['option_b'],
        "C" => $row['option_c'],
        "D" => $row['option_d']
    ];
    echo json_encode([
        "question_text" => $row['question_text'],
        "options" => $options,
        "correct_answer" => $row['correct_answer']
    ]);
} else {
    echo json_encode([
        "question_text" => "No more questions!",
        "options" => [],
        "correct_answer" => ""
    ]);
}
