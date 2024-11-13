<?php
session_start();
$pageTitle = "Edit Student";
include '../header.php';
include '../functions.php';
guard();

$errors = [];
$studentToEdit = null;
$studentIndex = null;

if (isset($_REQUEST['student_id'])) {
    $student_id = $_REQUEST['student_id'];

    foreach ($_SESSION['student_data'] as $key => $student) {
        if ($student['student_id'] === $student_id) {
            $studentToEdit = $student;
            $studentIndex = $key;
            break;
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {

    $updatedData = [
        'student_id' => $_POST['student_id'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name']
    ];

    if (empty($updatedData['first_name'])) {
        $errors[] = "First Name is equired";
    }

    if (empty($updatedData['last_name'])) {
        $errors[] = "Last Name is equired";
    }


    if (empty($errors)) {
        $_SESSION['student_data'][$studentIndex] = $updatedData;
       
        header("Location: register.php"); 
        exit;
    }
}
?>

<div class="container mt-5">
    <h2>Edit Student</h2>
    <br>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
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

    <?php if ($studentToEdit): ?>
        <form action="edit.php?student_id=<?= urlencode($studentToEdit['student_id']) ?>" method="post">
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="text" class="form-control" id="student_id" name="student_id" value="<?= htmlspecialchars($studentToEdit['student_id']) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($studentToEdit['first_name']) ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($studentToEdit['last_name']) ?>">
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Update Student</button>
        </form>
    <?php endif; ?>
</div>

<?php include '../footer.php'; ?>