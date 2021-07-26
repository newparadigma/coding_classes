<?php


$argv;
define('LEXA', '222');
$foo = 100;
$foo = 200;

// $a is not defined
$foo; //null тип данных "ничего"
$foo = true; //null тип данных Булево значение/Бул =Истина
$foo = false; //null тип данных Булево значение/Бул =Лож
// Бул значения как правило мы получаем при сравнений.
// 100 == 20 -> false, 100 == 100 -> true
$a = 100;
$b = 100;
if ($a == $b) { // condition - это условие на англ яз
  // код здесь выполнится
} else { // иначе на англ яз
  // код не выполнится
}

$foo = 1; // тип данных integer(int) на англ яз - целое число
$bar = '1'; // тип данных string строка, текст
$foo = ""; // не равна null


$foo == $bar; //true обычное сравнение, оно приводит типы данных
$foo === $bar; //false сравнение типов данных

$arrayName = array('1' => 1); //достаточно старая запись
$array = [ //новая запись массива
  // key => value
  0 => 'cat',
  1 => 'dog', // обычный массив/двумерный
  2 => 'cat',
  3 => 'pepe',
  4 => [
    'cat' => 'dog',
    'dog' => 'pepe', //ассоциативный массив
    'pepe' => 'cat',
    'pepe1' => false,
    'pepe2' => null,
    'pepe3',
  ],
];

$array['key']; // получаю доступ к значению по ключу key

foreach ($array1 as $key => $value) {
  foreach ($array2 as $key => $value) {
    // часто подобной конструкцией можно решить абсолютно все задачи
  }
}

// тип данных объект
// это целая структура данных, их обработчик, хранилище, визуализатор что угодно
// у объектов присутствует наследование

/**
 *
 */
class Parent1
{
  function __construct($argument)
  {
    $this->color = 'green';
  }

  public function setColorToYellow()
  // protected function setColorToYellow()
  // private function setColorToYellow()
  {
    return $this->color = 'yellow';
  }

  public function getBlue()
  {
    return 'blue';
  }
}

$parent1 = new Parent1();
$parent1->color; // green
$parent1->setColorToYellow(); // true
$parent1->color; // yellow
$parent1->getBlue(); // blue

// как обыгрываются методы объекта которые выводят результат присвоения/сравнения данных
$parent1 = new Parent1();
if ($parent1->setColorToYellow()) {
  $parent1->color; // yellow
} else {
  throw new \Exception("не удалось сменить цвет на жёлтый", 1);
}




/**
 *
 */
class Child1 extends Parent1
{

  function __construct($argument)
  {
  }
}

// function FunctionName()
// function FunctionName($first)
function FunctionName($first, $second = 'default_value')
{
  // code...
}
FunctionName($first, $second);
