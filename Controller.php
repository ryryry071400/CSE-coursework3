<?php

class Database
{
    private $host = '127.0.0.1';
    private $user = 'root';
    private $pass = '';
    private $name = 'tms';
    private $conn;

    public function
 
__construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function establishConnection()
    {
        return $this->conn;
    }
}

class TaskManager
{
    private $db;

    public function __construct($db = null)
    {
        if (!$db) {
            $db = new Database();
        }

        $this->db = $db;
    }

    // Create task
    public function addTask($taskName)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("INSERT INTO tasks (taskName) VALUES (?)");
        $query->bind_param("s", $taskName);
        $query->execute();
        $query->close();
    }

    public function markTaskAsDone($taskId)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("UPDATE tasks SET is_done = 1 WHERE taskId = ?");
        $query->bind_param("i", $taskId);
        $query->execute();
        $query->close();
    }

    // Read all tasks
    public function getTasks()
    {
        $conn = $this->db->establishConnection();
        $taskQuery = $conn->query("SELECT * FROM tasks");
        $tasks = [];

        while ($row = $taskQuery->fetch_assoc()) {
            $tasks[] = $row;
        }

        return $tasks;
    }

    // Read a specific task
    public function getTaskById($taskId)
    {
    $conn = $this->db->establishConnection();
    $taskQuery = $conn->prepare("SELECT * FROM tasks WHERE taskId = ?");
    $taskQuery->bind_param("i", $taskId);

    if ($taskQuery->execute()) {
        $result = $taskQuery->get_result(); // Get the result
        $task = $result->fetch_assoc(); // Fetch the associative array
    } else {
        echo "Error: " . $conn->error;
    }

    $taskQuery->close();

    return $task;
    }

    // Update task
    public function updateTask($taskId, $taskName)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("UPDATE tasks SET taskName = ? WHERE taskId = ?");
        $query->bind_param("si", $taskName, $taskId);
        $query->execute();
        $query->close();
    }

    // Delete task
    public function deleteTask($taskId)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("DELETE FROM tasks WHERE taskId = ?");
        $query->bind_param("i", $taskId);
        $query->execute();
        $query->close();
    }
}

?>
