<?php

require_once('Controller.php');

$taskManager = new TaskManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['createTask'])) {
        $taskName = $_POST['taskName'];
        $taskManager->addTask($taskName);
    } elseif (isset($_POST['markDone'])) {
        $taskId = $_POST['taskId'];
        $taskManager->markTaskAsDone($taskId);
    } elseif (isset($_POST['editTask'])) {
        $taskId = $_POST['taskId'];
        $taskName = $_POST['taskName'];
        $taskManager->updateTask($taskId, $taskName);
    } elseif (isset($_POST['deleteTask'])) {
        $taskId = $_POST['taskId'];
        $taskManager->deleteTask($taskId);
    }
}

$tasks = $taskManager->getTasks();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">
    <form method="post" class="mt-5">
        <label for="taskName" class="form-label">New Task</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="taskName" name="taskName" placeholder="Task" aria-label="Task"
                   aria-describedby="button-addon2">
            <button type="submit" class="btn btn-primary" name="createTask" type="button" id="button-addon2">Create</button>
        </div>
    </form>

    <h3>Tasks</h3>
    <ul class="list-group">
        <?php foreach ($tasks as $task): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="col">
                    <small>ID: <?php echo $task['taskId']; ?></small>
                    <h5 class="mb-1">Task: <?php echo $task['taskName']; ?></h5>
                </div>
                <form method="post">
                    <input type="hidden" name="taskId" value="<?php echo $task['taskId']; ?>">
                    <?php if ($task['is_done']): ?>
                        <button type="submit" class="btn btn-success btn-sm" name="markDone">Done</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-danger btn-sm" name="markDone">Pending</button>
                    <?php endif; ?>

                    <a href="editTask.php?taskId=<?php echo $task['taskId']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <button type="submit" class="btn btn-danger btn-sm" name="deleteTask">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
