<?php
session_start();
$pageTitle = "Delete Student Record";
include '../header.php';
include '../functions.php';

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

   
    $studentToDelete = null;
    if (!empty($_SESSION['student_data'])) {
        foreach ($_SESSION['student_data'] as $student) {
            if ($student['student_id'] === $student_id) {
                $studentToDelete = $student;
                break;
            }
        }
    }
} else {
    header("Location: register.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    if (!empty($_SESSION['student_data'])) {
        foreach ($_SESSION['student_data'] as $key => $student) {
            if ($student['student_id'] === $student_id) {
                unset($_SESSION['student_data'][$key]);
                $_SESSION['student_data'] = array_values($_SESSION['student_data']); 
                break;
            }
        }
    }
    header("Location: register.php");
    exit;
}
?>

<div class="container mt-5">
    <h2>Delete a Student</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Student</li>
        </ol>
    </nav>
    <div class="card mt-3">
        <div class="card-body">
            <?php if ($studentToDelete): ?>
                <h5>Are you sure you want to delete the following student record?</h5>
                <ul>
                    <li><strong>Student ID:</strong> <?= htmlspecialchars($studentToDelete['student_id']) ?></li>
                    <li><strong>First Name:</strong> <?= htmlspecialchars($studentToDelete['first_name']) ?></li>
                    <li><strong>Last Name:</strong> <?= htmlspecialchars($studentToDelete['last_name']) ?></li>
                </ul>
                <form method="POST">
                    <input type="hidden" name="student_id" value="<?= htmlspecialchars($studentToDelete['student_id']) ?>">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='register.php';">Cancel</button>
                    <button type="submit" class="btn btn-primary">Delete Student Record</button>
                </form>
            <?php else: ?>
                <p class="text-danger">Student not found.</p>
                <a href="register.php" class="btn btn-primary">Back to Student List</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>
