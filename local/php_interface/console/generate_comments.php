<?php
require_once('/home/bitrix/www/bitrix/header.php');

die(123);
\Bitrix\Main\Loader::includeModule('ameton.comments');
$newsLimits = [
    1 => 100,        // 100 комментариев для первой новости
    2 => 5000,       // 5000 комментариев для второй новости
    3 => 10000,      // 10000 комментариев для третьей новости
    4 => 50000,      // 50000 комментариев для четвертой новости
    5 => 100000      // 100000 комментариев для пятой новости
];

$comments = [];

foreach ($newsLimits as $newsId => $limit) {
    $parentComments = []; // Массив для отслеживания комментариев по уровням

    for ($i = 0; $i < $limit; $i++) {
        $element = [];
        $level = 0;
        $parentId = 0;

        // Определим, будет ли комментарий ответом
        if ($i > 0 && rand(0, 1)) {
            // Ограничим вложенность до 10 уровня
            $level = rand(1, 10);

            // Найдем родительский комментарий из предыдущих уровней
            if (!empty($parentComments[$level - 1])) {
                $parentId = $parentComments[$level - 1][array_rand($parentComments[$level - 1])];
            }
        }

        $element['news_id'] = $newsId;
        $element['author_name'] = 'bot' . $i;
        $element['comment_text'] = \Bitrix\Main\Security\Random::getString(16);
        $element['comment_date'] = new \Bitrix\Main\Type\DateTime();
        $element['reply_count'] = 0;
        $element['comment_path'] = $parentId ? $parentId : 0;
        $element['level'] = $level;
        $element['parent_id'] = $parentId;

        // Сохраним комментарий
        $comments[] = $element;

        // Добавляем комментарий в список родительских комментариев для уровня
        $parentComments[$level][] = $i;

        // Пакетная вставка каждые 1000 комментариев для оптимизации
        if (count($comments) >= 1000) {
            \Ameton\Comments\Orm\CommentsTable::addMulti($comments);
            $comments = []; // очищаем массив
        }
    }
}

// Добавляем оставшиеся комментарии
if (!empty($comments)) {
    \Ameton\Comments\Orm\CommentsTable::addMulti($comments);
}

require_once('/home/bitrix/www/bitrix/footer.php');