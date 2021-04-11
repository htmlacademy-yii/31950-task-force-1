<?php

use yii\helpers\Url;

use htmlacademy\helpers\SiteHelper;
use frontend\widgets\Rate;

/** @var $users */
?>
<? foreach ($users as $user): ?>
    <?
    $tasksCount = count($user->tasks);
    $opinionsCount = count($user->opinions);
    ?>
    <div class="content-view__feedback-card user__search-wrapper">
        <div class="feedback-card__top">
            <div class="user__search-icon">
                <a href="<?= Url::to(["/users/" . $user['id']]) ?>">
                    <img src="<?= SiteHelper::getUserAvatar($user->avatar) ?>" width="65"
                         height="65" alt="">
                </a>
                <span><?= $tasksCount ?> <?= SiteHelper::plural($tasksCount, ['задание', 'задания', 'заданий']) ?></span>
                <span><?= $opinionsCount ?> <?= SiteHelper::plural($opinionsCount, ['отзыв', 'отзыва', 'отзывов']) ?></span>
            </div>
            <div class="feedback-card__top--name user__search-card">
                <p class="link-name"><a href="<?= Url::to(["/users/" . $user['id']]) ?>"
                                        class="link-regular"><?= $user['username'] ?></a></p>
                <?= $user->rate ? Rate::widget(['rate' => $user->rate, 'option' => 'stars-and-rate']) : "" ?>
                <p class="user__search-content">
                    <?= $user->profile ? $user->profile->about : "" ?>
                </p>
            </div>
            <span
                class="new-task__time">Был на сайте <?= Yii::$app->formatter->asRelativeTime($user['date_last']) ?></span>
        </div>
        <? if (count($user->categories)): ?>
            <div class="link-specialization user__search-link--bottom">
                <? foreach ($user->categories as $category) : ?>
                    <a href="<?= Url::to(["/category/" . $category['slug']]) ?>"
                       class="link-regular"><?= $category['name'] ?></a>
                <? endforeach; ?>
            </div>
        <? endif; ?>
    </div>
<? endforeach; ?>
