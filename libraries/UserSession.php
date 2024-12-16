<?php

class UserSession
{
    public static function login($source, $uid, $name)
    {
        $source_id = UserAssociate::getSourceId($source);
        if ($assoc = UserAssociate::search(['source_id' => $source_id, 'uid' => $uid])->first()) {
            MiniEngine::setSession('user_id', $assoc->user_id);
            return;
        }

        if ($source == 'google' and count(User::search(1)) == 0) {
            // auto create first admin user
            $user = User::insert([
                'name' => $name,
                'created_at' => time(),
                'is_admin' => 1,
            ]);
            UserAssociate::insert([
                'source_id' => $source_id,
                'uid' => $uid,
                'user_id' => $user->user_id,
            ]);
            MiniEngine::setSession('user_id', $user->user_id);
            return;
        }

        throw new Exception('User not found');
    }

    public static function logout()
    {
        MiniEngine::setSession('user_id', null);
    }
}
