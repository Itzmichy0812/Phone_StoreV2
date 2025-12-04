<?php
require_once __DIR__ . '/../models/ContactModel.php';

class ContactController {

    private $model;

    public function __construct() {
        $this->model = new ContactModel();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case "create":
                $this->create();
                break;

            case "list":
                $this->getAll();
                break;

            case "get":
                $this->getSingle();
                break;

            case "updateStatus":
                $this->updateStatus();
                break;

            case "delete":
                $this->delete();
                break;

            default:
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid action"
                ]);
        }
    }

    // User side
    private function create() {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $message = $_POST['message'] ?? '';

        if (empty($name) || empty($email) || empty($message)) {
            echo json_encode([
                "success" => false,
                "message" => "Missing required fields"
            ]);
            return;
        }

        if ($this->model->create($name, $email, $subject, $message)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to submit contact"]);
        }
    }


    private function getAll() {
        $data = $this->model->getAll();
        echo json_encode([
            "success" => true,
            "data" => $data
        ]);
    }

    private function getSingle() {
        $id = $_GET['id'] ?? 0;
        $data = $this->model->getById($id);

        if ($data) {
            echo json_encode([
                "success" => true,
                "data" => $data
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Contact not found"
            ]);
        }
    }

    private function updateStatus() {
        $id = $_POST['id'] ?? 0;
        $status = $_POST['status'] ?? '';

        if ($this->model->updateStatus($id, $status)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update status"]);
        }
    }

    private function delete() {
        $id = $_POST['id'] ?? 0;

        if ($this->model->delete($id)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to delete"]);
        }
    }
}

$controller = new ContactController();
$controller->handleRequest();
