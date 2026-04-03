<?php
namespace App\Controller;

use App\Model\Expense;
use App\Model\Group;

class ExpenseController
{
    public function create(): void
    {
        $groupId = $_POST['group_id'] ?? '';
        $description = $_POST['description'] ?? '';
        $amount = $_POST['amount'] ?? '';
        $paidBy = $_POST['paid_by'] ?? '';
        $splitWith = $_POST['split_with'] ?? [];

        if (trim($description) === '') {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Description is required'];
            header('Location: /');
            return;
        }

        if ((float)$amount <= 0) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Amount must be greater than 0'];
            header('Location: /');
            return;
        }

        if (trim($paidBy) === '') {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Payer is required'];
            header('Location: /');
            return;
        }

        if (empty($splitWith)) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Select at least one person to split with'];
            header('Location: /');
            return;
        }

        Expense::add($groupId, $description, $amount, $paidBy, $splitWith);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Expense added successfully!'];
        header('Location: /');
    }

    public function delete(): void
    {
        $id = $_POST['id'] ?? '';

        if ($id === '' || !Expense::delete($id)) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Expense not found'];
            header('Location: /');
            return;
        }

        $_SESSION['message'] = ['type' => 'success', 'text' => 'Expense deleted'];
        header('Location: /');
    }
}
