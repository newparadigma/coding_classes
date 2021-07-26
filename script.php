<?php
// xml лежит в той же папке что и скрипт
// /home/user/projects/zoo.xml
// /home/user/projects/code_school/script.php

// 1. Вывести таблицу с информациями о зоопарках.
// Город - Владелец - Вид - Суммарное количество - Часы работы
// 2. Вывести 2 зоопарка в которых больше всего животных и вывести их виды.
// 3. Вывести зоопарки которые можно посещать в среду после 17 часов.
// 4. Вывести 2 зоопарка с самым большим количеством видов животных перечислить их и их количество.
// 5. Экспортировать это всё в excel


define('PATH', './zoo.xml');
if (file_exists(PATH)) {
  $xml_object = simplexml_load_file(PATH);
  foreach ($xml_object->ZOO as $zoo_data) {
    $owner = $zoo_data->OWNER;
    $city = $zoo_data->CITY;
    $open_hours = [
      'Понедельник' => (string)$zoo_data->OPEN_HOURS->MONDAY,
      'Вторник' => (string)$zoo_data->OPEN_HOURS->TUESDAY,
      'Среда' => (string)$zoo_data->OPEN_HOURS->WEDNESDAY,
      'Четверг' => (string)$zoo_data->OPEN_HOURS->THURSDAY,
      'Пятница' => (string)$zoo_data->OPEN_HOURS->FRIDAY,
      'Суббота' => (string)$zoo_data->OPEN_HOURS->SATURDAY,
      'Воскресенье' => (string)$zoo_data->OPEN_HOURS->SUNDAY
    ];
    $animals = [];
    foreach ($zoo_data->ANIMAL as $animal) {
      $superorder = (string)$animal->SUPERORDER;
      $count = $animal->MALES + $animal->FEMALES;
      $animals[$superorder] = $count;
    }
    show_all_zoo_info($owner, $city, $animals, $open_hours);
  }
} else {
  throw new \Exception('Не удалось найти файл - ' . PATH . "\n", 1);
}

function show_all_zoo_info($owner, $city, $animals, $open_hours) {
  print("Зоопарк:\n");
  print("  Город: $city\n");
  print("  Владелец: $owner\n");
  print("  Часы работы:\n");
  foreach ($open_hours as $day_of_week => $work_hours) {
    if ($work_hours == '') {
      $work_hours = 'Выходной';
    }
    print("    $day_of_week: $work_hours\n");
  }
  print("  Животные:\n");
  foreach ($animals as $superorder => $count) {
    print("    $superorder: $count особей\n");
  }
  print("\n");
}



// Зоопарк:
//   Город: Москва
//   Владелец: Ашот
//   Часы работы:
//     Понедельник: 10 - 17
//     ...
//   Животные:
//     Обезьяна: 10 особей
//     ...


// [0] => SimpleXMLElement Object
//     (
//         [OWNER] => Альберт Энштейн
//         [CODE] => 331
//         [CITY] => Москва
//         [OPEN_HOURS] => SimpleXMLElement Object
//             (
//                 [MONDAY] => 9 - 16
//                 [TUESDAY] => 9 - 16
//                 [WEDNESDAY] => 9 - 16
//                 [THURSDAY] => 9 - 16
//                 [FRIDAY] => 9 - 20
//                 [SATURDAY] => 9 - 14
//                 [SUNDAY] => SimpleXMLElement Object
//                     (
//                     )
//
//             )
//
//         [ANIMAL] => Array
//             (
//                 [0] => SimpleXMLElement Object
//                     (
//                         [SUPERORDER] => Жираф
//                         [MALES] => 5
//                         [FEMALES] => 5
//                     )
//
//                 [1] => SimpleXMLElement Object
//                     (
//                         [SUPERORDER] => Гепард
//                         [MALES] => 3
//                         [FEMALES] => 2
//                     )
//
//                 [2] => SimpleXMLElement Object
//                     (
//                         [SUPERORDER] => Хомяк
//                         [MALES] => 1
//                         [FEMALES] => 344
//                     )
//
//                 [3] => SimpleXMLElement Object
//                     (
//                         [SUPERORDER] => Лев
//                         [MALES] => 1
//                         [FEMALES] => SimpleXMLElement Object
//                             (
//                             )
//
//                     )
//
//             )
//
//     )


// / = C:/zoo.xml
exit;
// вывести сколько всего позиций обработал каждый продавец
// вывести имя продавца у которого было больше всего позицй в 1 чеке/
// вывести заработок точки по датам

// define('PATH', './xml.xml');
// 1 нам нужен список продавцов
// 2 перебирая транзакции мы должны присвоить продавцам их позиции
// 3
//
// [
//   имя => колво позиций
// ]
//
// 1 проверить наличие файла
// 2 вытащить данные из файла
// 3 сырые данные необходимо обработать -> обработанные данные
// 4 оперируем
// 5.1 вытащить всех продавцов
// 5.2 вытащить суммарное количесво всех позиций продавцов
// 5.3 соотнести эти данные

$persons = [];
$person_with_bigger_sku_count_in_one_transaction;
$sku_count_in_current_transaction = 0;
$best_person;
$summ_by_date = [];


if (file_exists(PATH)) {
  $xml_object = simplexml_load_file(PATH);
  foreach ($xml_object->TRANSACTION as $transaction) {
    $person = (string)$transaction->PERSON;
    $sku_count = count($transaction->SKU);

    if ($sku_count_in_current_transaction < $sku_count) {
      $sku_count_in_current_transaction = $sku_count;
      $best_person = $person;
    }

    if (!isset($persons[$person])) {
      $persons[$person] = $sku_count;
    } else {
      $persons[$person] += $sku_count;
    }

    $date = (string)$transaction->DATE;
    $total_summ = 0;
    foreach ($transaction->SKU as $sku) {
      $summ = (int)$sku->SUMM;
      $total_summ += $summ;
    }

    $proccessed_date = mb_substr($date, 0, 10);
    $proccessed_date = date_create_from_format('Y-m-d', $proccessed_date);
    $proccessed_date = date_format($proccessed_date, 'd.m.Y');

    if (!isset($summ_by_date[$proccessed_date])) {
      $summ_by_date[$proccessed_date] = $total_summ;
    } else {
      $summ_by_date[$proccessed_date] += $total_summ;
    }
  }
  print_skus_count_per_person($persons);
  print("\nЛучший продавец месяца - $best_person\n");
  print_summ_per_date($summ_by_date);
} else {
  throw new \Exception('Не удалось найти файл - ' . PATH . "\n", 1);
}

function print_skus_count_per_person($persons)
{
  print("Продавец: Количество\n");
  foreach ($persons as $person => $sku_count) {
    print("$person: $sku_count\n");
  }
}

function print_summ_per_date($summ_by_date) {
  print("\nДата: Сумма в рублях\n");
  foreach ($summ_by_date as $date => $summ) {
    print("$date: $summ\n");
  }
}

 ?>
