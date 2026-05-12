<?php
require_once "db.php";

// Delete Feedback
if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("DELETE FROM feedback WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin.php?deleted=1");
        exit();
    }

    $stmt->close();
}

// Fetch Feedback Records
$sql = "SELECT * FROM feedback ORDER BY created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body {
            background-color: #f5f7fa;
        }

        .dashboard-card {
            margin-top: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .page-title {
            color: #0d6efd;
            font-weight: bold;
        }

        table th {
            background-color: #0d6efd;
            color: white;
        }

    </style>
</head>
<body>

<div class="container">

    <div class="card dashboard-card">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="page-title">Feedback Admin Dashboard</h2>

                <a href="index.php" class="btn btn-primary">
                    Back to Form
                </a>
            </div>

            <!-- Alert Messages -->

            <?php if (isset($_GET['deleted'])): ?>
                <div class="alert alert-success">
                    Feedback deleted successfully.
                </div>
            <?php endif; ?>

            <!-- Feedback Table -->

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Course</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if ($result->num_rows > 0): ?>

                        <?php while($row = $result->fetch_assoc()): ?>

                            <tr>
                                <td><?php echo $row['id']; ?></td>

                                <td>
                                    <?php echo htmlspecialchars($row['student_name']); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row['course']); ?>
                                </td>

                                <td>
                                    <?php echo $row['rating']; ?>/5
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($row['comment']); ?>
                                </td>

                                <td>
                                    <?php echo $row['created_at']; ?>
                                </td>

                                <td>
                                    <a href="admin.php?delete=<?php echo $row['id']; ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this feedback?')">
                                       Delete
                                    </a>
                                </td>
                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="7" class="text-center">
                                No feedback records found.
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

</body>
</html>

<?php
$conn->close();
?>