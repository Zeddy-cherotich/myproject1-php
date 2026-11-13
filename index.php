<?php
session_start();
if (!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
?>
<link rel="stylesheet"href="style.css">
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

<h1>Student List</h1>
<p style="text-align:center;">welcome,<?php echo $_SESSION['username'];?>|<a href="logout.php">Logout</a></p>
<?php if ($edit_student) { ?>
    <h3>Edit Student ID <?php echo $edit_student['id']; ?></h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $edit_student['id']; ?>">
        <input type="text" name="name" value="<?php echo $edit_student['name']; ?>" required>
        <input type="text" name="course" value="<?php echo $edit_student['course']; ?>" required>
        <input type="text" name="phone" value="<?php echo $edit_student['phone']; ?>" required>
        <button type="submit" name="update">Save Changes</button>
        <a href="index.php">Cancel</a>
    </form>
<?php } else { ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Enter Name" required>
        <input type="text" name="course" placeholder="Enter Course" required>
        <input type="text" name="phone" placeholder="Enter Phone" required>
        <button type="submit" name="add">Add Student</button>
    </form>
<?php } ?>

<hr>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th><th>Name</th><th>Course</th><th>Phone</th><th>Action</th>
    </tr>
    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['course']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td>
            <a href="?edit=<?php echo $row['id']; ?>">Edit</a> |
            <a href="?delete=<?php echo $row['id']; ?>">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>