<?php
// /project/index.php
// /project/files/adawd.xml
// у нас есть файлы которые лежат в папке project/files
// нужно сделать страницу с возможность искать и скачивать файлы из папки
// нам нужна главная страница
// на главной странице должен быть поле для ввода данных для поиска
// при вводе данных в поле поиска и нажатий "найти" пользователю должа продемонстрироваться страница найденных файлов
// на странице найденных файлов можно скачать файлы

// https://asd.newparadigma.ml/ - то это главная страница
// https://asd.newparadigma.ml/search?search=query страница поиска файлов
// любые другие адреса это 404

$uri = $_SERVER['REQUEST_URI'];
$pos = strpos($uri, '?');
if ($pos !== false) {
  $uri = substr($uri, 0, $pos);
}
$query = $_GET;

// роут номер 1 для главной страницы
if (empty($query) && $uri == '/') {
    // тут всё что касается главной страницы
    $index = getcwd() . '/index.html';
    include $index;
    exit;
}

// роут номер 2 для списка найденных файлов
if (!empty($query['search']) && $uri == '/search') {
    $search = $query['search'];
    $files_dir = getcwd() . '/files/';

    $files = [];
    foreach (new DirectoryIterator($files_dir) as $fileInfo) {
        if($fileInfo->isDot()) {
            continue;
        }

        $pos = strpos($fileInfo->getFilename(), $search);
        if ($pos !== false) {
            $files[] = $fileInfo->getFilename();

        }
    }

    $list_path = getcwd() . '/list.html.php';
    include $list_path;
    exit;
}

// роут номер 3 это скачивание файла
// https://asd.newparadigma.ml/files/download/dog20210122.xml
// /files/download/ 16 символов
$pos = strpos($uri, 'files/download');
if (empty($query) && $pos !== false) {
    $fileName = substr($uri, 16);
    $path_to_file = getcwd() . '/files/' . $fileName;

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    readfile($path_to_file);
    exit;
}

// роут номер 4 404
http_response_code(404);
echo "404";
 ?>
