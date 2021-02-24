<?php

use htmlacademy\helpers\SiteHelper;
use yii\helpers\Url;
$user = "";
if (!Yii::$app->user->isGuest) {
    $user = \Yii::$app->user->identity;
}
?>
<footer class="page-footer">
    <div class="main-container page-footer__container">
        <div class="page-footer__info">
            <p class="page-footer__info-copyright">
                © 2019, ООО «ТаскФорс»
                Все права защищены
            </p>
            <p class="page-footer__info-use">
                «TaskForce» — это сервис для поиска исполнителей на разовые задачи.
                mail@taskforce.com
            </p>
        </div>
        <div class="page-footer__links">
            <ul class="links__list">
                <li class="links__item">
                    <a href="<?= Url::to(["/tasks"]) ?>">Задания</a>
                </li>
                <? if (!Yii::$app->user->isGuest): ?>
                    <li class="links__item">
                        <a href="<?= SiteHelper::getUserUrl($user) ?>">Мой профиль</a>
                    </li>
                <? endif; ?>
                <li class="links__item">
                    <a href="<?= Url::to(["/users"]) ?>">Исполнители</a>
                </li>
                <li class="links__item">
                    <a href="<?= Url::to(["/register"]) ?>">Регистрация</a>
                </li>
                <li class="links__item">
                    <a href="<?= Url::to(["/tasks/create"]) ?>">Создать задание</a>
                </li>
                <li class="links__item">
                    <a href="/">Справка</a>
                </li>
            </ul>
        </div>
        <div class="page-footer__copyright">
            <a href="https://htmlacademy.ru" target="_blank" rel="noopener">
                <img class="copyright-logo"
                     src="/img/academy-logo.png"
                     width="185" height="63"
                     alt="Логотип HTML Academy">
            </a>
        </div>
        <?php if (isset($this->blocks['footerAfterCopyright'])): ?>
            <?= $this->blocks['footerAfterCopyright'] ?>
        <?php endif; ?>
    </div>
</footer>
