<?php

use \htmlacademy\helpers\SiteHelper;
use frontend\widgets\Rate;
use yii\helpers\Url;

$tasksCount = count($user->tasks);
$opinionsCount = count($user->opinions);

$this->title = 'TaskForce | ' . $user['username'];
?>
<section class="content-view">
    <div class="user__card-wrapper">
        <div class="user__card">
            <img src="<?= SiteHelper::getUserAvatar($user->avatar) ?>" width="120" height="120" alt="Аватар пользователя">
            <div class="content-view__headline">
                <h1><?= $user['username'] ?></h1>
                <p><?= $user->profile->address ?>
                    , <?= SiteHelper::dateDifference(time(), $user->profile->date_birthday, '%Y') ?>
                    лет</p>
                <div class="profile-mini__name five-stars__rate">
                    <?= $user->rate ? Rate::widget(['rate' => $user->rate, 'option' => 'stars-and-rate']) : "" ?>
                </div>
                <b class="done-task">Выполнил <?= $tasksCount ?> <?= SiteHelper::plural($tasksCount, ['заказ', 'заказа', 'заказов']) ?></b>
                <? if ($user->opinions): ?>
                    <b class="done-review">Получил <?= $opinionsCount ?> <?= SiteHelper::plural($opinionsCount, ['отзыв', 'отзыва', 'отзывов']) ?></b>
                <? endif; ?>
            </div>
            <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                <span>Был на сайте <?= Yii::$app->formatter->asRelativeTime($user['date_last']) ?></span>
                <a href="#"><b></b></a>
            </div>
        </div>
        <div class="content-view__description">
            <p><?= $user->profile->about ?></p>
        </div>
        <div class="user__card-general-information">
            <div class="user__card-info">
                <h3 class="content-view__h3">Специализации</h3>
                <div class="link-specialization">
                    <? foreach ($user->categories as $category) : ?>
                        <a href="<?= Url::to(["/category/" . $category['slug']]) ?>"
                           class="link-regular"><?= $category['name'] ?></a>
                    <? endforeach; ?>
                </div>
                <h3 class="content-view__h3">Контакты</h3>
                <div class="user__card-link">
                    <a class="user__card-link--tel link-regular" href="#"><?= $user->profile->phone ?></a>
                    <a class="user__card-link--email link-regular" href="#"><?= $user->email ?></a>
                    <a class="user__card-link--skype link-regular" href="#"><?= $user->profile->skype ?></a>
                </div>
            </div>
            <?
            $imgFiles = [];
            foreach ($user->tasks as $task) {
                foreach ($task->files as $file) {
                    if (preg_match("/.jpg|.png/", $file->file)) {
                        $imgFiles[] = $file->file;
                    }
                }
            }
            ?>
            <? if ($imgFiles): ?>
                <div class="user__card-photo">
                    <h3 class="content-view__h3">Фото работ</h3>
                    <? foreach ($imgFiles as $file): ?>
                        <a href="#">
                            <img src="/uploads/<?= $file ?>" width="85" height="86" alt="Фото работы">
                        </a>
                    <? endforeach; ?>
                </div>
            <? endif; ?>
        </div>
    </div>
    <? if ($user->opinions): ?>
        <div class="content-view__feedback">
            <h2>Отзывы<span>(<?= count($user->opinions) ?>)</span></h2>
            <div class="content-view__feedback-wrapper reviews-wrapper">
                <? foreach ($user->opinions as $opinion) : ?>
                    <?
                    $userUrl = Url::to(["/users/user/" . $opinion->owner->id]);
                    if ($opinion->owner->profile) {
                        $userUrl = Url::to(["/users/" . $opinion->owner->id]);
                    }
                    ?>
                    <div class="feedback-card__reviews">
                        <p class="link-task link">Задание <a href="<?= Url::to(["/tasks/" . $opinion->task->id]) ?>"
                                                             class="link-regular">«<?= $opinion->task->name ?>»</a>
                        </p>
                        <div class="card__review">
                            <a href="<?= $userUrl ?>">
                                <img alt="" src=" <?= SiteHelper::getUserAvatar($opinion->owner->avatar) ?>" width="55"
                                     height="54">
                            </a>
                            <div class="feedback-card__reviews-content">
                                <p class="link-name link"><a href="<?= $userUrl ?>"
                                                             class="link-regular"><?= $opinion->owner->username ?></a>
                                </p>
                                <p class="review-text">
                                    <?= $opinion->description ?>
                                </p>
                            </div>
                            <div class="card__review-rate">
                                <?= Rate::widget(['rate' => $opinion->rate, 'option' => 'rate']) ?>
                            </div>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    <? endif; ?>
</section>
<section class="connect-desk">
    <div class="connect-desk__chat">

    </div>
</section>
