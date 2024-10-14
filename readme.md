# Комментарий к выполненному
## Удалось
### Потрачено 2,5 часа
+ Описать ORM сущность для денормализованного хранения комментариев
+ Упакована в модуль
+ Сконфигурировать сайт для работы через routing_index.php
+ Написать комплексный компонент новостей для удобного просмотра комментариев
+ Сгенерировать комментарии

## Не успел, но какими были бы дальнешие шаги
### 8 часов на верстку и создание экшенов
+ Сделать вывод в шаблон компонента ameton.comments комментариев первого и второго уровней через верстку с пагинацией
+ Аякс экшн для подгрузки дочерних комментариев по полю comment_path (обеспечит самый быстрый поиск)
+ Создать индексы для полей comment_path

## Обоснование использования comment_path вместо parent_id

+ Уменьшение нагрузки на клиенсткую часть в вопросе поиска родительского комментария по коду верстки
+ Денормализованная структура хотя и увеличивает нагрузка на занимаемый объем хранилища базой данных, обеспечивает при этом быструю работу фильтра при запросах к БД
