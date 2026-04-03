<?php
namespace App\Util;

class DebtCalculator
{
    /**
     * Calculate minimum transactions to settle all debts
     * Uses graph-based approach with greedy algorithm
     */
    public static function minimizeTransactions(array $expenses): array
    {
        $balances = self::calculateBalances($expenses);
        
        if (empty($balances)) {
            return [];
        }

        return self::settleDebts($balances);
    }

    /**
     * Calculate who owes/is owed how much
     */
    private static function calculateBalances(array $expenses): array
    {
        $balances = [];

        foreach ($expenses as $expense) {
            $paidBy = $expense['paid_by'];
            $amount = $expense['amount'];
            $splitWith = $expense['split_with'];

            if (!isset($balances[$paidBy])) {
                $balances[$paidBy] = 0;
            }

            $splitCount = count($splitWith);
            if ($splitCount === 0) {
                continue;
            }

            $perPerson = $amount / $splitCount;

            // The person who paid gets credit
            $balances[$paidBy] += $amount;

            // Deduct from each person in split (including payer if included)
            foreach ($splitWith as $person) {
                if (!isset($balances[$person])) {
                    $balances[$person] = 0;
                }
                $balances[$person] -= $perPerson;
            }
        }

        return array_filter($balances, fn($balance) => abs($balance) > 0.01);
    }

    /**
     * Greedy algorithm to settle debts with minimum transactions
     */
    private static function settleDebts(array $balances): array
    {
        $transactions = [];
        
        while (!empty($balances)) {
            // Find the person who owes the most (most negative)
            $debtor = null;
            $maxDebt = 0;
            foreach ($balances as $person => $balance) {
                if ($balance < -0.01 && abs($balance) > $maxDebt) {
                    $debtor = $person;
                    $maxDebt = abs($balance);
                }
            }

            if ($debtor === null) {
                break;
            }

            // Find the person who is owed the most (most positive)
            $creditor = null;
            $maxCredit = 0;
            foreach ($balances as $person => $balance) {
                if ($balance > 0.01 && $balance > $maxCredit) {
                    $creditor = $person;
                    $maxCredit = $balance;
                }
            }

            if ($creditor === null) {
                break;
            }

            // Settle the debt
            $amount = min($maxCredit, $maxDebt);
            
            $transactions[] = [
                'from' => $debtor,
                'to' => $creditor,
                'amount' => round($amount, 2),
            ];

            $balances[$debtor] += $amount;
            $balances[$creditor] -= $amount;

            // Clean up near-zero balances
            if (abs($balances[$debtor]) < 0.01) {
                unset($balances[$debtor]);
            }
            if (abs($balances[$creditor]) < 0.01) {
                unset($balances[$creditor]);
            }
        }

        return $transactions;
    }

    /**
     * Get balance summary for all members
     */
    public static function getBalanceSummary(array $expenses): array
    {
        return self::calculateBalances($expenses);
    }
}
