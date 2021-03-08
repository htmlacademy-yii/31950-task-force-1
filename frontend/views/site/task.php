<?php

use htmlacademy\ex\FileFormatException;
use htmlacademy\ex\SourceFileException;
use htmlacademy\controllers\ConvertCSV;

$this->title = 'Task';
$path = \Yii::getAlias('@project');
$baseDir = $path . "/data";

try {
    $category = new ConvertCSV($baseDir . "/category.csv", ['id', 'name', 'slug']);
    $city = new ConvertCSV($baseDir . "/city.csv", ['id', 'name', 'latitude', 'longitude']);
    $user = new ConvertCSV($baseDir . "/user.csv", ['id', 'username', 'email', 'password_hash', 'date_last', 'created_at', 'avatar', 'city_id', "auth_key", "verification_token", "status", "updated_at","role"]);
    $profile = new ConvertCSV($baseDir . "/profile.csv", ['id', 'address', 'about', 'date_birthday', 'phone', 'skype', 'telegram', 'popular', 'online', 'favorite']);
    $message = new ConvertCSV($baseDir . "/message.csv", ['id', 'published_at', 'message', 'worker_id', 'owner_id']);
    $opinion = new ConvertCSV($baseDir . "/opinion.csv", ['id', 'date_add', 'rate', 'description', 'owner_id', 'worker_id', 'task_id']);
    $task = new ConvertCSV($baseDir . "/task.csv", ['id', 'name', 'description', 'date_add', 'date_expire', 'price', 'address', 'latitude', 'longitude', 'owner_id',"status"]);
    $taskCategory = new ConvertCSV($baseDir . "/task_category.csv", ['id', 'task_id', 'category_id']);
    $userProfile = new ConvertCSV($baseDir . "/user_profile.csv", ['id', 'user_id', 'profile_id']);
    $userTask = new ConvertCSV($baseDir . "/user_task.csv", ['id', 'user_id', 'task_id']);
    $userCategory = new ConvertCSV($baseDir . "/user_category.csv", ['id', 'user_id', 'category_id']);
    $taskFile = new ConvertCSV($baseDir . "/task_file.csv", ['id', 'task_id', 'file']);
    $response = new ConvertCSV($baseDir . "/response.csv", ['id', 'task_id', 'user_id', 'date_add', 'price', 'description']);
    echo("Все конвертации проведены");

    $save_file = $path . '/insert_date.sql';
    file_put_contents($path . '/insert_date.sql', '');
    $file_content = '';
    $file_content .= "SET foreign_key_checks = 0;\n";
    $file_content .= file_get_contents($path . "/sql" . '/category.sql');
    $file_content .= file_get_contents($path . "/sql" . '/city.sql');
    $file_content .= file_get_contents($path . "/sql" . '/user.sql');
    $file_content .= file_get_contents($path . "/sql" . '/profile.sql');
    $file_content .= file_get_contents($path . "/sql" . '/message.sql');
    $file_content .= file_get_contents($path . "/sql" . '/opinion.sql');
    $file_content .= file_get_contents($path . "/sql" . '/task.sql');
    $file_content .= file_get_contents($path . "/sql" . '/task_category.sql');
    $file_content .= file_get_contents($path . "/sql" . '/user_profile.sql');
    $file_content .= file_get_contents($path . "/sql" . '/user_task.sql');
    $file_content .= file_get_contents($path . "/sql" . '/user_category.sql');
    $file_content .= file_get_contents($path . "/sql" . '/task_file.sql');
    $file_content .= file_get_contents($path . "/sql" . '/response.sql');
    $file_content .= "SET foreign_key_checks = 1;";

    file_put_contents($save_file, $file_content, FILE_APPEND | LOCK_EX);
    echo "<br>";

    echo("Все sql файлы объединены");

} catch (SourceFileException $e) {
    echo("Не удалось обработать csv файл: " . $e->getMessage());
} catch (FileFormatException $e) {
    echo("Неверная форма файла импорта: " . $e->getMessage());
}

?>

