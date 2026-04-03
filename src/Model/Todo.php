<?php
namespace App\Model;

class Todo
{
    private const DATA_FILE = __DIR__ . '/../../data/todos.json';

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

    public static function add(string $title): void
    {
        $items = self::all();
        $items[] = [
            'id' => bin2hex(random_bytes(8)),
            'title' => trim($title),
            'done' => false,
            'created_at' => date('c'),
        ];

        self::save($items);
    }

    public static function toggle(string $id): bool
    {
        $items = self::all();
        $updated = false;

        foreach ($items as &$item) {
            if ($item['id'] === $id) {
                $item['done'] = !$item['done'];
                $updated = true;
                break;
            }
        }

        if ($updated) {
            self::save($items);
        }

        return $updated;
    }
}
