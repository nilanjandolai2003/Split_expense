<?php
namespace App\Model;

class Group
{
    private const DATA_FILE = __DIR__ . '/../../data/groups.json';

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

    public static function getById(string $id): ?array
    {
        $items = self::all();
        foreach ($items as $item) {
            if ($item['id'] === $id) {
                return $item;
            }
        }
        return null;
    }

    public static function add(string $name, string $description = ''): string
    {
        $items = self::all();
        $id = bin2hex(random_bytes(8));
        
        $items[] = [
            'id' => $id,
            'name' => trim($name),
            'description' => trim($description),
            'members' => [],
            'created_at' => date('c'),
        ];

        self::save($items);
        return $id;
    }

    public static function addMember(string $groupId, string $memberName): bool
    {
        $items = self::all();
        
        foreach ($items as &$item) {
            if ($item['id'] === $groupId) {
                if (!in_array($memberName, $item['members'])) {
                    $item['members'][] = $memberName;
                }
                self::save($items);
                return true;
            }
        }
        
        return false;
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
            Expense::deleteByGroupId($id);
            self::save(array_values($items));
        }

        return $found;
    }
}
