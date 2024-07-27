<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT c.course_name, c.description, r.registration_date FROM registrations r
        JOIN courses c ON r.course_id = c.id WHERE r.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Dashboard</h2>
    <h3>Your Registrations</h3>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li><?= $row['course_name'] ?> - <?= $row['description'] ?> (Registered on <?= $row['registration_date'] ?>)</li>
        <?php endwhile; ?>
    </ul>
    <a href="courses.php">Register for new courses</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>
