<?php
require_once("data_to_xml.php");
$zoos = [];
$xml = '<?xml version="1.0"?><ZOOS>';
foreach ($zoos_general_info as $code => $info) {
  $xml .= "<OWNER>{$info['owner']}</OWNER>";
  $xml .= "<CODE>{$code}</CODE>";
  $xml .= "<CITY>{$info['city']}</CITY>";
  $xml .= '<OPEN_HOURS>';
  foreach ($zoos_work_hours[$code] as $day_of_week => $time) {
    $day_of_week = mb_strtoupper($day_of_week);
    $xml .= "<$day_of_week>$time</$day_of_week>";
  }
  $xml .= '</OPEN_HOURS>';

  $xml .= '<ANIMALS>';
  foreach ($zoos_animals[$code] as $key => $animal) {
    $xml .= '<ANIMAL>';
    foreach ($animal as $animal_property => $animal_property_value) {
      $animal_property = mb_strtoupper($animal_property);
      $xml .= "<$animal_property>$animal_property_value</$animal_property>";
    }
      $xml .= '</ANIMAL>';
  }
  $xml .= '</ANIMALS>';
}
$xml .= '</ZOOS>';
if (file_put_contents('zoos.xml', $xml)) {
    print("Xml успешно создан.\n");
}
exit;
// <PROP>VALUE</PROP>
// $string

// $xml = new SimpleXMLElement('<ZOOS/>');
// array_walk_recursive($zoos, array($xml, 'addChild'));

// $array = [
//     1 => 2,
//     2 => [
//         1 => 'superorder',
//         2 => (object)[
//             'leg_count' => 4,
//             'superorder' => 'pes'
//         ]
//     ],
//     'pes' => 5
// ];
//
// $foo = 1;
// $leg_count = 'leg_count';
// $superorder = $array[$array[$foo]][$foo];
// // должен быть 20;
// $result = $array[$array[$foo]][$array[$foo]]->$leg_count * $array[$array[$array[$foo]][$array[$foo]]->$superorder] ;
// print("$result\n");

// массив['aa']
// объект->aa


// $object = (object)[
//     1 => 3,
//     'bar' => [
//         1 => 100,
//         3 => 2
//     ],
//     'aaa' => 1,
//     3 => 'bar',
// ];
// $aaa = 'aaa';
// $one = $object->$aaa;
// $three = $object->$one;
// $bar = $object->$three;
// // должен быть 200;
// $result = $object->$bar[$one] * $object->$bar[$three];
// print("$result\n");



// $array = [
//     0 => 1,
//     1 => 7,
//     2 => (object)['one' => 20, 'two' => 8, 'array2' => [7 => 4]],
// ];
// $foo = 2;
// $bar = 5;
// $one = 1;
// // $aaa = 5;
// // $object->two7
// $sss = $array[$one];
// $result = $bar * $array[$foo]->array2[$array[$one]];
// print($result);

// $zoos_general_info
// $zoos_work_hours
// $zoos_animals
//
// <ZOOS>
//   <ZOO>
//     <OWNER>Альберт Энштейн</OWNER>
//     <CODE>331</CODE>
//     <CITY>Москва</CITY>
//     <OPEN_HOURS>
//       <MONDAY>09 - 16</MONDAY>
//       <TUESDAY>09 - 16</TUESDAY>
//       <WEDNESDAY></WEDNESDAY>
//       <THURSDAY>09 - 16</THURSDAY>
//       <FRIDAY>09 - 20</FRIDAY>
//       <SATURDAY>09 - 14</SATURDAY>
//       <SUNDAY></SUNDAY>
//     </OPEN_HOURS>
//     <ANIMAL>
//       <SUPERORDER>Жираф</SUPERORDER>
//       <MALES>5</MALES>
//       <FEMALES>5</FEMALES>
//     </ANIMAL>
//     <ANIMAL>
//       <SUPERORDER>Гепард</SUPERORDER>
//       <MALES>3</MALES>
//       <FEMALES>2</FEMALES>
//     </ANIMAL>
//     <ANIMAL>
//       <SUPERORDER>Хомяк</SUPERORDER>
//       <MALES>1</MALES>
//       <FEMALES>344</FEMALES>
//     </ANIMAL>
//     <ANIMAL>
//       <SUPERORDER>Лев</SUPERORDER>
//       <MALES>1</MALES>
//       <FEMALES></FEMALES>
//     </ANIMAL>
//   </ZOO>


exit;
// xml лежит в той же папке что и скрипт
// /home/user/projects/zoo.xml
// /home/user/projects/code_school/script.php

// 1. Вывести таблицу с информациями о зоопарках.
// Город - Владелец - Вид - Суммарное количество - Часы работы
// 2. Вывести 2 зоопарка в которых больше всего животных и вывести их виды.
// 3. Вывести зоопарки которые можно посещать в среду после 17 часов.
// 4. Вывести 2 зоопарка с самым большим количеством видов животных перечислить их и их количество.
// 5. Экспортировать это всё в excel
// print php_ini_loaded_file();
// exit;



// $file->addSheet('sheet_two')
//     ->header(['name', 'age'])
//     ->data([
//         ['james', 33],
//         ['king', 33]
//     ]);
//
// $file->output();

define('PATH', './zoo.xml');
if (file_exists(PATH)) {
  $xml_object = simplexml_load_file(PATH);
  $zoos_sorted_by_animals_total_count = [];
  $zoos_sorted_by_superorder_count = [];
  foreach ($xml_object->ZOO as $zoo_data) {
    $animals = [];
    $animals_total_count = 0;
    foreach ($zoo_data->ANIMAL as $animal) {
      $superorder = (string)$animal->SUPERORDER;
      $count = $animal->MALES + $animal->FEMALES;
      $animals[$superorder] = $count;
      $animals_total_count += $count;
    }
    $zoo = [
      'owner' => (string)$zoo_data->OWNER,
      'city' => (string)$zoo_data->CITY,
      'open_hours' => [
        'Понедельник' => (string)$zoo_data->OPEN_HOURS->MONDAY,
        'Вторник' => (string)$zoo_data->OPEN_HOURS->TUESDAY,
        'Среда' => (string)$zoo_data->OPEN_HOURS->WEDNESDAY,
        'Четверг' => (string)$zoo_data->OPEN_HOURS->THURSDAY,
        'Пятница' => (string)$zoo_data->OPEN_HOURS->FRIDAY,
        'Суббота' => (string)$zoo_data->OPEN_HOURS->SATURDAY,
        'Воскресенье' => (string)$zoo_data->OPEN_HOURS->SUNDAY,
      ],
      'animals' => $animals
    ];
    $zoos_sorted_by_animals_total_count[$animals_total_count] = $zoo;
    krsort($zoos_sorted_by_animals_total_count);

    $zoos_sorted_by_superorder_count[count($zoo_data->ANIMAL)] = $zoo;
    krsort($zoos_sorted_by_superorder_count);
  }

  $fileObject  = new \Vtiful\Kernel\Excel(['path' => './']);
  $xlsx_object = $fileObject->fileName('tutorial.xlsx');

  $xlsx_object = show_all_zoo_info($zoos_sorted_by_animals_total_count, $xlsx_object);
  show_two_zoos_with_most_animals_count($zoos_sorted_by_animals_total_count);
  show_open_zoos_at_wednesday($zoos_sorted_by_animals_total_count);
  show_two_zoos_with_most_superorder_count($zoos_sorted_by_superorder_count);
  $xlsx_object->output();
} else {
  throw new \Exception('Не удалось найти файл - ' . PATH . "\n", 1);
}

function show_all_zoo_info($zoos, $xlsx_object) {
  $excel_data = [];
  foreach ($zoos as $zoo) {
    $excel_data[] = ['Город', 'Владелец'];
    $excel_data[] = [$zoo['city'], $zoo['owner']];


    print("Зоопарк:\n");
    print("  Город: {$zoo['city']}\n");
    print("  Владелец: {$zoo['owner']}\n");
    print("  Часы работы:\n");
    $excel_data[] = ['Часы работы'];
    foreach ($zoo['open_hours'] as $day_of_week => $work_hours) {
      $excel_data[] = [$day_of_week, $work_hours];
      if ($work_hours == '') {
        $work_hours = 'Выходной';
      }
      print("    $day_of_week: $work_hours\n");
    }
    print("  Животные:\n");
    $excel_data[] = ['Животные'];
    foreach ($zoo['animals'] as $superorder => $count) {
      $excel_data[] = [$superorder, $count];
      print("    $superorder: $count особей\n");
    }
    print("\n");
    $xlsx_object->addSheet('Информация о всех зоопарках')->data($excel_data);
    return $xlsx_object;
  }
}

function show_two_zoos_with_most_animals_count($zoos) {
  print("2 зоопарка с наибольшим количеством особей животных:\n");
  print_zoo_data($zoos);
}

function show_open_zoos_at_wednesday($zoos) {
  $open_zoos_at_wednesday = [];
  print("Посещать в среду после 17 часов можно зоопарки:\n");
  foreach ($zoos as $zoo) {
    $open_hours_at_wednesday = $zoo['open_hours']['Среда'];
    $zoo_close_at = mb_substr($open_hours_at_wednesday, -2);
    if ($zoo_close_at > 17) {
        print("  {$zoo['city']}, {$zoo['owner']}\n");
        print("  Время работы в среду $open_hours_at_wednesday\n\n");
    }
  }
}

function show_two_zoos_with_most_superorder_count($zoos) {
  print("2 зоопарка с наибольшим количеством видов животных:\n");
  print_zoo_data($zoos);
}

function print_zoo_data($zoos) {
  $schetchik = 0;
  foreach ($zoos as $zoo) {
    print("Зоопарк - {$zoo['city']} - {$zoo['owner']}:\n");
    print("Животные:\n");
    foreach ($zoo['animals'] as $superorder => $count) {
      print("  $superorder: $count особей\n");
    }
    print("\n");
    $schetchik++;
    if ($schetchik == 2) {
      break;
    }
  }
}



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
