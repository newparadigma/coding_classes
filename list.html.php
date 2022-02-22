<!DOCTYPE html>
<html>
    <body>
        <p>Список файлов</p>
        <?php foreach ($files as $fileName) { ?>
            <a href="/files/<?php echo($fileName) ?>"><?php echo($fileName) ?> открыть</a>
            <br>
            <a href="/files/download/<?php echo($fileName) ?>"><?php echo($fileName) ?> скачать</a>
            <br>
            <br>
        <?php } ?>
    </body>
</html>
