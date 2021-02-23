<?

use htmlacademy\helpers\SiteHelper;
use frontend\widgets\Rate;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var $users */
/** @var $categories */
/** @var $model */

$this->title = 'TaskForce | Список исполнителей';

?>
<section class="user__search">
    <div class="user__search-link">
        <p>Сортировать по:</p>
        <ul class="user__search-list">
            <li class="user__search-item <?= Yii::$app->getRequest()->pathInfo == "users" ? "user__search-item--current" : "" ?>">
                <a href="<?= Url::to(["/users"]) ?>" class="link-regular">Рейтингу</a>
            </li>
            <li class="user__search-item <?= Yii::$app->getRequest()->pathInfo == "users/number" ? "user__search-item--current" : "" ?>">
                <a href="<?= Url::to(["/users/number"]) ?>" class="link-regular">Числу заказов</a>
            </li>
            <li class="user__search-item <?= Yii::$app->getRequest()->pathInfo == "users/popular" ? "user__search-item--current" : "" ?>">
                <a href="<?= Url::to(["/users/popular"]) ?>" class="link-regular">Популярности</a>
            </li>
        </ul>
    </div>
    <? foreach ($users as $user): ?>
        <?
        $tasksCount = count($user->tasks);
        $opinionsCount = count($user->opinions);
        ?>
        <div class="content-view__feedback-card user__search-wrapper">
            <div class="feedback-card__top">
                <div class="user__search-icon">
                    <a href="<?= Url::to(["/users/" . $user['id']]) ?>">
                        <img src="/uploads/user-images/<?= $user->avatar ?>" width="65"
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
</section>
<section class="search-task">
    <div class="search-task__wrapper">
        <?php $form = ActiveForm::begin([
            'id' => 'search-user',
            'method' => 'GET',
            'options' => ['class' => 'search-task__form']
        ]);
        ?>
        <fieldset class="search-task__categories">
            <legend>Категории</legend>
            <?= $form->field($model, 'category')->checkboxList($categories, [
                'item' => function ($index, $category, $name, $checked, $id) {
                    $isChecked = $checked ? 'checked' : '';
                    return "
                                <input class='visually-hidden checkbox__input' type='checkbox' {$isChecked} name='$name' id='category-$id'
                                value='$id'>
                                <label for='category-$id'>{$category->name}</label>
                            ";
                }
            ])->label(false) ?>
        </fieldset>
        <fieldset class="search-task__categories">
            <legend>Дополнительно</legend>
            <?= $form->field($model,
                'isFree',
                ['template' => "{input}{label}"])->
            checkbox(['class' => 'visually-hidden checkbox__input'], false)->
            label('Сейчас свободен'); ?>
            <?= $form->field($model,
                'hasOpinion',
                ['template' => "{input}{label}"])->
            checkbox(['class' => 'visually-hidden checkbox__input'], false)->
            label('Есть отзывы'); ?>
            <?= $form->field($model,
                'isOnline',
                ['template' => "{input}{label}"])->
            checkbox(['class' => 'visually-hidden checkbox__input'], false)->
            label('Сейчас онлайн'); ?>
            <?= $form->field($model,
                'hasFavorite',
                ['template' => "{input}{label}"])->
            checkbox(['class' => 'visually-hidden checkbox__input'], false)->
            label('В избранном'); ?>
        </fieldset>
        <?= $form->field($model, 'q')->textInput(['class' => 'input-middle input', 'type' => 'search'])->label('Поиск по имени') ?>
        <button class="button" type="submit">Искать</button>
        <?php ActiveForm::end(); ?>
    </div>
</section>
