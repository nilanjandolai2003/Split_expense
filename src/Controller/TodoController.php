<?php
namespace App\Controller;

use App\Model\Todo;

class TodoController
{
    public function create(): void
    {
        $title = $_POST['title'] ?? '';

        if (trim($title) === '') {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Todo title cannot be empty'];
            header('Location: /');
            return;
        }

        Todo::add($title);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Todo added'];
        header('Location: /');
    }

    public function toggle(): void
    {
        $id = $_POST['id'] ?? '';

        if ($id === '' || !Todo::toggle($id)) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Todo not found'];
            header('Location: /');
            return;
        }

        $_SESSION['message'] = ['type' => 'success', 'text' => 'Todo status toggled'];
        header('Location: /');
    }
}
