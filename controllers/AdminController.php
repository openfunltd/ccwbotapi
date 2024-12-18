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
        $this->init_csrf();
    }

    public function indexAction()
    {
    }

    public function followAction()
    {
    }

    public function addadminAction()
    {
        if ($_POST['csrf_token'] != MiniEngine::getSession('csrf_token')) {
            return $this->alert('Invalid CSRF token', '/admin');
        }
        if (UserAssociate::search(['source_id' => 1, 'uid' => $_POST['email']])->first()) {
            return $this->alert('User already exists', '/admin');
        }
        $user = User::insert([
            'name' => explode('@', $_POST['email'])[0],
            'created_at' => time(),
            'is_admin' => 1,
        ]);
        UserAssociate::insert([
            'source_id' => 1,
            'uid' => $_POST['email'],
            'user_id' => $user->user_id,
        ]);
        return $this->alert("新增管理者 {$_POST['email']} 成功", '/admin');
    }
}

