<?php
session_start();
$pageTitle = "Attach Subject to Student";
include '../header.php';
include '../functions.php';

$studentToAttach = null;
$errors = [];

// Retrieve selected student information based on student_id
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    if (!empty($_SESSION['student_data'])) {
        foreach ($_SESSION['student_data'] as $student) {
            if ($student['student_id'] === $student_id) {
                $studentToAttach = $student;
                break;
            }
        }
    }
}

// Attach subjects to the student when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['subject_codes']) && !empty($_POST['subject_codes'])) {
        $subject_codes = $_POST['subject_codes'];

        // Ensure session data for attached subjects by student ID exists
        if (!isset($_SESSION['attached_subjects'])) {
            $_SESSION['attached_subjects'] = [];
        }

        // Initialize array for this student if not already set
        if (!isset($_SESSION['attached_subjects'][$student_id])) {
            $_SESSION['attached_subjects'][$student_id] = [];
        }

        // Add selected subjects for this student
        $_SESSION['attached_subjects'][$student_id] = array_merge(
            $_SESSION['attached_subjects'][$student_id],
            $subject_codes
        );
    } else {
        // Add error message if no subjects were selected
        $errors[] = 'At least one subject should be selected.';
    }
}

?>

<div class="container mt-5">
    <h2>Attach Subject to Student</h2>
    <br>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Attach Subject</li>
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

    <?php if ($studentToAttach): ?>
        <div class="container">
            <h3>Selected Student Information</h3>
            <ul>
                <li><strong>Student ID:</strong> <?= htmlspecialchars($studentToAttach['student_id']) ?></li>
                <li><strong>First Name:</strong> <?= htmlspecialchars($studentToAttach['first_name']) ?></li>
                <li><strong>Last Name:</strong> <?= htmlspecialchars($studentToAttach['last_name']) ?></li>
            </ul>
        </div>
    <?php else: ?>
        <p class="text-danger">Student not found.</p>
        <a href="register.php" class="btn btn-primary">Back to Student List</a>
    <?php endif; ?>

    <hr>

    <form method="post">
        <h3>Select Subjects to Attach</h3>
        <?php 
        if (!empty($_SESSION['subject_data'])): 
            $attached_subjects = $_SESSION['attached_subjects'][$student_id] ?? [];
            $available_subjects = array_filter($_SESSION['subject_data'], function($subject) use ($attached_subjects) {
                return !in_array($subject['subject_code'], $attached_subjects);
            });

            if (!empty($available_subjects)): 
                foreach ($available_subjects as $subject): ?>
                    <div>
                        <input 
                            type="checkbox" 
                            name="subject_codes[]" 
                            value="<?= htmlspecialchars($subject['subject_code']) ?>"
                        >
                        <?= htmlspecialchars($subject['subject_code']) ?> - <?= htmlspecialchars($subject['subject_name']) ?>
                    </div>
                <?php endforeach; ?>
                <br>
                <button type="submit" class="btn btn-primary">Attach Selected Subjects</button>
            <?php else: ?>
                <p>No subjects available to attach.</p>
            <?php endif;
        else: ?>
            <p>No subjects available. Please add subjects first.</p>
        <?php endif; ?>
    </form>

    <hr>
    <h3 class="mt-5">Attached Subjects for Student</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($_SESSION['attached_subjects'][$student_id])): ?>
                <?php foreach ($_SESSION['attached_subjects'][$student_id] as $attached_code): ?>
                    <?php foreach ($_SESSION['subject_data'] as $subject): ?>
                        <?php if ($subject['subject_code'] === $attached_code): ?>
                            <tr>
                                <td><?= htmlspecialchars($subject['subject_code']); ?></td>
                                <td><?= htmlspecialchars($subject['subject_name']); ?></td>
                                <td><a href="dettach-subject.php?student_id=<?= urlencode($student_id) ?>&subject_code=<?= urlencode($attached_code) ?>" class="btn btn-danger btn-sm">Detach Subject</a></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No subjects attached.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../footer.php'; ?>
