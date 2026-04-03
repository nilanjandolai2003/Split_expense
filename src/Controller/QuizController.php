<?php
namespace App\Controller;

use App\Model\Quiz;

class QuizController
{
    public function create(): void
    {
        $title = $_POST['title'] ?? '';
        $paragraph = $_POST['paragraph'] ?? '';

        if (trim($title) === '') {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Quiz title cannot be empty'];
            header('Location: /');
            return;
        }

        if (trim($paragraph) === '') {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Paragraph cannot be empty'];
            header('Location: /');
            return;
        }

        if (strlen($paragraph) < 50) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Paragraph must be at least 50 characters'];
            header('Location: /');
            return;
        }

        Quiz::add($title, $paragraph);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Quiz created successfully!'];
        header('Location: /');
    }

    public function submit(): void
    {
        $quizId = $_POST['quiz_id'] ?? '';
        $answers = $_POST['answers'] ?? [];

        if ($quizId === '') {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Invalid quiz'];
            header('Location: /');
            return;
        }

        $result = Quiz::recordAttempt($quizId, $answers);
        
        $_SESSION['quiz_result'] = $result;
        $_SESSION['quiz_id'] = $quizId;
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Quiz submitted! Check your results below.'];
        header('Location: /');
    }

    public function delete(): void
    {
        $id = $_POST['id'] ?? '';

        if ($id === '' || !Quiz::delete($id)) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Quiz not found'];
            header('Location: /');
            return;
        }

        $_SESSION['message'] = ['type' => 'success', 'text' => 'Quiz deleted'];
        header('Location: /');
    }
}
