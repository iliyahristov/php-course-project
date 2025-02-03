<?php
require_once 'config.php';

if (isset($_POST['save_student'])) {
    $db = Database::getInstance();
    $conn = $db->getConnection();

    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $faculty_number = $conn->real_escape_string($_POST['faculty_number']);

    $sql = "INSERT INTO student (first_name, last_name, faculty_number) 
            VALUES ('$first_name', '$last_name', '$faculty_number')";

    if ($conn->query($sql) === TRUE) {
        exit(json_encode(['success' => true]));
    } else {
        http_response_code(500);
        exit(json_encode(['error' => $conn->error]));
    }
}

if (isset($_POST['save_lecture'])) {
    $db = Database::getInstance();
    $conn = $db->getConnection();

    $student_id = $conn->real_escape_string($_POST['student_id']);
    $lecture_id = $conn->real_escape_string($_POST['lecture_id']);

    $sql = "INSERT INTO student_lecture (student_id, lecture_id) 
            VALUES ('$student_id', '$lecture_id')";

    if ($conn->query($sql) === TRUE) {
        exit(json_encode(['success' => true]));
    } else {
        http_response_code(500);
        exit(json_encode(['error' => $conn->error]));
    }
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление на студенти</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Управление на студенти</h1>

<button onclick="openAddStudentModal()">Добави нов студент</button>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Име</th>
        <th>Фамилия</th>
        <th>Факултетен номер</th>
        <th>Лекции</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $db = Database::getInstance();
    $conn = $db->getConnection();

    $sql = "SELECT s.id, s.first_name, s.last_name, s.faculty_number, GROUP_CONCAT(l.name SEPARATOR ', ') AS lectures
            FROM student s
            LEFT JOIN student_lecture sl ON s.id = sl.student_id
            LEFT JOIN lecture l ON sl.lecture_id = l.id
            GROUP BY s.id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['id']) . "</td>
                    <td>" . htmlspecialchars($row['first_name']) . "</td>
                    <td>" . htmlspecialchars($row['last_name']) . "</td>
                    <td>" . htmlspecialchars($row['faculty_number']) . "</td>
                    <td>" . htmlspecialchars($row['lectures']) . "</td>
                    <td>
                        <button onclick='openAddLectureModal(" . $row['id'] . ")'>Добави лекция</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Няма намерени студенти.</td></tr>";
    }
    ?>
    </tbody>
</table>

<div id="addStudentModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h2>Добави нов студент</h2>
        <form id="addStudentForm" method="POST">
            <input type="text" name="first_name" placeholder="Име" required>
            <input type="text" name="last_name" placeholder="Фамилия" required>
            <input type="text" name="faculty_number" placeholder="Факултетен номер" required>
            <button type="submit">Запази</button>
            <button type="button" onclick="closeModal('addStudentModal')">Затвори</button>
        </form>
    </div>
</div>

<div id="addLectureModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h2>Добави лекция</h2>
        <form id="addLectureForm" method="POST">
            <input type="hidden" id="student_id" name="student_id">
            <select name="lecture_id" required>
                <?php
                $sql = "SELECT * FROM lecture";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" .
                        htmlspecialchars($row['name']) . "</option>";
                }
                ?>
            </select>
            <button type="submit">Запази</button>
            <button type="button" onclick="closeModal('addLectureModal')">Затвори</button>
        </form>
    </div>
</div>

<script src="scripts.js"></script>
</body>
</html>