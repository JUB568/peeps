<?php
require_once 'conn.php';

// You can change this to any valid table name
$table = "employees"; 

// Validate if table exists in allowed list (optional security)
$allowed_tables = ['employees']; 
if (!in_array($table, $allowed_tables)) {
    die("❌ Table not allowed.");
}

// Fetch table data
$result = $mysqli->query("SELECT * FROM `$table`");
if (!$result) {
    die("❌ Query failed: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check Aiven MySQL Connection</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Employees Table (Aiven MySQL)</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <?php while ($field = $result->fetch_field()): ?>
                    <th><?= htmlspecialchars($field->name) ?></th>
                <?php endwhile; ?>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <?php foreach ($row as $cell): ?>
                        <td><?= htmlspecialchars($cell) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No data found in the table.</p>
    <?php endif; ?>

    <?php $mysqli->close(); ?>
</body>
</html>
