<?php
// Database connection
/*$host = "localhost";
$user = "root";
$password = "";
$database = "feedback_db";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$message = "";*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_name = trim($_POST['student_name']);
    $course = trim($_POST['course']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    // Basic validation
    if (!empty($student_name) && !empty($course) && !empty($rating) && !empty($comment)) {

        $stmt = $conn->prepare("INSERT INTO feedback (student_name, course, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $student_name, $course, $rating, $comment);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Feedback submitted successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error submitting feedback.</div>";
        }

        $stmt->close();

    } else {
        $message = "<div class='alert alert-warning'>Please fill all fields.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Feedback System A</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .feedback-card {
            margin-top: 50px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .header-title {
            text-align: center;
            margin-bottom: 20px;
            color: #0d6efd;
            font-weight: bold;
        }

        textarea {
            resize: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card feedback-card">
                <div class="card-body p-4">

                    <h2 class="header-title">Course Feedback Form</h2>

                    <?php //echo $message; ?>

                    <form method="POST" action="">

                        <div class="mb-3">
                            <label class="form-label">Student Name</label>
                            <input type="text" name="student_name" class="form-control" placeholder="Enter your name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Course</label>
                            <select name="course" class="form-select" required>
                                <option value="">Select Course</option>
                                <option value="CSC 101">CSC 101</option>
                                <option value="CSC 202">CSC 202</option>
                                <option value="CSC 305">CSC 305</option>
                                <option value="MTH 201">MTH 201</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select name="rating" class="form-select" required>
                                <option value="">Choose Rating</option>
                                <option value="5">Excellent</option>
                                <option value="4">Very Good</option>
                                <option value="3">Good</option>
                                <option value="2">Fair</option>
                                <option value="1">Poor</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Comment</label>
                            <textarea name="comment" class="form-control" rows="4" placeholder="Write your feedback here..." required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Submit Feedback
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>

<?php
//$conn->close();
?>