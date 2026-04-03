<?php
namespace App\Controller;

use App\Model\Group;

class GroupController
{
    public function create(): void
    {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        if (trim($name) === '') {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Group name is required'];
            header('Location: /');
            return;
        }

        Group::add($name, $description);
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Group created successfully!'];
        header('Location: /');
    }

    public function addMember(): void
    {
        $groupId = $_POST['group_id'] ?? '';
        $memberName = $_POST['member_name'] ?? '';

        if (trim($memberName) === '') {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Member name is required'];
            header('Location: /');
            return;
        }

        if (Group::addMember($groupId, $memberName)) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Member added!'];
        } else {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Failed to add member'];
        }
        
        header('Location: /');
    }

    public function delete(): void
    {
        $id = $_POST['id'] ?? '';

        if ($id === '' || !Group::delete($id)) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Group not found'];
            header('Location: /');
            return;
        }

        $_SESSION['message'] = ['type' => 'success', 'text' => 'Group deleted'];
        header('Location: /');
    }
}
