<?php
/** @var $tasks */
/** @var $user */

$this->title = 'TaskForce | Мои задания';

?>

<?= \Yii::$app->view->renderFile('@app/views/user-tasks/common/menu.php', ["active" => 'Завершённые']); ?>
<?= \Yii::$app->view->renderFile('@app/views/user-tasks/common/tasks.php', ["text" => 'Завершено', 'tasks' => $tasks, 'user' => $user]); ?>
