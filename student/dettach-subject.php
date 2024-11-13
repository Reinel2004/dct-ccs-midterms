<?php
session_start();
$pageTitle = "Dettach Subject from Student";
include '../header.php';
include '../functions.php';

$studentToDelete = null;
$subjectToDetach = null;

if (isset($_GET['student_id']) && isset($_GET['subject_code'])) {
    $student_id = $_GET['student_id'];
    $subject_code = $_GET['subject_code'];

    // Retrieve student data
    if (!empty($_SESSION['student_data'])) {
        foreach ($_SESSION['student_data'] as $student) {
            if ($student['student_id'] === $student_id) {
                $studentToDelete = $student;
                break;
            }
        }
    }

    if (!empty($_SESSION['subject_data'])) {
        foreach ($_SESSION['subject_data'] as $subject) {
            if ($subject['subject_code'] === $subject_code) {
                $subjectToDetach = $subject;
                break;
            }
        }
    }
} else {
    header("Location: register.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id']) && isset($_POST['subject_code'])) {
    $student_id = $_POST['student_id'];
    $subject_code = $_POST['subject_code'];

    if (!empty($_SESSION['attached_subjects'][$student_id])) {
        $_SESSION['attached_subjects'][$student_id] = array_filter(
            $_SESSION['attached_subjects'][$student_id],
            function ($code) use ($subject_code) {
                return $code !== $subject_code;
            }
        );

        $_SESSION['attached_subjects'][$student_id] = array_values($_SESSION['attached_subjects'][$student_id]);
    }

    header("Location: attach-subject.php?student_id=" . urlencode($student_id));
    exit;
}
?>

<div class="container mt-5">
    <h2>Detach Subject from Student</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item"><a href="attach-subject.php">Attach Subject to Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detach Subject from Student</li>
        </ol>
    </nav>
    <div class="card mt-3">
        <div class="card-body">
            <?php if ($studentToDelete && $subjectToDetach): ?>
                <h5>Are you sure you want to detach this subject from this student record?</h5>
                <ul>
                    <li><strong>Student ID:</strong> <?= htmlspecialchars($studentToDelete['student_id']) ?></li>
                    <li><strong>First Name:</strong> <?= htmlspecialchars($studentToDelete['first_name']) ?></li>
                    <li><strong>Last Name:</strong> <?= htmlspecialchars($studentToDelete['last_name']) ?></li>
                    <li><strong>Subject Code:</strong> <?= htmlspecialchars($subjectToDetach['subject_code']) ?></li>
                    <li><strong>Subject Name:</strong> <?= htmlspecialchars($subjectToDetach['subject_name']) ?></li>
                </ul>
                <form method="POST">
                    <input type="hidden" name="student_id" value="<?= htmlspecialchars($studentToDelete['student_id']) ?>">
                    <input type="hidden" name="subject_code" value="<?= htmlspecialchars($subjectToDetach['subject_code']) ?>">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='register.php';">Cancel</button>
                    <button type="submit" class="btn btn-primary">Detach Subject from Student</button>
                </form>
            <?php else: ?>
                <p class="text-danger">Student or subject not found.</p>
                <a href="register.php" class="btn btn-primary">Back to Student List</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>
