<?php

/**
 * Class AwoApi
 *
 * $api = new AwoApi();
 * $api->contact->create(['param' => 'value']);
 * $api->invoice->list(['param' => 'value'])->pagesize(100)->page(2)->orderby('creationDate', 'ASC')->all()
 * $api->invoice->view($id)
 * $api->invoice->update(['id' => 236, 'param' => 'value'])
 *
 */
class AwoApi
{
    /**
     * Параметр просит сервер не падать при ошибке
     * Если установлен в true то при ошибке при добавлении множества сущностей, сервер не падает и продолжает добавлять остальные
     *
     * @var bool
     */
    protected $doNotFallOnError = true;

    protected $apiKeyRead = '';
    protected $apiKeyWrite = '';
    protected $subdomain = '';

    protected $inputData = [];
    protected $inputXml;
    protected $response;
    protected $responseCode;
    protected $errors = [];

    protected $entity;
    protected $params = [];
    protected $search = [];
    protected $queryVars = [];

    public $testEnv = false;

    /**
     * В массиве можно передать apiKeyRead, apiKeyWrite, subdomain
     * @param array $params
     */
    public function __construct($params = [])
    {
        $this->setKeys($params);

        $this->params['pagesize'] = 50;
    }

    /**
     * Контакты
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function contact()
    {
        $this->entity = 'contacts';
        return $this;
    }

    /**
     * Организации
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function organization()
    {
        $this->entity = 'organization';
        return $this;
    }

    /**
     * Сотрудники
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function employee()
    {
        $this->entity = 'employee';
        return $this;
    }

    /**
     * Расходы
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function cost()
    {
        $this->entity = 'costs';
        return $this;
    }

    /**
     * Статьи расходов
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function costCategory()
    {
        $this->entity = 'costsarticle';
        return $this;
    }

    /**
     * Строки счета
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function invoiceLine()
    {
        $this->entity = 'accountline';
        return $this;
    }

    /**
     * Счета
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function invoice()
    {
        $this->entity = 'accounts';
        return $this;
    }

    /**
     * Товары
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function product()
    {
        $this->entity = 'goods';
        return $this;
    }

    /**
     * Категории товаров
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function productCategory()
    {
        $this->entity = 'goodscategory';
        return $this;
    }

    /**
     * Цвета товаров
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function productColor()
    {
        $this->entity = 'goodscolor';
        return $this;
    }

    /**
     * Размеры товаров
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function productSize()
    {
        $this->entity = 'goodssize';
        return $this;
    }

    /**
     * Запросы в Call-центр
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function callcenterRequest()
    {
        $this->entity = 'callcenterrequest';
        return $this;
    }

    /**
     * Группы подписчиков
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function subscriberGroup()
    {
        $this->entity = 'newsletter';
        return $this;
    }

    /**
     * Подписчики
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function subscriber()
    {
        $this->entity = 'contactnewsletterlinks';
        return $this;
    }

    /**
     * Создание подписки
     * Метод устанавливает сущность для работы с апи
     * Данный метод поддерживает только создание подписки
     *
     * @return $this
     */
    public function subscription()
    {
        $this->entity = 'subscription';
        return $this;
    }

    /**
     * Рекламные кампании
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function advertisingCompany()
    {
        $this->entity = 'advertisingchannelcompany';
        return $this;
    }

    /**
     * Каналы рекламы
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function advertisingChannel()
    {
        $this->entity = 'advertisingchannel';
        return $this;
    }

    /**
     * Каналы рекламы - Статистика
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function advertisingChannelStatistics()
    {
        $this->entity = 'advertisingchannelstatistics';
        return $this;
    }

    /**
     * Основные настойки магазина
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function mainSettings()
    {
        $this->entity = 'mainsettings';
        return $this;
    }

    /**
     * Партнеры
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function partner()
    {
        $this->entity = 'partner';
        return $this;
    }

    /**
     * Пин коды к товарам
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function productPinCode()
    {
        $this->entity = 'goodspincodes';
        return $this;
    }

    /**
     * Контакты в автоворнках
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function funnelContact()
    {
        $this->entity = 'funnelcontact';
        return $this;
    }

    /**
     * Рекуррентные платежи
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function recurringPayments()
    {
        $this->entity = 'contactrecurringpayments';
        return $this;
    }

    /**
     * Доступы к курсам
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function trainingAccess()
    {
        $this->entity = 'trainingAccess';
        return $this;
    }

    /**
     * Курсы (тренинги)
     * Метод устанавливает сущность для работы с апи
     *
     * @return $this
     */
    public function training()
    {
        $this->entity = 'training';
        return $this;
    }

    /**
     * Обновляет элемент
     *
     * @param int $id ID элемента, который надо обновить
     * @param array $inputData массив с данными, которые надо обновить в виде название_поля => значение_поля
     * @return array|string массив с полями измененного элемента
     */
    public function update($id, $inputData)
    {
        $inputData['id'] = $id;
        $this->setInputData($inputData);

        return $this->sendRequest('PUT');
    }

    /**
     * Удаляет элемент
     *
     * @param int $id ID элемента, который надо удалить
     * @return string ID удаленного элемнта
     */
    public function delete($id)
    {
        $this->setInputData(['id' => $id]);

        return $this->sendRequest('DELETE');
    }

    /**
     * Достает список элементов по указанным параметрам
     *
     * @param array $searchParams
     * @return array|bool|mixed|string
     */
    public function getAll($searchParams = [])
    {
        if (isset($this->inputData['id'])) {
            unset($this->inputData['id']);
        }
        $this->search = $searchParams;

        return $this->sendRequest('GET');
    }

    /**
     * Достает один элемент по его ID
     *
     * @param int $id
     * @return array|string
     */
    public function get($id)
    {
        $this->setInputData(['id' => $id]);

        return $this->sendRequest('GET');
    }

    /**
     * Создает новый элемент с указанными полями
     *
     * @param array $inputData
     * @return array|string массив со всеми полями нового элемнта
     */
    public function create($inputData)
    {
        $this->setInputData($inputData);
        $this->setInputXml();

        return $this->sendRequest('POST');
    }

    /**
     * Устанавливает параметры сортировки
     *
     * @param array $sort массив с данными сортировки, в формате $field => $direction (ASC, DESC)
     * @return $this
     */
    public function orderBy($sort = [])
    {
        $orderby = [];
        foreach ($sort as $field => $direction) {
            $orderby[] = "{$field} {$direction}";
        }

        $this->params['sort'] = implode(', ', $orderby);

        return $this;
    }

    /**
     * Количество элементов на страницу (или сколько элементов получить)
     * Максимум - 1000.
     *
     * @param int $pageSize
     * @return $this
     */
    public function pageSize($pageSize)
    {
        $this->params['pagesize'] = $pageSize;

        return $this;
    }

    /**
     * Устанваливает, на какой странице сейчас находимся.
     * К примеру, если pageSize указан 10, страница указана 3, будут показаны элемнеты начиная с 31 до 40
     *
     * @param int $page
     * @return $this
     */
    public function page($page)
    {
        // в апи первая страница - это ноль. чтобы не путать пользователей, вычитаем 1
        $this->params['currentpage'] = $page - 1;

        return $this;
    }

    /**
     * @return array массив с ошибками
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return string неразобраный ответ сервера
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * сеттер для ключей и поддомена
     *
     * @param $keys
     */
    public function setKeys($keys) {
        if (!empty($keys['apiKeyRead'])) {
            $this->apiKeyRead = $keys['apiKeyRead'];
        }
        if (!empty($keys['apiKeyWrite'])) {
            $this->apiKeyWrite = $keys['apiKeyWrite'];
        }
        if (!empty($keys['subdomain'])) {
            $this->subdomain = $keys['subdomain'];
        }
    }

    /**
     * Конвертирует массив с данными в XML
     * Этот формат используется при добавлении сущностей
     */
    protected function setInputXml()
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= '<root>';
        foreach ($this->inputData as $item) {
            $xml .= "<item>";

            $xml .= $this->arrayToXml($item);

            $xml .= "</item>";
        }

        $xml .= '</root>';

        $this->inputXml = $xml;
    }

    /**
     * Конвертируем массив в xml
     * @param $value
     * @return string
     */
    protected function arrayToXml($value)
    {
        if (is_array($value)) {
            $xml = '';

            foreach ($value as $key => $item) {
                if (is_numeric($key)) {
                    $key = 'item';
                }

                // рекурсия
                $xml .= "<{$key}>" . $this->arrayToXml($item) . "</{$key}>";
            }

            return $xml;
        }

        return $value;
    }

    /**
     * Устанавливает данные для запроса
     * В будущем возможно будет проводить некоторые проверки валидности
     *
     * @param $data
     */
    protected function setInputData($data)
    {
        if (!is_array($data)) {
            $this->inputData = [];
        }

        $this->inputData = $data;
    }

    /**
     * Подготовка массива данных для запроса на сервер
     *
     * @param $requestType
     */
    protected function prepareQueryVars($requestType) {
        $key = $requestType == 'GET' ? $this->apiKeyRead : $this->apiKeyWrite;

        $queryVars = [
            'key' => $key,
        ];

        if ($this->doNotFallOnError) {
            $queryVars['donotfallonerror'] = 1;
        }

        if ($requestType == 'GET' AND empty($this->inputData['id'])) {
            // при GET запросе, если не указан ID, надо добавить параметры сортировки и поиска
            $queryVars['param'] = $this->params;
            $queryVars['search'] = $this->search;
        }

        if ($requestType != 'POST') {
            $queryVars = array_merge($queryVars, $this->inputData);
        }

        $this->queryVars = $queryVars;
    }

    /**
     * отправка запроса на сервер
     *
     * @param $type
     * @return array|bool|mixed|null|string
     */
    protected function sendRequest($type)
    {
        if (!$this->entity) {
            return 'Please set entity to work with';
        }

        $this->prepareQueryVars($type);

        $curl = curl_init();

        if ($type == 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS,  $this->inputXml);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Content-type: text/xml;charset="utf-8"',
                'Cache-Control: no-cache',
                'Pragma: no-cache',
            ]);
        } else {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type);
        }

        $domain = 'autoweboffice.ru';

        $url = "https://{$this->subdomain}.{$domain}/?r=api/rest/{$this->entity}&".http_build_query($this->queryVars);
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_VERBOSE, false);

        $this->response = curl_exec($curl);

        $this->responseCode = (int)curl_getinfo($curl, CURLINFO_HTTP_CODE); // HTTP-код ответа сервера

        return $this->decodeResponse();
    }

    /**
     * Пытаемся рзобрать ответ сервера
     *
     * @return array|bool|mixed|string
     */
    protected function decodeResponse()
    {
        $responseOriginal = $this->response;

        // апи может выдать джейсон. пробуем декодировать
        $responseDecoded = json_decode($responseOriginal);

        if (!$responseDecoded) {
            // апи выдает несколько джейсонов подряд, если добавляет несколько сущностей скопом. пробуем декодировать.

            // сначала убираем скобки в начале и конце строки
            $response = substr($responseOriginal, 1);
            $response = substr($response, 0, -1);

            // разбиваем строку
            $jsonsArray = explode('}{', $response);

            // пробуем декодировать элементы получившегося массива
            $responseDecoded = array_map(function ($item) {
                $decoded = json_decode('{' . $item . '}');
                if ($decoded){
                    return $decoded;
                }

                return null;
            }, $jsonsArray);

            // убираем пустые элементы
            $responseDecoded = array_filter($responseDecoded, function ($val) {
                return $val;
            });
        }

        // если что-то удалось декодировать - возвращаем это
        if ($responseDecoded) {
            return $responseDecoded;
        }

        // не получилось декодировать, возвращаем как есть
        return $responseOriginal;
    }

    /**
     * Коды ошибок с описаниями
     *
     * @return array
     */
    protected function responseCodes()
    {
        return [
            200 => 'OK',
            301 => 'Moved permanently',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];
    }
}
