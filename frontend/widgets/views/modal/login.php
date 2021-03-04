<?

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>
<section class="modal enter-form form-modal" id="enter-form">
    <h2>Вход на сайт</h2>
    <div class="enter-form__auth"> <span>Через соц.сеть:</span>
        <?= yii\authclient\widgets\AuthChoice::widget([
            'baseAuthUrl' => ['site/auth'],
            'popupMode' => false,
        ]) ?></div>
    <? $form = ActiveForm::begin(
        ['id' => 'login-form',
            'action' => Url::to(['/site/login']),
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'options' => ['class' => 'log-in']
        ]); ?>
    <?= $form->field($model, 'email', ['template' => "{label}{input}\n{error}"])
        ->textInput(['class' => 'enter-form-email input input-middle'])->label("Email", ["class" => 'form-modal-description']); ?>
    <?= $form->field($model, 'password', ['template' => "{label}{input}\n{error}"])
        ->passwordInput(['class' => 'enter-form-email input input-middle'])->label("Пароль", ["class" => 'form-modal-description']); ?>

    <button class="button" type="submit">Войти</button>
    <?php ActiveForm::end(); ?>
    <button class="form-modal-close" id="close-modal" type="button">Закрыть</button>

</section>
<div class="overlay"></div>
