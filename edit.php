<?php

require_once('index.php');
require_once('Controller.php');

$taskId = $_GET['taskId'];

global $db, $taskManager;

$task = $taskManager->getTaskById($taskId);

if (!$task) {
    header('HTTP/1.0 404 Not Found');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedTaskName = $_POST['taskName'];
    $taskManager->updateTask($taskId, $updatedTaskName);
    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">
    <h3>Edit Task</h3>

    <form method="post">
        <label for="taskName" class="form-label">Task Name</label>
        <input type="text" class="form-control" id="taskName" name="taskName" value="<?php echo $task['taskName']; ?>">

        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
