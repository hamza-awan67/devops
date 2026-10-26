<?php
$host = "db";
$user = "MYSQL_USER";
$password = "MYSQL_PASSWORD";
$database = "MYSQL_DATABASE";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->query("CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message VARCHAR(255) NOT NULL
)");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["message"])) {
    $stmt = $conn->prepare("INSERT INTO messages (message) VALUES (?)");
    $stmt->bind_param("s", $_POST["message"]);
    $stmt->execute();
    $stmt->close();

    header("Location: /");
    exit;
}

$result = $conn->query("SELECT * FROM messages ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Task 3 - PHP and MySQL</title>
</head>
<body>
    <h1>PHP and MySQL Docker Assignment</h1>

    <form method="post">
        <input type="text" name="message" placeholder="Enter a message" required>
        <button type="submit">Save Message</button>
    </form>

    <h2>Saved Messages</h2>

    <?php while ($row = $result->fetch_assoc()): ?>
        <p>
            <?php echo htmlspecialchars($row["message"]); ?>
        </p>
    <?php endwhile; ?>

</body>
</html>

<?php
$conn->close();
?>
