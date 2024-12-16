<?php

class AdminController extends MiniEngine_Controller
{
    public function init()
    {
        if (!$user_id = MiniEngine::getSession('user_id')) {
            return $this->redirect('/');
        }
        if (!$user = User::find($user_id)) {
            return $this->redirect('/');
        }
        if (!$user->is_admin) {
            return $this->redirect('/');
        }
        $this->view->user = $user;
    }

    public function indexAction()
    {
    }
}

