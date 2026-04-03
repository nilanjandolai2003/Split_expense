<?php
namespace App\Controller;

use App\Model\Group;
use App\Model\Expense;
use App\Util\DebtCalculator;

class HomeController
{
    public function index(): void
    {
        $groups = Group::all();
        $message = $_SESSION['message'] ?? null;
        unset($_SESSION['message']);

        $groupDetails = [];
        foreach ($groups as $group) {
            $expenses = Expense::getByGroupId($group['id']);
            $transactions = DebtCalculator::minimizeTransactions(array_values($expenses));
            $balances = DebtCalculator::getBalanceSummary(array_values($expenses));
            
            $groupDetails[] = [
                'group' => $group,
                'expenses' => array_values($expenses),
                'transactions' => $transactions,
                'balances' => $balances,
                'totalExpense' => array_sum(array_column($expenses, 'amount')),
            ];
        }

        require __DIR__ . '/../../views/home.php';
    }
}
