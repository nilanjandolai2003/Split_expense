<?php
namespace App\Model;

class Quiz
{
    private const DATA_FILE = __DIR__ . '/../../data/quizzes.json';

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

    public static function add(string $title, string $paragraph): void
    {
        $items = self::all();
        $questions = self::generateMCQs($paragraph);
        
        $items[] = [
            'id' => bin2hex(random_bytes(8)),
            'title' => trim($title),
            'paragraph' => trim($paragraph),
            'questions' => $questions,
            'created_at' => date('c'),
            'attempts' => [],
        ];

        self::save($items);
    }

    public static function generateMCQs(string $paragraph): array
    {
        $sentences = preg_split('/[.!?]+/', $paragraph, -1, PREG_SPLIT_NO_EMPTY);
        $sentences = array_map('trim', $sentences);
        
        $questions = [];
        
        foreach ($sentences as $index => $sentence) {
            if (strlen($sentence) < 20) continue;
            
            $words = preg_split('/\s+/', $sentence);
            if (count($words) < 5) continue;
            
            // Create a fill-in-the-blank question
            $randomWordIndex = rand(2, count($words) - 2);
            $correctAnswer = $words[$randomWordIndex];
            
            $questionText = implode(' ', $words);
            $questionText = str_replace($correctAnswer, '______', $questionText);
            
            // Generate wrong answers
            $wrongAnswers = self::generateWrongAnswers($correctAnswer, $sentences, $sentence);
            $options = [$correctAnswer, ...$wrongAnswers];
            shuffle($options);
            
            $questions[] = [
                'id' => bin2hex(random_bytes(4)),
                'question' => $questionText,
                'options' => array_slice($options, 0, 4),
                'correctAnswer' => $correctAnswer,
                'originalSentence' => $sentence,
            ];
            
            if (count($questions) >= 5) break;
        }
        
        return $questions;
    }

    private static function generateWrongAnswers(string $correct, array $allSentences, string $currentSentence): array
    {
        $wrongAnswers = [];
        $words = [];
        
        foreach ($allSentences as $sentence) {
            if ($sentence !== $currentSentence) {
                $sentenceWords = preg_split('/\s+/', $sentence);
                $words = array_merge($words, $sentenceWords);
            }
        }
        
        $words = array_filter($words, function($word) use ($correct) {
            $cleanWord = strtolower(preg_replace('/[^a-z0-9]/i', '', $word));
            $cleanCorrect = strtolower(preg_replace('/[^a-z0-9]/i', '', $correct));
            return $cleanWord !== $cleanCorrect && strlen($word) > 2;
        });
        
        $words = array_values(array_unique($words));
        shuffle($words);
        
        return array_slice($words, 0, 3);
    }

    public static function recordAttempt(string $quizId, array $answers): array
    {
        $items = self::all();
        $quiz = null;
        $quizIndex = -1;
        
        foreach ($items as $key => $item) {
            if ($item['id'] === $quizId) {
                $quiz = $item;
                $quizIndex = $key;
                break;
            }
        }
        
        if (!$quiz) {
            return ['score' => 0, 'total' => 0, 'percentage' => 0];
        }
        
        $score = 0;
        $total = count($quiz['questions']);
        
        foreach ($quiz['questions'] as $question) {
            $userAnswer = $answers[$question['id']] ?? null;
            if ($userAnswer === $question['correctAnswer']) {
                $score++;
            }
        }
        
        $percentage = $total > 0 ? round(($score / $total) * 100) : 0;
        
        $attempt = [
            'timestamp' => date('c'),
            'score' => $score,
            'total' => $total,
            'percentage' => $percentage,
            'answers' => $answers,
        ];
        
        if (!isset($items[$quizIndex]['attempts'])) {
            $items[$quizIndex]['attempts'] = [];
        }
        
        $items[$quizIndex]['attempts'][] = $attempt;
        self::save($items);
        
        return $attempt;
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
