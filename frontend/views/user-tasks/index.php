<?php
/** @var $tasks */

/** @var $user */

$this->title = 'TaskForce | Мои задания';

?>
<?= \Yii::$app->view->renderFile('@app/views/user-tasks/common/menu.php', ["active" => 'Новые']); ?>
<?= \Yii::$app->view->renderFile('@app/views/user-tasks/common/tasks.php', ["text" => 'Новый', 'tasks' => $tasks, 'user' => $user]); ?>
