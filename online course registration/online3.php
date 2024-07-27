<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = $_POST['course_id'];

    $sql = "INSERT INTO registrations (user_id, course_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $course_id);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$sql = "SELECT id, course_name, description, seats FROM courses";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Courses</title>
</head>
<body>
    <h2>Courses</h2>
    <form method="POST">
        <select name="course_id">
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['course_name'] ?> (Seats: <?= $row['seats'] ?>)</option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Register</button>
    </form>
</body>
</html>
