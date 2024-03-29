Класс упрощает работу с апи [сервиса АвтоВебОфис](https://autoweboffice.com/ "АвтоВебОфис")

+ [Как этим пользоваться](#How);
+ [Доступные сущности](#Model);
+ [Доступные методы](#Method); 
+ [Примеры использования класса API](#Examples); 

# <a name="How"></a> Как этим пользоваться:

#### 1. Создаем объект 

```
$api = new AwoApi();

$api->setKeys([
    'apiKeyRead' => '',  // API KEY GET
    'apiKeyWrite' => '', // API KEY SET
    'subdomain' => 'mastergroup'
]);
```
или

```
$api = new AwoApi([
    'apiKeyRead' => '', // API KEY GET
    'apiKeyWrite' => '', // API KEY SET
    'subdomain' => 'mastergroup'
]);
```

#### 2. Устанвавливаем сущность для работы, например контакты

```
$api->contact();
```

#### 3. Используем нужный метод для работы с данными

```
$response = $api->get(2);
``` 

**Методы можно писать "цепочкой", например**

```
// получаем данные контакта с ID = 2
$contact = $api->contact()->get(2);

// получаем список контактов, у которых есть партнер, элементы с 101 по 200, 
// отсортированные по партнеру
$items = $api->contact()
    ->pageSize(100)
    ->page(2)
    ->orderBy([
        'id_partner' => 'ASC', 
    ])
    ->getAll([
        'hasPartner' => -1
    ]);
```

# <a name="Model"></a> Доступные сущности:

Для каждой сущности существует свой метод. Это позволяет использовать автодополнение в вашей IDE.

- `contact()` - Контакты
- `organization()` - Организации
- `employee()` - Сотрудники
- `cost()` - Расходы
- `costCategory()` - Статьи расходов
- `invoiceLine()` - Строки счета
- `invoice()` - Счета
- `product()` - Товары
- `productCategory()` - Категории товаров
- `productColor()` - Цвета товаров
- `productSize()` - Размеры товаров
- `callcenterRequest()` - Запросы в Call-центр
- `subscriberGroup()` - Группы подписчиков
- `subscriber()` - Подписчики
- `subscription()` - Подписки (только создание)
- `mainSettings()` - Основные настойки магазина
- `partner()` - Партнеры
- `productPinCode()` - Пин коды к товарам
- `funnelContact()` - Контакты в автоворонках
- `trainingAccess()` - Доступ к курсам и урокам 
- `telegramBotSubscriber()` - Подписчики на телеграм бота
- `contactTagLnk()` - Присвоенные контакту метки

# <a name="Method"></a> Доступные методы:

+ [create(array $inputData) - Добавление](#Create);
+ [update($id, $inputData) - Изменение](#Update);
+ [delete($id) - Удаление](#Delete); 
+ [get($id), getAll($searchParams = []) - Методы получения данных](#Get);

## <a name="Create"></a> create(array $inputData) - Добавление ##

Создает новую сущность (или несколько сущностей). Ожидает получить массив с данными объектов (массив массивов). Даже при добавлении одной новой сущности требуется обернуть ее в отдельный массив.

```
// Создание нескольких контактов
$response = $api->contact()->create([
    [
        'fieldName' => 'fieldValue',
    ],
    [
        'fieldName' => 'fieldValue',
    ],
    ...
 ]);
 
// Создание одного контакта
$response = $api->contact()->create([
    [
        'fieldName' => 'fieldValue',
    ],
 ]);
 ```
 
 Возвращает массив с данными созданных сущностей
 
  ```
 array(3) {
   [0]=>
   object(stdClass)#3 (64) {
     ["id_contact"]=>
     string(5) "66018"
     ...
   }
   [1]=>
   object(stdClass)#4 (64) {
     ["id_contact"]=>
     string(5) "66019"
     ...
   }
   [2]=>
   object(stdClass)#5 (64) {
     ["id_contact"]=>
     string(5) "66020"
     ...
   }
 }
 ```
 
Если в каком-либо добавляемом элементе обнаруживается ошибка (например, неверные параметры), вместо объекта добавленного элемента будет объект с ошибками следующего вида:

```
object(stdClass)#4 (2) {
  ["error"]=>
  string(71) "Email не является правильным E-Mail адресом."
  ["inputData"]=>
  object(stdClass)#5 (2) {
    ["name"]=>
    string(12) "Ильнур"
    ["email"]=>
    string(17) "fx5559_1552998894"
  }
}
```

Поле error содержит текстовое описание ошибки, поле inputData содержит данные, которые были переданы на сервер.

Ниже представлен пример ответа сервера на добавление 3-х элементов, второй из которых содержит неверные данные
 
```
array(3) {
  [0]=>
  object(stdClass)#3 (64) {
    ["id_contact"]=>
    string(5) "66024"
    ...
  }
  [1]=>
  object(stdClass)#4 (2) {
    ["error"]=>
    string(71) "Email не является правильным E-Mail адресом."
    ["inputData"]=>
    object(stdClass)#5 (2) {
      ["name"]=>
      string(12) "Ильнур"
      ["email"]=>
      string(17) "странный текст, не похожий на email"
    }
  }
  [2]=>
  object(stdClass)#6 (64) {
    ["id_contact"]=>
    string(5) "66025"
    ...
  }
}
```
 
Если параметр `AwoApi::doNotFallOnError` установить в `false` (по умолчанию `true`) - поведение становится немного другим (обычно api ведет себя именно таким образом, это поведение оставлено для совместимости со старым кодом):

Если какие-то параметры неверные, то в ответе сервер выдаст ошибку в виде текста. При этом, если вы добавляете множество сущностей за раз (к примеру 1000), и у вас 500-ый элемент содержит неверные данные, то 499 будут добавлены, на 500-ом сервер выдаст ошибку в виде текста и дальше добавление уже не продолжится. 

В случае ошибок валидации, когда например у вас email явно некорректный, вместо строки сервер возвращает массив с ошибкой.

```
array(1) {
  [0]=>
  string(71) "Email не является правильным E-Mail адресом."
}
``` 
 
## <a name="Update"></a> update($id, $inputData) - Изменение ##

Обновление (изменение) сущности. Первый агрумент - уникальный ID сущности, второй - массив с новыми данными в виде `"название поля" => "значение поля"`

```
// обновляем контакт с ID 65711
$response = $api->contact()->update(65711, [
    'name' => 'Рон',
    'last_name' => 'Матусалем',
    'email' => 'ron.matusalem@hotmail.com'
])
```

Возвращает объект с новыми данными.

```
object(stdClass)#2 (64) {
  ["id_contact"]=>
  string(5) "65711"
  ...
}
``` 

Или массив с ошибками, если сохранить не удалось

```
array(1) {
  [0]=>
  string(71) "Email не является правильным E-Mail адресом."
}
```
 
 Или текст ошибки, если, к примеру, ID неверный
 
 ```
 string(67) "Error: Didn't find any model contacts with ID 865711."
 ```
 
## <a name="Delete"></a> delete($id) - Удаление ##
 
 Удаляет элемент (для некоторых сущностей - помещает в корзину). Принимает один аргумент - уникальный ID сущности. Возвращает этот же ID в случае успеха или текст ошибки. При попытке удаления уже удаленного эелемента сервер также вернет его ID.
 
 ```
 // удаляем контакт с ID 255
 $response = $api->contact()->delete(255)
 ```  
 
## <a name="Get"></a> get($id), getAll($searchParams = []) - Методы получения данных ##
 
 **get($id)**
 
 Получает данные одного элемента по его ID. Возвращает объект с данными этого эелемента или текст ошибки в случае если получить данные элемента не удалось.
 
 ```
 $response = $api->product()->get(1279)
 ```
 
 **getAll($searchParams = [])**
 
 Получает массив элементов. Если указаны параметры поиска - возвращает только элементы - соответствующие заданным критериям.
 
 ```
 // получаем список товаров, в названии которых встречается "курс"
 $prods = $api
     ->product()
     ->getAll([
         'goods' => 'курс',
     ]);
 ```
 
 Если ничего не найдено - в ответе будет текст (а не пустой массив, как можно ожидать)
 
 ```
 string(38) "No items where found for model "
 ```

**orderBy($sort = [])**

Сортировка получаемых элементов. Единственный аргумент - массив, в котором указываются поля для сортировки и порядок (ASC или DESC). Обратите внимание на правильность названий полей, если в них будут опечатки, сервер выдаст ошибку 500. Также стоит отметить что сортировка иногда вызывает ошибки, если используются связанные таблицы для фильтрации.

```
// сортируем сначала по дате создания, потом по названию
$prods = $api
    ->orderBy([
        'creation_date' => 'DESC', 
        'goods' => 'ASC'
    ]);
``` 

**pageSize($pageSize)**

Устанавливает количество получаемых элементов (размер страницы). Принимает целое число от 1 до 1000. По умолчанию 50.

**page($page)**

Устанавливает страницу. Если результатов больше, чем установленный pageSize, то оставшиеся результаты можно получить через установку этого параметра. Номера страниц начинаются с 1 (если обращатся к апи напрямую, а не через этот класс, то первая страница 0).

# <a name="Examples"></a> Примеры использования класса API

В папке examples есть примеры кодов для большинства сценариев работы с АПИ

- `subscribe.php` - Подписка контакта на группу подписчиков
- `changeGroup.php` - Перенос подписчика из одной группы в другую
- `checkPurchase.php` - Проверка покупки (покупал ли контакт, указанный товар)
- `checkSubscription.php` - Проверка подписки
- `getPaymentLink.php` - Получение ссылки на оплату счета
- `getSubscribers.php` - Получаем всех подписчиков групп(ы) подписчиков
- `order.php` - Оформление заказа (Создание нового счета)
- `payOrder.php` - Изменение статуса счета на "оплачен"

# <a name="EntityDetails"></a> Подробное описание параметров некоторых сущностей

#### trainingAccess - доступ к курсу и урокам

При создании и редактровании, кроме самого доступа к курсу, можно указать список уроков, которым требуется предоставить доступ в свойстве ```arrIdTrainingLesson```.

Пример данных для запроса:

    $result = $api->trainingAccess()->create([
         [
             'id_training' => 12,
             'id_contact' => 125967,
             'creation_date' => '2020-08-10 10:00:00',
             'date_of_end_training' => '2020-09-20 10:00:00',
             'date_of_end_check_report' => '0000-00-00 00:00:00',
             'arrIdTrainingLesson' => [86,87,88]
         ]
     ]);

Обратите внимание, принадлежность указанных уроков к указанному курсу не проверяется. Если указать id уроков из другого курса, то доступ к ним не будет выдан, и api не выдаст вам никакой ошибки.

Для редактирования доступа к курсу вместо свойства ```arrIdTrainingLesson``` используется свойство ```arrAvailableLessonData```. Здесь в дополнение к id урока можно указать доступность (ключ ```accessible```). Это значит, что пользователь сможет посмотреть урок, даже если у него не наступил день доступа, не пройдены предыдущие уроки, не отправлены отчеты и т.д.

Пример данных для запроса:

    $result = $api->trainingAccess()->update(203863, [
        'creation_date' => '2020-08-15 10:00:00',
        'date_of_end_training' => '2020-12-20 22:00:00',
        'date_of_end_check_report' => '0000-00-00 00:00:00',
        'arrAvailableLessonData' => [
            [
                'id' => 86,
                'accessible' => 0,
            ],
            [
                'id' => 87,
                'accessible' => 0,
            ],
            [
                'id' => 88,
                'accessible' => 1,
            ],
        ]
    ]);
     
 ####Приостановка доступа к курсу.
 Если вы хотите приостановить доступ к курсу для ученика, нужно передать параметр ```freezed = 1```. Если доступ к курсу уже приостановлен - ничего не произойдет. 
 
 **Пример запроса для приостановки доступа**
 
    $result = $api->trainingAccess()->update(203863, [
        'freezed' => 1,
    ]);
 
 Для возобновления доступа к курсу нужно передать параметр ```freezed = 0```. Если доступ не приостановлен - то ничего не произойдет. Также можно передать необязательный параметр ```shift_access_days = 1```. Если он передан - дни доступа к урокам будут сдвинуты на время, которое доступ к курсу был приостановлен. Это имеет значение лишь для тех курсов, у которых есть уроки с указанными днями доступа. 
    
**Пример запроса для возобновления доступа**

    $result = $api->trainingAccess()->update(203863, [
        'freezed' => 0,
        'shift_access_days' => 0,
    ]);