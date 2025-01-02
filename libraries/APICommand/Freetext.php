<?php

class APICommand_Freetext extends APICommand
{
    public static $name = '自由輸入文字';
    public static $description = '隨意輸入文字，供機器人使用';
    public static $params = [
        '對話內容',
    ];

    public static function run($params, $user = null)
    {
        $message = $params[0];

        // 如果有行政區名稱，就回傳該行政區的資訊
        $matches = DataHelper::matchData('towns', $message);
        if (count($matches['keys']) > 1) {
            // TODO: 之後支援多個行政區和選區
            return '一次只能查一個行政區，請問你要查哪一個？';
        } elseif (count($matches['keys']) == 1) {
            return APICommand::query('Area', [$matches['keys'][0]]);
        }

        // 如果有立委姓名的話，就回傳立委的資訊
        $matches = DataHelper::matchData('legislators', $message);
        if (count($matches['keys']) > 1) {
            // TODO: 之後支援多個立委
            return '一次只能查一個立委，請問你要查哪一個？';
        } elseif (count($matches['keys']) == 1) {
            return APICommand::query('Legislator', [$matches['keys'][0]]);
        }

        // 如果有法律名稱的話，就回傳法律的資訊
        $matches = DataHelper::matchData('laws', $message);
        if (count($matches['keys']) > 1) {
            // TODO: 之後支援多個法律
            return '一次只能查一個法律，請問你要查哪一個？';
        } elseif (count($matches['keys']) == 1) {
            return APICommand::query('Law', [$matches['results'][0]['代碼']]);
        }

        // 如果有立委名稱，就回傳給立委的資訊
        return 'TODO: 不認得的指令，需要提示教使用者怎麼使用這個功能';
    }
}
