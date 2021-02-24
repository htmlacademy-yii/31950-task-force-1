<?php
/** @var $tasks */
/** @var $user */

$this->title = 'TaskForce | Мои задания';

?>

<?= \Yii::$app->view->renderFile('@app/views/user-tasks/common/menu.php', ["active" => 'Отменённые']); ?>
<?= \Yii::$app->view->renderFile('@app/views/user-tasks/common/tasks.php', ["text" => 'Отменено', 'tasks' => $tasks, 'user' => $user]); ?>
