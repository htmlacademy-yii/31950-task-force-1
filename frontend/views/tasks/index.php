<?

use frontend\widgets\TasksPagination;

use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;


/** @var $dataProvider */
/** @var $pages */
/** @var $categories */
/** @var $model */

$this->title = 'TaskForce | Список задач';
?>

<section class="new-task">
    <div class="new-task__wrapper">
        <h1>Новые задания</h1>
        <?= TasksPagination::widget(['dataProvider' => $dataProvider]) ?>
    </div>
    <div class="new-task__pagination">
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
