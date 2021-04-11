<?

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\widgets\UsersPagination;
use yii\widgets\LinkPager;

/** @var $categories */
/** @var $model */
/** @var $dataProvider */
/** @var $pages */

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
    <?=
    UsersPagination::widget(['dataProvider' => $dataProvider])
    ?>
    <div class="block__pagination">
        <?=
        LinkPager::widget([
            'pagination' => $pages,
            'activePageCssClass' => 'pagination__item--current',
            'pageCssClass' => 'pagination__item',
            'prevPageCssClass' => 'pagination__item',
            'nextPageCssClass' => 'pagination__item',
            'prevPageLabel' => '',
            'nextPageLabel' => '',
            'options' => [
                'class' => 'new-task__pagination-list',
            ]
        ]);
        ?>
    </div>
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
