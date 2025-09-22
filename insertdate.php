<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quizDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$question_text = $_POST['question_text'];
$option_a = $_POST['option_a'];
$option_b = $_POST['option_b'];
$option_c = $_POST['option_c'];
$option_d = $_POST['option_d'];
$correct_answer = $_POST['correct_answer'];


// Insert record
$sql = "INSERT INTO questions (question_text, option_a,option_b,option_c,option_d,correct_answer)
 VALUES ('$question_text', '$option_a','$option_b','$option_c','$option_d', '$correct_answer')";

if ($conn->query($sql) === TRUE) {
    echo "Record inserted successfully!";
    echo "<br><a href='index.html'>Go Back</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
