<?php
session_start();
if (!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
?>
<?php
include 'db.php';
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $course = $_POST['course'];
    $phone = $_POST['phone'];
    $conn->query("INSERT INTO students (name, course, phone) VALUES ('$name', '$course', '$phone')");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM students WHERE id = $id");
}
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $course = $_POST['course'];
    $phone = $_POST['phone'];
    $conn->query("UPDATE students SET name='$name', course='$course', phone='$phone' WHERE id=$id");
}
$edit_student = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_student = $conn->query("SELECT * FROM students WHERE id=$id")->fetch_assoc();
}

$result = $conn->query("SELECT * FROM students");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Students | Student Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="page-shell">
    <header class="topbar">
        <a class="brand" href="index.php">
            <span class="brand-mark" aria-hidden="true">S</span>
            <span>STUDENT PORTAL</span>
        </a>
        <div class="user-menu">
            <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></strong></span>
            <a href="logout.php">Log out</a>
        </div>
    </header>

    <section class="page-heading">
        <h1>Students</h1>
        <p>Manage student records, courses, and contact details.</p>
    </section>

    <section class="panel">
        <div class="panel-heading">
            <div>
                <h2><?php echo $edit_student ? 'Edit student' : 'Add a student'; ?></h2>
                <p><?php echo $edit_student ? 'Update the details below.' : 'Enter the student details to add a record.'; ?></p>
            </div>
        </div>
        <form class="student-form" method="POST">
            <?php if ($edit_student) { ?>
                <input type="hidden" name="id" value="<?php echo (int) $edit_student['id']; ?>">
            <?php } ?>
            <div class="field">
                <label for="student-name">Full name</label>
                <input id="student-name" type="text" name="name" placeholder="e.g. Alex Morgan" value="<?php echo $edit_student ? htmlspecialchars($edit_student['name'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
            </div>
            <div class="field">
                <label for="student-course">Course</label>
                <input id="student-course" type="text" name="course" placeholder="e.g. Computer Science" value="<?php echo $edit_student ? htmlspecialchars($edit_student['course'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
            </div>
            <div class="field">
                <label for="student-phone">Phone number</label>
                <input id="student-phone" type="text" name="phone" placeholder="e.g. +1 555 0100" value="<?php echo $edit_student ? htmlspecialchars($edit_student['phone'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
            </div>
            <button class="button" type="submit" name="<?php echo $edit_student ? 'update' : 'add'; ?>">
                <?php echo $edit_student ? 'Save changes' : 'Add student'; ?>
            </button>
            <?php if ($edit_student) { ?>
                <a class="button button-secondary" href="index.php">Cancel</a>
            <?php } ?>
        </form>
    </section>

    <section class="panel">
        <div class="panel-heading">
            <div>
                <h2>Student directory</h2>
                <p>All students currently in your records.</p>
            </div>
        </div>
        <?php if ($result->num_rows === 0) { ?>
            <div class="empty-state">No students yet. Add your first student using the form above.</div>
        <?php } else { ?>
            <div class="student-table-wrap">
                <table class="student-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Course</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo (int) $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['course'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="table-actions">
                                <a href="?edit=<?php echo (int) $row['id']; ?>">Edit</a>
                                <a class="delete-link" href="?delete=<?php echo (int) $row['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </section>
</main>
</body>
</html>