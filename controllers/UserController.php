<?php

class UserController extends MiniEngine_Controller
{
    public function googleloginAction()
    {
        $return_to = 'https://' . $_SERVER['HTTP_HOST'] . '/user/googledone';
        $url = 'https://accounts.google.com/o/oauth2/auth?'
            . '&state='
            . '&scope=email%20profile'
            . '&redirect_uri=' . urlencode($return_to)
            . '&response_type=code'
            . '&client_id=' . getenv('GOOGLE_CLIENT_ID')
            . '&access_type=offline';
        return $this->redirect($url);
    }

    public function googledoneAction()
    {
        $return_to = 'https://' . $_SERVER['HTTP_HOST'] . '/user/googledone';

        $params = array();
        $params[] = 'code=' . urlencode($_GET['code']);
        $params[] = 'client_id=' . urlencode(getenv('GOOGLE_CLIENT_ID'));
        $params[] = 'client_secret=' . urlencode(getenv('GOOGLE_CLIENT_SECRET'));
        $params[] = 'redirect_uri=' . urlencode($return_to);
        $params[] = 'grant_type=authorization_code';
        $curl = curl_init('https://www.googleapis.com/oauth2/v3/token');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, implode('&', $params));
        $obj = json_decode(curl_exec($curl));
        if (!$obj->id_token) {
            return $this->alert('login failed', '/');
        }
        $tokens = explode('.', $obj->id_token);
        $login_info = json_decode(base64_decode($tokens[1]));
        if (!$login_info->email or !$login_info->email_verified) {
            return $this->alert('login failed', '/');
        }
        $email = $login_info->email;
        // get profile
        $curl = curl_init('https://people.googleapis.com/v1/people/me?personFields=names,emailAddresses');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $obj->access_token));
        $profile = json_decode(curl_exec($curl));

        UserSession::login('google', $email, $profile->names[0]->displayName);
        return $this->redirect('/');
    }

    public function logoutAction()
    {
        UserSession::logout();
        return $this->redirect('/');
    }

    public function tokenAction()
    {
        $token = $_GET['token'] ?? '';
        $next = $_GET['next'] ?? '/';
        $user = APICommand::getUserByToken($token, true);
        if (!$user) {
            return $this->alert('登入失敗', '/');
        }
        MiniEngine::setSession('user_id', $user->user_id);
        return $this->redirect($next);
    }
}
