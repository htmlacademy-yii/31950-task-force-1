<?
$this->title = 'TaskForce | ' . $user['username'];

use htmlacademy\helpers\SiteHelper; ?>
<section class="content-view">
    <div class="user__card-wrapper">
        <div class="user__card">
            <img src="<?= SiteHelper::getUserAvatar($user->avatar) ?>" width="120" height="120" alt="Аватар пользователя">
            <div class="content-view__headline">
                <h1><?= $user['username'] ?></h1>
            </div>
            <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                <span>Был на сайте <?= Yii::$app->formatter->asRelativeTime($user['date_last']) ?></span>
                <a href="#"><b></b></a>
            </div>
        </div>
        <div class="user__card-general-information">
            <div class="user__card-info">
                <h3 class="content-view__h3">Контакты</h3>
                <div class="user__card-link">
                    <a class="user__card-link--email link-regular" href="#"><?= $user->email ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="connect-desk">
    <div class="connect-desk__chat">

    </div>
</section>
