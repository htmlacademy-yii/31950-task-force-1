<?

use htmlacademy\helpers\SiteHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/** @var $tasks */
/** @var $categories */
/** @var $model */
/** @var $pages */

$this->title = 'TaskForce | Список задач';
?>

<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>
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
    </div>
    <div class="new-task__pagination">
        <?= LinkPager::widget([
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
        ]); ?>
    </div>
</section>
<section class="search-task">
    <div class="search-task__wrapper">
        <?php $form = ActiveForm::begin([
            'id' => 'search-task',
            'method' => 'GET',
            'options' => ['class' => 'search-task__form']
        ]);
        ?>
        <fieldset class="search-task__categories">
            <legend>Категории</legend>
            <?= $form->field($model, 'category')->checkboxList($categories, [
                'item' => function ($index, $category, $name, $checked, $id) {
                    $isChecked = $checked ? 'checked' : '';
                    return "<input class='visually-hidden checkbox__input' type='checkbox' {$isChecked} name='$name' id='category-$id'
                                value='$id'>
                                <label for='category-$id'>{$category->name}</label>
                            ";
                }
            ])->label(false) ?>
        </fieldset>
        <fieldset class="search-task__categories">
            <legend>Дополнительно</legend>
            <?= $form->field($model,
                'noResponse',
                ['template' => "{input}{label}"])->
            checkbox(['class' => 'visually-hidden checkbox__input'], false)->
            label('Без откликов'); ?>
            <?= $form->field($model,
                'remoteWork',
                ['template' => "{input}{label}"])->
            checkbox(['class' => 'visually-hidden checkbox__input'], false)->
            label('Удаленная работа'); ?>
        </fieldset>
        <?
        $times = [
            'day' => 'За день',
            'week' => 'За неделю',
            'month' => 'За месяц',
            'all' => 'За все время'
        ];
        echo $form->field($model, 'time')->dropDownList($times, ['prompt' => 'Период'])->label(false)
        ?>
        <?= $form->field($model, 'q')->textInput(['class' => 'input-middle input', 'type' => 'search'])->label('Поиск по названию') ?>
        <button class="button" type="submit">Искать</button>
        <?php ActiveForm::end(); ?>
    </div>
</section>
