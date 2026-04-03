<?php
namespace App\Model;

class Message
{
    private const DATA_FILE = __DIR__ . '/../../data/messages.json';

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

    public static function add(string $username, string $text): void
    {
        $items = self::all();
        $items[] = [
            'id' => bin2hex(random_bytes(8)),
            'username' => trim($username),
            'text' => trim($text),
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
}
