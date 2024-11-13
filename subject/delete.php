<?php
session_start();
include '../header.php';
include '../functions.php';

if (isset($_GET['subject_code'])) {
    $subject_code = $_GET['subject_code'];

    
    // Locate the subject to delete
    $subjectToDelete = null;
    if (!empty($_SESSION['subject_data'])) {
        foreach ($_SESSION['subject_data'] as $subject) {
            if ($subject['subject_code'] === $subject_code) {
                $subjectToDelete = $subject;
                break;
            }
        }
    }
} else {
    header("Location: add.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subject_code'])) {
    $subject_code = $_POST['subject_code'];

    if (!empty($_SESSION['subject_data'])) {
        foreach ($_SESSION['subject_data'] as $key => $subject) {
            if ($subject['subject_code'] === $subject_code) {
                unset($_SESSION['subject_data'][$key]);
                $_SESSION['subject_data'] = array_values($_SESSION['subject_data']); 
                break;
            }
        }
    }
    header("Location: add.php");
    exit;
}
?>

<div class="container mt-5">
    <h2>Delete a Subject</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Subject</li>
        </ol>
    </nav>
    <div class="card mt-3">
        <div class="card-body">
            <?php if ($subjectToDelete): ?>
                <h5>Are you sure you want to delete the following subject record?</h5>
                <ul>
                    <li><strong>Subject Code:</strong> <?= htmlspecialchars($subjectToDelete['subject_code']) ?></li>
                    <li><strong>Subject Name:</strong> <?= htmlspecialchars($subjectToDelete['subject_name']) ?></li>
                </ul>
                <form method="post">
                    <input type="hidden" name="subject_code" value="<?= htmlspecialchars($subjectToDelete['subject_code']) ?>">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='add.php';">Cancel</button>
                    <button type="submit" class="btn btn-primary">Delete Subject Record</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>
