<?php

use yii\helpers\Html;
use yii\helpers\Url;

use htmlacademy\helpers\SiteHelper;
use frontend\widgets\Modal;
use frontend\widgets\Rate;
use frontend\assets\TaskAsset;

TaskAsset::register($this);
/** @var $task */
/** @var $check */

$this->title = 'TaskForce | ' . $task['name'];
$user = \Yii::$app->user->identity;

?>

<section class="content-view">
    <div class="content-view__card">
        <div class="content-view__card-wrapper">
            <div class="content-view__header">
                <div class="content-view__headline">
                    <h1><?= $task['name'] ?></h1>
                    <span>Размещено в <?= count($task->categories) > 1 ? "категориях" : "категории" ?>
                        <? foreach ($task->categories as $category): ?>
                            <a href="<?= '/category/' . $category['slug'] ?>"
                               class="link-regular"><?= $category['name'] ?></a>
                        <? endforeach; ?>
                        <?= Yii::$app->formatter->asRelativeTime($task['date_add']) ?>
                      </span>
                </div>
                <b class="new-task__price new-task__price--<?= SiteHelper::array_first($task->categories)['slug'] ?> content-view-price"><?= $task['price'] ?>
                    <b> ₽</b></b>
                <div
                    class="new-task__icon new-task__icon--<?= SiteHelper::array_first($task->categories)['slug'] ?> content-view-icon"></div>
            </div>
            <div class="content-view__description">
                <h3 class="content-view__h3">Общее описание</h3>
                <p>
                    <?= $task['description'] ?>
                </p>
            </div>
            <? if ($task->files): ?>
                <div class="content-view__attach">
                    <h3 class="content-view__h3">Вложения</h3>
                    <? foreach ($task->files as $file): ?>
                        <a target="_blank"
                           href="<?= Url::to([Yii::$app->params['taskImagesPath'] . '/' . $file['file']]) ?>">
                            <?= $file['file'] ?>
                        </a>
                    <? endforeach; ?>
                </div>
            <? endif; ?>
            <? if ($task->latitude && $task->longitude): ?>
                <div class="content-view__location">
                    <h3 class="content-view__h3">Расположение</h3>
                    <div class="content-view__location-wrapper">
                        <div class="content-view__map">
                            <div id="map" style="width: 361px; height: 292px" data-latitude="<?= $task->latitude ?>"
                                 data-longitude="<?= $task->longitude ?>"></div>
                        </div>
                        <div class="content-view__address">
                            <span class="address__town"><?= $task->address ?></span>
                        </div>
                    </div>
                </div>
            <? endif; ?>
        </div>
        <div class="content-view__action-buttons">
            <? if ($check->isShowResponseButton()): ?>
                <button class=" button button__big-color response-button open-modal"
                        type="button" data-for="response-form">Откликнуться
                </button>
            <? elseif ($check->isShowPassButton()): ?>
                <button class="button button__big-color refusal-button open-modal"
                        type="button" data-for="refuse-form">Отказаться
                </button>
            <? elseif ($check->isShowCompleteButton()): ?>
                <button class="button button__big-color request-button open-modal"
                        type="button" data-for="complete-form">Завершить
                </button>
            <? endif; ?>
        </div>
    </div>
    <? if ($check->isShowResponses()): ?>
        <div class="content-view__feedback">
            <h2>Отклики <span>(<?= $check->countResponses() ?>)</span></h2>
            <div class="content-view__feedback-wrapper">
                <? foreach ($task->response as $response): ?>
                    <? if ($check->isShowResponse($response)): ?>
                        <div class="content-view__feedback-card">
                            <div class="feedback-card__top">
                                <a href="/users/<?= $response->user['id'] ?>">
                                    <img src="/img/<?= $response->user->avatar ?>"
                                         width="55"
                                         height="55" alt="">
                                </a>
                                <div class="feedback-card__top--name">
                                    <p><a href="/users/<?= $response->user['id'] ?>"
                                          class="link-regular"><?= $response->user['username'] ?></a></p>
                                    <?= $response->user->rate ? Rate::widget(['rate' => $response->user->rate, 'option' => 'stars-and-rate']) : "" ?>
                                </div>
                                <span
                                    class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($response['date_add']) ?></span>
                            </div>
                            <div class="feedback-card__content">
                                <p><?= $response['description'] ?></p>
                                <span><?= $response['price'] ?> ₽</span>
                            </div>
                            <? if ($check->isShowActions($response)) : ?>
                                <div class="feedback-card__actions">
                                    <a href="<?= Url::to(['/tasks/response-apply', 'taskId' => $task->id, 'responseId' => $response->id, 'userId' => $response->user->id]) ?>"
                                       class="button__small-color request-button button"
                                       type="button">Подтвердить</a>
                                    <a href="<?= Url::to(['/tasks/response-reject', 'id' => $response->id]) ?>"
                                       class="button__small-color refusal-button button"
                                       type="button">Отказать</a>
                                </div>
                            <? endif; ?>
                        </div>
                    <? endif; ?>
                <? endforeach; ?>
            </div>
        </div>
    <? endif; ?>
</section>
<section class="connect-desk">
    <div class="connect-desk__profile-mini">
        <div class="profile-mini__wrapper">
            <h3>Заказчик</h3>
            <div class="profile-mini__top">
                <img src="/img/<?= $task->owner->avatar ?>" width="62" height="62" alt="Аватар заказчика">
                <div class="profile-mini__name five-stars__rate">
                    <p><?= Html::encode($task->owner->username); ?></p>
                    <?= $task->owner->rate ? Rate::widget(['rate' => $task->owner->rate, 'option' => 'stars-and-rate']) : "" ?>
                </div>
            </div>
            <p class="info-customer">
                <? if (count($task->owner->userTasks)): ?>
                    <span>
                    <?= count($task->owner->userTasks) . " " . SiteHelper::plural(count($task->owner->userTasks), ['заказ', 'заказа', 'заказов']) ?>
                </span>
                <? endif; ?>
                <?
                $relativeDate = Yii::$app->formatter->asRelativeTime($task->owner->created_at);
                $date_add = str_replace("назад", "на сайте", $relativeDate);
                ?>
                <span class="last"><?= $date_add ?></span></p>
            <a href="<?= SiteHelper::getUserUrl($task->owner) ?>" class="link-regular">Смотреть профиль</a>
        </div>
    </div>
    <div class="connect-desk__chat">
        <div id="chat-container">
            <chat class="connect-desk__chat" task="<?= $task->id ?>" user="<?= $user->id ?>" owner="<?= $task->owner_id ?>"
                  worker="<?= $task->user ? $task->user->user_id : null ?>"></chat>
        </div>
    </div>
</section>
<?= Modal::widget(['type' => 'task-reject', 'task' => $task]) ?>
<?= Modal::widget(['type' => 'task-cancel', 'task' => $task]) ?>
<?= Modal::widget(['type' => 'task-response', 'task' => $task]) ?>
<script src="https://api-maps.yandex.ru/2.1/?apikey=e666f398-c983-4bde-8f14-e3fec900592a&lang=ru_RU"
        type="text/javascript">
</script>
<script type="text/javascript">
    const map = document.getElementById("map");
    const latitude = map.dataset.latitude;
    const longitude = map.dataset.longitude;
    if (latitude && longitude) {
        ymaps.ready(init);

        function init() {
            var myMap = new ymaps.Map("map", {
                center: [latitude, longitude],
                zoom: 14
            });
            myMap.geoObjects.add(new ymaps.Placemark([latitude, longitude], {}, {
                preset: 'islands#redIcon',
            }));
        }
    }
</script>
