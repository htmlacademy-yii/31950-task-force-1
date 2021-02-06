<?php
/** @var $tasks */
/** @var $user */

$this->title = 'TaskForce | Мои задания';

?>

<?= \Yii::$app->view->renderFile('@app/views/user-tasks/common/menu.php', ["active" => 'Активные']); ?>
<?= \Yii::$app->view->renderFile('@app/views/user-tasks/common/tasks.php', ["text" => 'В работе', 'tasks' => $tasks, 'user' => $user]); ?>
