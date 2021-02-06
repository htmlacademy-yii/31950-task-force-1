<?php
use frontend\widgets\Rate;

/** @var $tasks */
/** @var $text */

?>
<section class="my-list">
    <div class="my-list__wrapper">
        <h1>Мои задания</h1>
        <? foreach ($tasks as $task): ?>
            <div class="new-task__card">
                <div class="new-task__title">
                    <a href="/tasks/<?= $task->id ?>" class="link-regular"><h2><?= $task->name ?></h2></a>
                    <div class="links" style="display: flex;margin-left: -10px;">
                        <? foreach ($task->categories as $category): ?>
                            <a class="new-task__type link-regular" style="margin-left: 10px;"
                               href="<?= '/category/' . $category['slug'] ?>">
                                <p><?= $category['name'] ?></p>
                            </a>
                        <? endforeach; ?>
                    </div>
                </div>
                <div class="task-status done-status" style="margin-bottom: 10px;"><?= $text ?></div>
                <p class="new-task_description"><?= $task->description ?></p>
                <? if (count($task->response)): ?>
                    <? foreach ($task->response as $response): ?>
                        <div class="feedback-card__top">
                            <a href="/users/<?= $response->user->id ?>">
                                <img src="/uploads/user-images/<?= $response->user->avatar ?>" alt="" width="36"
                                     height="36">
                            </a>
                            <div class="feedback-card__top--name my-list__bottom">
                                <p class="link-name">
                                    <a href="#" class="link-regular"><?= $response->user->username ?></a>
                                </p>
                                <?
                                $count = 0;
                                foreach ($task->messages as $message) {
                                    if ($message->owner_id == $user->id && $message->worker_id == $response->user->id) {
                                        $count++;
                                    }
                                }
                                ?>
                                <a href="/tasks/<?= $task->id ?>#chat-container"
                                   class="my-list__bottom-chat <?= $count ? 'my-list__bottom-chat--new' : '' ?>"><b><?= $count ?: "" ?></b></a>
                                <?= $response->user->rate ? Rate::widget(['rate' => $response->user->rate, 'option' => 'stars-and-rate']) : "" ?>
                            </div>
                        </div>
                    <? endforeach; ?>
                <? endif; ?>
            </div>
        <? endforeach; ?>
    </div>
</section>
