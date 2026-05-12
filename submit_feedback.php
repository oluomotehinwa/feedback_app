<?php
require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_name = trim($_POST['student_name']);
    $course = trim($_POST['course']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    // Basic Validation
    if (
        !empty($student_name) &&
        !empty($course) &&
        !empty($rating) &&
        !empty($comment)
    ) {

        // Insert into Database
        $stmt = $conn->prepare(
            "INSERT INTO feedback (student_name, course, rating, comment)
             VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssis",
            $student_name,
            $course,
            $rating,
            $comment
        );

        if ($stmt->execute()) {
            header("Location: index.php?success=1");
            exit();
        } else {
            header("Location: index.php?error=1");
            exit();
        }

        $stmt->close();

    } else {
        header("Location: index.php?empty=1");
        exit();
    }

} else {
    header("Location: index.php");
    exit();
}

$conn->close();
?>