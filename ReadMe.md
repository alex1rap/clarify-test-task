# Тестовое задание #1 на Junior PHP

**Условие:**
Есть некая условно компания “ZOO”, которая в данный момент работает с двумя перевозчиками:

- TransCompany
- PackGroup

У каждого перевозчика всегда своя формула расчета стоимости доставки посылки (для простоты все цены будут всегда в EUR):

- TransCompany до 10 кг берет 20 EUR, все что свыше 10 кг - 100 EUR
- PackGroup за каждый 1 кг берет 1 EUR
- в будущем будут добавляться другие новые перевозчики со своей формулой расчета (это нужно учесть).

**Задача:**
Необходимо описать ООП архитектуру на PHP из методов, классов, модулей, апи-контроллеров и т.д. для работы с
перевозчиками на предмет получения стоимости доставки по каждому из указанных перевозчиков, согласно их формулам. При
разработке нужно учесть, что количество перевозчиков со временем может возрасти. И у новых добавленных перевозчиков
формулы расчета стоимости будут другими. Подсказка для реализации: наследование, абстрактные классы, класс-сервис для
расчета стоимости, который будет принимать класс транспортной службы и входные данные от клиента (в данном случаи массу
посылки) и т.д.

**Ожидаемый результат:**
На фронте web страничка с простыми полями ввода: массы посылки, селект поле с выбором slug (или ID, не важно)
перевозчика и кнопкой “calculate price”.
На бекенде - API контроллер, который будет принимать массу посылки и slug (или ID, не важно) перевозчика и в ответ
отдавать расчитаную стоимость в EUR.

**Требования:**
Задание нужно сделать на php фреймворке Symfony, так как в будущему сотруднику у нас предстоит работать с ним на бекенде
и немного с фронтенд фреймворком Vue.js (бекенд сопровождает простенькую админку на Vue.js. Нам важно понимать Ваше
знание или отсутствие знания Vue.js), то желательно использовать для отрисовки полей ввода Vue.js (без фанатизма, все
простенько), а для бекенд части – Symfony. Также нужно будет работать с системой контейнеризации Docker. Поэтому в
идеале всю реализацию завернуть в Docker, т.е. создать ngnix-контейнер, php-контейнер, ui-контейнер и все это
соркестрировать через docker-compose.yml . PHPunit тесты приветсвуются, так как в будущей работе их также сотруднику
придется писать.

---

**Тестовое задание #2 на Junior PHP**

**№1**

**Условие:**
Дан текст с включенными в него тегами:

```text
[tag_name description="описание"]данные, данные,...[/tag_name]
```

**Пример текста:**

```text
Lorem Ipsum is simply [tag1 description="Some value"]dummy text[/tag1] of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the [tag2]1500s[/tag2], when an unknown printer took...
```

Имена тегов могут быть произвольными, текст также может быть произвольным. Главное это структура тега.
Вложенность тегов не допускается.
Описания , т.е. самого аттрибута description=”” может и не быть.
Обязателен закрывающий тег.

**Задача:**
На выходе нужно получить 2 массива:

- Первый массив:
    - Ключ элемента массива - наименование тега
    - Значение – данные, т.е. текст, который это тег оборачивает
    - Для приведенного текста: ['tag1' => 'dummy text', 'tag2' => '1500s']
- Второй массив:
    - Ключ элемента массива - наименование тега
    - Значение – описание тега, т.е то, что внутри аттрибута description
    - Для приведенного текста: ['tag1' => 'Some value']

**№2**

**Условие:**
Дан текст в котором включены ключи (one: | two: | three:) текст может располагаться как перед ключами так и после них.
Пример текста:

```text

Lorem Ipsum is simply one: dummy text of the printing and two: typesetting industry. Lorem Ipsum has been the industry's
one: standard dummy text ever since the three: 1500s.

```

**Задача:**
На выходе нужно получить массив, где ключ это one, two, three, а ДАННЫЕ - текст располагающийся после ключа до
следующего ключа или до конца текста, если не встретился ключ.
Очередность ключей может быть произвольная. Если в тексте ключ встречается второй раз, то в итоговом массиве значение
элемента массива с этим ключем должно быть перезаписано.

**Требования:**
Задание нужно сделать на php фреймворке Symfony, так как в будущему сотруднику у нас предстоить работать с ним на
бекенде и немного с фронтенд фреймворком Vue.js (бекенд сопровождает простенькую админку на Vue.js, поэтому Нам важно
понимать Ваше знание или отсутствие знания Vue.js), то желательно использовать для отрисовки полей ввода Vue.js (без
фанатизма, все простенько), а для бекенд части – Symfony. Также нужно будет работать с системой контейнеризации Docker.
PHPunit тесты приветсвуются, так как в будущей работе их также сотруднику прийдется писать.

# Решение

## Установка

```bash
git clone git@github.com:alex1rap/clarify-test-task.git
cd clarify-test-task
docker-compose up -d
```

## В браузере

- [http://127.0.0.1.nip.io](http://127.0.0.1.nip.io) - Frontend с админкой

## Описание варианта решения первой задачи:

### Стратегия:

В принципе, можно было использовать паттерн "Стратегия", разбив функционал подсчета стоимости доставки на отдельные
классы для каждого перевозчика для подсчета стоимости доставки, исходя из собственной формулы.

Тогда структура была бы следующей:

- `App\Service\Carrier\CarrierInterface` - интерфейс для всех перевозчиков с обязательным
  методом `calculateCost(float $weight): float`
- `App\Service\Carrier\TransCompany` - класс для перевозчика TransCompany, который реализовывает
  интерфейс `CarrierInterface`, подсчитывая стоимость доставки по своей формуле, в данном случае было бы так:

```php
public function calculateCost(float $weight): float
{
    return $weight <= 10 ? 20 : 100;
}
```

- `App\Service\Carrier\PackGroup` - класс для перевозчика PackGroup, который реализовывает интерфейс `CarrierInterface`,
  подсчитывая стоимость доставки по своей формуле, в данном случае было бы так:

```php
public function calculateCost(float $weight): float
{
    return $weight;
}
```

- `App\Service\Carrier\CarrierService` - класс для подсчета стоимости доставки, который принимает объект перевозчика и
  вес посылки, и возвращает стоимость доставки
- `App\Factory\CarrierServiceFactory` - фабрика для создания объектов `CarrierService`, в зависимости от переданного
  перевозчика
- `App\Controller\CarrierServiceController` - контроллер для обработки запросов, принимающий вес посылки и перевозчика,
  и возвращающий стоимость доставки, используя `CarrierService`

Но в данном случае я решил добавить возможность изменять формулы и условия без изменения кода, храня их в базе данных,
поэтому код получился сложнее, но теперь не придется ничего хардкодить, добавляя новых перевозчиков.

На фронте реализована [админка](http://127.0.0.1.nip.io/admin), где можно добавлять, редактировать и удалять
перевозчиков, а также их формулы.

Для парсинга тегов и ключей из текста нужно перейти на [Text Parser](http://127.0.0.1.nip.io/text-management), где можно
ввести текст, выбрать тип парсера (теги или ключи) и нажать кнопку "Parse", получив результат ниже между тегами `<pre>`
и `</pre>`.
