<?php
namespace App\Model;

class Expense
{
    private const DATA_FILE = __DIR__ . '/../../data/expenses.json';

    public static function all(): array
    {
        if (!file_exists(self::DATA_FILE)) {
            self::save([]);
        }

        $raw = file_get_contents(self::DATA_FILE);
        $items = json_decode($raw, true);

        return is_array($items) ? $items : [];
    }

    public static function save(array $items): void
    {
        file_put_contents(self::DATA_FILE, json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public static function getByGroupId(string $groupId): array
    {
        $items = self::all();
        return array_filter($items, fn($item) => $item['group_id'] === $groupId);
    }

    public static function add(string $groupId, string $description, float $amount, string $paidBy, array $splitWith): void
    {
        $items = self::all();
        
        $items[] = [
            'id' => bin2hex(random_bytes(8)),
            'group_id' => $groupId,
            'description' => trim($description),
            'amount' => (float) $amount,
            'paid_by' => $paidBy,
            'split_with' => $splitWith,
            'category' => 'general',
            'created_at' => date('c'),
        ];

        self::save($items);
    }

    public static function delete(string $id): bool
    {
        $items = self::all();
        $found = false;

        foreach ($items as $key => $item) {
            if ($item['id'] === $id) {
                unset($items[$key]);
                $found = true;
                break;
            }
        }

        if ($found) {
            self::save(array_values($items));
        }

        return $found;
    }

    public static function deleteByGroupId(string $groupId): void
    {
        $items = self::all();
        $items = array_filter($items, fn($item) => $item['group_id'] !== $groupId);
        self::save(array_values($items));
    }
}
