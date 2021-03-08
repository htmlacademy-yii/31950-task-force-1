<?php

use htmlacademy\helpers\SiteHelper;
use yii\bootstrap\ActiveForm;
use frontend\assets\AccountAsset;

/** @var $cities */
/** @var $categories */
AccountAsset::register($this);
?>

<section class="account__redaction-wrapper">
    <h1>Редактирование настроек профиля</h1>
    <? $form = ActiveForm::begin([
        'id' => 'account',
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>
    <div class="account__redaction-section">
        <h3 class="div-line">Настройки аккаунта</h3>
        <div class="account__redaction-section-wrapper">
            <div class="account__redaction-avatar">
                <img src="<?= SiteHelper::getUserAvatar($user->avatar) ?>" width="156" height="156" alt="avatar">
                <?= $form->
                field($model, 'avatar')->
                fileInput(['id' => "upload-avatar"])->
                label('Сменить аватар', ['class' => 'link-regular']) ?>
            </div>
            <div class="account__redaction">
                <?= $form->field($model, 'username', ['options' => ['class' => 'account__input account__input--name']])->
                textInput(['class' => "input textarea", 'disabled' => 'disabled'])->
                label('Ваше имя') ?>

                <?= $form->field($model, 'email', ['options' => ['class' => 'account__input account__input--email']])->
                textInput(['class' => "input textarea"])->
                label('email') ?>

                <?= $form->field($model, 'city', ['options' => ['class' => 'account__input account__input--name']])->
                dropDownList($cities, [
                    'class' => 'multiple-select input multiple-select-big',
                    'options' => [
                        $user->city_id => ['selected' => true],
                    ]
                ])->
                label('Город')
                ?>

                <?= $form->field($model, 'date_birthday', ['options' => ['class' => 'account__input account__input--date']])->
                textInput(['class' => "input-middle input input-date"])->
                label('День рождения') ?>

                <?= $form->field($model, 'about', ['options' => ['class' => 'account__input account__input--info']])->
                textarea(['class' => "input textarea", 'rows' => 7, 'placeholder' => 'Place your text'])->
                label('Информация о себе') ?>
            </div>
        </div>
        <h3 class="div-line">Выберите свои специализации</h3>
        <div class="account__redaction-section-wrapper">
            <?= $form->field($model, 'category', ['options' =>
                ['class' => 'search-task__categories account_checkbox--bottom']
            ])->checkboxList($categories, [
                'item' => function ($index, $category, $name, $checked, $id) {
                    $isChecked = $checked ? 'checked' : '';
                    return "<input class='visually-hidden checkbox__input' type='checkbox' {$isChecked} name='$name' id='category-$id'
                                value='$id'>
                                <label for='category-$id'>{$category}</label>
                            ";
                }
            ])->label(false) ?>
        </div>
    </div>
    <h3 class="div-line">Безопасность</h3>
    <div class="account__redaction-section-wrapper account__redaction">
        <?= $form->field($model, 'password', ['options' => ['class' => 'account__input']])->
        textInput(['class' => "input textarea", 'type' => 'password'])->
        label('Новый пароль') ?>

        <?= $form->field($model, 'repeat_password', ['options' => ['class' => 'account__input']])->
        textInput(['class' => "input textarea", 'type' => 'password'])->
        label('Повтор пароля') ?>
    </div>

    <h3 class="div-line">Фото работ</h3>
    <? if ($user->files) foreach ($user->files as $file): ?>
        <div class="account__files">
            <img src="/uploads/user-file/<?= $file->file ?>" width="156" height="156" alt="avatar">
        </div>
    <? endforeach; ?>
    <div class="account__redaction-section-wrapper account__redaction">
        <span class="dropzone">Выбрать фотографии</span>
    </div>

    <h3 class="div-line">Контакты</h3>
    <div class="account__redaction-section-wrapper account__redaction">
        <? if (isset($profile)): ?>
            <?= $form->
            field($profile, 'phone', ['options' => ['class' => 'account__input']])->
            textInput(['class' => "input textarea", 'type' => 'tel'])->
            label('Телефон') ?>

            <?= $form->field($profile, 'skype', ['options' => ['class' => 'account__input']])->
            textInput(['class' => "input textarea"])->
            label('Skype') ?>
        <? endif; ?>
        <?= $form->field($model, 'telegram', ['options' => ['class' => 'account__input']])->
        textInput(['class' => "input textarea"])->
        label('Telegram') ?>
    </div>
    <h3 class="div-line">Настройки сайта</h3>
    <h4>Уведомления</h4>
    <div class="account__redaction-section-wrapper account_section--bottom">
        <div class="search-task__categories account_checkbox--bottom">
            <?= $form->
            field($model, 'notification_to_new_message',
                [
                    'template' => '{input}{label}{error}',
                ])->
            checkbox(['class' => "visually-hidden checkbox__input"], false)->label('Новое сообщение') ?>

            <?= $form->
            field($model, 'notification_to_new_action',
                [
                    'template' => '{input}{label}{error}',
                ])->
            checkbox(['class' => "visually-hidden checkbox__input"], false)->label('Действия по заданию') ?>

            <?= $form->
            field($model, 'notification_to_new_review',
                [
                    'template' => '{input}{label}{error}',
                ])->
            checkbox(['class' => "visually-hidden checkbox__input"], false)->label('Новый отзыв') ?>
        </div>
        <div class="search-task__categories account_checkbox account_checkbox--secrecy">
            <?= $form->
            field($model, 'show_my_contacts',
                [
                    'template' => '{input}{label}{error}',
                ])->
            checkbox(['class' => "visually-hidden checkbox__input"], false)->label('Показывать мои контакты только заказчику') ?>

            <?= $form->
            field($model, 'show_my_account',
                [
                    'template' => '{input}{label}{error}',
                ])->
            checkbox(['class' => "visually-hidden checkbox__input"], false)->label('Не показывать мой профиль') ?>
        </div>
    </div>
    <button class="button" type="submit" id="submit-btn">Сохранить изменения</button>
    <?php ActiveForm::end(); ?>
</section>

