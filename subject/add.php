<?php
session_start();
$pageTitle = "Register Subject";
include '../header.php';
include '../functions.php';
guard();

$errors = [];
$subject_data = [];

if (!isset($_SESSION['subject_data'])) {
    $_SESSION['subject_data'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_data = [
        'subject_code' => $_POST['subject_code'],
        'subject_name' => $_POST['subject_name']
    ];

    $errors = validateSubjectData($subject_data);

    
    $duplicate_index = getSelectedSubjectIndex($subject_data['subject_code']);
    $duplicate_subject = getSelectedSubjectData($subject_data['subject_name']);
    if ($duplicate_index !== null && $duplicate_subject !== null) {
        $errors[] = "Duplicate Subject";
    }

    if (empty($errors)) {
        $_SESSION['subject_data'][] = $subject_data;
        header("Location: add.php");
        exit;
    }
}
?>

<div class="container mt-5">
    <h2>Add a New Subject</h2>
    <br>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
        </ol>
    </nav>
    <hr>
    <br>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>System Errors</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label for="subject_code">Subject Code</label>
            <input type="text" class="form-control" id="subject_code" name="subject_code" placeholder="Enter Subject Code">
        </div>
        <div class="form-group">
            <label for="subject_name">Subject Name</label>
            <input type="text" class="form-control" id="subject_name" name="subject_name" placeholder="Enter Subject Name">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Add Subject</button>
    </form>
    <hr>
    <h3 class="mt-5">Subject List</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($_SESSION['subject_data'])): ?>
                <?php foreach ($_SESSION['subject_data'] as $subject): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($subject['subject_code']); ?></td>
                        <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                        <td>
                            <a href="edit.php?subject_code=<?php echo urlencode($subject['subject_code']); ?>" class="btn btn-info btn-sm">Edit</a>
                            <a href="delete.php?subject_code=<?php echo urlencode($subject['subject_code']); ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No subjects found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../footer.php'; ?>
