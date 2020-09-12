<?php


namespace htmlacademy\controllers;


class CompleteAction extends AbstractAction
{
    public function getName()
    {
        return 'Выполнено';
    }

    public function getRealName()
    {
        return 'action_complete';
    }

    public function isRightMethod($user_id, $owner_id, $worker_id)
    {
        if ($user_id == $owner_id) {
            return true;
        }
        return false;
    }
}