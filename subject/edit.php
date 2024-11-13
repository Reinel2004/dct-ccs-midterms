<?php
session_start();
$pageTitle = "Edit Subject";
include '../header.php';
include '../functions.php';

if (empty($_SESSION['email'])) {
    header("Location: ../index.php");
    exit;
}

header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache");

checkUserSessionIsActive();  
guard(); 

$errors = [];
$subjectToEdit = null;
$subjectIndex = null;

if (isset($_REQUEST['subject_code'])) {
    $subject_code = $_REQUEST['subject_code'];

    foreach ($_SESSION['subject_data'] as $key => $subject) {
        if ($subject['subject_code'] === $subject_code) {
            $subjectToEdit = $subject;
            $subjectIndex = $key;
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subject_code'])) {
    $updatedData = [
        'subject_code' => $_POST['subject_code'],
        'subject_name' => $_POST['subject_name'],
    ];

    if (empty($updatedData['subject_name'])) {
        $errors[] = "Subject Name is equired";
    }

    if (empty($errors) && $subjectIndex !== null) {
        $_SESSION['subject_data'][$subjectIndex] = $updatedData;
        header("Location: add.php");
        exit;
    }
}
?>

<div class="container mt-5">
    <h2>Edit Subject</h2>
    <br>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
        </ol>
    </nav>
    <hr>
    <br>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <strong>System Errors</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($subjectToEdit): ?>
        <form action="edit.php?subject_code=<?= urlencode($subjectToEdit['subject_code']) ?>" method="post">
            <div class="form-group">
                <label for="subject_code">Subject Code</label>
                <input type="text" class="form-control" id="subject_code" name="subject_code" value="<?= htmlspecialchars($subjectToEdit['subject_code']) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="subject_name">Subject Name</label>
                <input type="text" class="form-control" id="subject_name" name="subject_name" value="<?= htmlspecialchars($subjectToEdit['subject_name'] ?? '') ?>">
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Update Subject</button>
        </form>
    <?php else: ?>
        <p class="text-danger">Subject not found.</p>
        <a href="register.php" class="btn btn-primary">Back to Subject List</a>
    <?php endif; ?>
</div>

<?php include '../footer.php'; ?>
