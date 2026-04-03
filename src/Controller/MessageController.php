<?php
namespace App\Controller;

use App\Model\Message;

class MessageController
{
    public function send(): void
    {
        $username = $_POST['username'] ?? '';
        $text = $_POST['text'] ?? '';

        if (trim($username) === '') {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Username cannot be empty'];
            header('Location: /');
            return;
        }

        if (trim($text) === '') {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Message cannot be empty'];
            header('Location: /');
            return;
        }

        Message::add($username, $text);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Message sent!'];
        header('Location: /');
    }

    public function delete(): void
    {
        $id = $_POST['id'] ?? '';

        if ($id === '' || !Message::delete($id)) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Message not found'];
            header('Location: /');
            return;
        }

        $_SESSION['message'] = ['type' => 'success', 'text' => 'Message deleted'];
        header('Location: /');
    }
}
