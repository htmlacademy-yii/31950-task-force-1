<?
use htmlacademy\helpers\SiteHelper;
use yii\helpers\Url;

/** @var $tasks */

?>

<? foreach ($tasks as $task): ?>
    <div class="new-task__card">
        <div class="new-task__title">
            <a href="<?= Url::to(["/tasks/" . $task['id']]) ?>" class="link-regular">
                <h2><?= $task['name'] ?></h2></a>
            <div class="links" style="display: flex;margin-left: -10px;">
                <? foreach ($task->categories as $category): ?>
                    <a class="new-task__type link-regular" style="margin-left: 10px;"
                       href="<?= Url::to(["/category/" . $category['slug']]) ?>">
                        <p><?= $category['name'] ?></p>
                    </a>
                <? endforeach; ?>
            </div>
        </div>
        <div
            class="new-task__icon new-task__icon--<?= SiteHelper::array_first($task->categories)['slug'] ?>"></div>
        <p class="new-task_description">
            <?= $task['description'] ?>
        </p>
        <b class="new-task__price new-task__price--translation"><?= $task['price'] ?><b> ₽</b></b>
        <p class="new-task__place"><?= $task['address'] ?></p>
        <span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($task['date_add']) ?></span>
    </div>
<? endforeach; ?>
