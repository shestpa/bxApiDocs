### bxApiDocs призван упростить, не самую сладкую, жизнь Bitrix разработчику.

Это сама по себе папка с модулями /bitrix/modules/  [дистрибутива](http://www.1c-bitrix.ru/download/cms.php#tab-php-link) “Бизнес”, но с убранными лишними файлами и папками (не .php, без классов методов, констант и т.д.), добавленными константами, событиями и хелпами phpDocs.

## Что умеет
Сам по себе ниче не умеет, но содержит несколько крупных вкусностей. Что в комплекте с IDE колоcально облегчает жизнь разработчику (расхолаживает, обленяет и т.д. - так что *будьте осторожны*).
**Фичи:**
- В общем-то само API, с [php Docs](http://ru.wikipedia.org/wiki/PHPDoc)’ами всеми что удалось автоматически вытащить с [ресурса](http://dev.1c-bitrix.ru/api_help/) официальных доков.
- Есть даже константы. Но хелпы есть только у тех что можно найти на вышеприведенном ресурсе оф.доков.
- События модулей. Синтетические классы с набором методов. То есть контейнер с возможными событиями определенного модуля, все также с доками.

Доки с примерами использования и ссылками на [ресурс](http://dev.1c-bitrix.ru/api_help/)  оф.доков.
Константы и события находятся в соответствующих модулях в файлах bx_events.php и bx_constants.php (Например /modules/main/bx_events.php и /modules/main/bx_constants.php).
Соответственно константы употребленные в файлах bx_constants.php, в местах иx реального употребления закомментированы.

## Как использовать
Добавляем в индексацию любимого IDE и все. Счастье!

### Eclipse:
Обязательно PDT (либо аналог).
В окне PHP Explorer правой кнопкой по проекту, пункт выпадающего меню Configure -> Add PHP Support. Снова правой кнопкой по проекту, пункт меню Include Path -> Configure Include Path. В окне либо добавляем во вкладке Libraries добавляем папку modules (кнопка Add External Source Folder). Либо во вкладке Projects добавляем проект modules(кнопка Add). Предварительно нужно создать проект на основе папки modules и добавить ему поддержку PHP (Configure -> Add PHP Support из первого метода). Используя второй метод вы сможете редактировать файлы проекта modules, когда воспользовавшись первым методом файлы-подсказки modules будут read only.

### phpStorm:
File -> Settings -> Project Settings -> PHP
В Include Path добавляем путь к папке modules.




## Брюки превращаются. Брюююки прррревращаются.....

### Основные синглтоны $APPLICATION, $DB, $USER, $USER_FIELD_MANAGER с подсказками
<img style="float:left" src="https://www.monosnap.com/image/dplrjSLmBXtK3A8Rv3nXJIj6g.png" alt="Синглтоны: $APPLICATION"/>
### Максимально полные доки по методам и классам
<img src="https://www.monosnap.com/image/9oRa5bZj9qbLVeNk3R6NYu44u.png" alt="Доки по методам и классам"/>
### Посмотреть события модуля и почитать как его использовать можно так
<img src="https://www.monosnap.com/image/9pIhjhvYbK56RumvtVfoRgDls.png" alt="События модуля с доками"/>
## Константы с доками
<img src="https://www.monosnap.com/image/FbBLw677cEfUrOMcuGOjH9j3H.png" alt="Константы с доками"/>


## Да, согласен
Подсказки есть не на все методы и с ошибками, но и без этого есть многое (то что, повторюсь, удалось спарсить в автоматическом режиме с сайта оф.доков на котором порядка не больше чем в API). К тому же у Вас есть шанс поучавствовать во вселенском добре, закоммитив изменения или дополнения в эту ветку.

## Контакты
+ [https://twitter.com/matiaspub](https://twitter.com/matiaspub)
+ matiaspub@gmail.com
