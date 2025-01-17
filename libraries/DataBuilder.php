<?php

class DataBuilder
{
    public static function buildMeet($origin_data, $user = null)
    {
        $data = new StdClass;
        $data->會議名稱 = $origin_data->name;
        $data->會議代碼 = $origin_data->會議代碼;
        $data->日期 = $origin_data->日期;
        $data->會議種類 = $origin_data->會議種類;
        $data->會議事由 = $origin_data->會議資料[0]->會議事由 ?? '';
        $data->委員會 = $origin_data->{'委員會代號:str'} ?? [];
        $data->相關法律 = [];
        if ($data->會議種類 != '院會') {
            foreach ($origin_data->議事網資料 ?? [] as $record) {
                foreach ($record->關係文書->議案 ?? [] as $bill) {
                    foreach ($bill->{'法律編號'} ?? [] as $idx => $law_id) {
                        $data->相關法律[] = [
                            $law_id,
                            $bill->{'法律編號:str'}[$idx],
                        ];
                    }
                }
            }
            $data->相關法律 = array_values(array_unique($data->相關法律));
        }

        $data->actions = [];
        if ($origin_data->會議資料[0]->ppg_url ?? false) {
            $data->actions[] = [
                'name' => '原始資料',
                'method' => '_link',
                'link' => $origin_data->會議資料[0]->ppg_url,
            ];
        }
        return $data;
    }

    public static function buildIVOD($data, $user = null)
    {
        $data->actions = [];
        $data->actions[] = [
            'name' => '原始資料',
            'method' => '_link',
            'link' => $data->IVOD_URL,
        ];
        if ($data->會議資料 ?? false) {
            $data->actions[] = [
                'name' => '會議資料',
                'method' => 'Meet',
                'params' => [$data->會議資料->會議代碼],
            ];
        }
        return $data;
    }

    public static function buildLegislator($data, $user = null)
    {
        $data->actions = [];
        $data->actions[] = [
            'name' => '最近發言',
            'method' => 'LegislatorIVOD',
            'params' => [$data->委員姓名],
        ];
        if ($user and $user->isFollow(1, $data->委員姓名)) {
            $data->actions[] = [
                'name' => '取消追蹤立委',
                'method' => 'Unfollow',
                'params' => ['立委', $data->委員姓名],
            ];
        } else {
            $data->actions[] = [
                'name' => '追蹤立委',
                'method' => 'Follow',
                'params' => ['立委', $data->委員姓名],
            ];
        }   
        return $data;
    }

    public static function buildLaw($data, $user = null)
    {
        $data->actions = [];
        if ($user and $user->isFollow(2, $data->法律編號)) {
            $data->actions[] = [
                'name' => '取消追蹤法律',
                'method' => 'Unfollow',
                'params' => ['法律', $data->法律編號],
            ];
        } else {
            $data->actions[] = [
                'name' => '追蹤法律',
                'method' => 'Follow',
                'params' => ['法律', $data->法律編號],
            ];
        }
        $data->actions[] = [
            'name' => '關聯議案',
            'method' => 'LawBill',
            'params' => [$data->法律編號],
        ];
        return $data;
    }

    public static function buildBill($data, $user = null)
    {
        $data->actions = [];
        $data->actions[] = [
            'name' => '原始資料',
            'method' => '_link',
            'link' => "https://ppg.ly.gov.tw/ppg/bills/{$data->議案編號}/details",
        ];
        foreach (array_combine($data->法律編號 ?? [], $data->{'法律編號:str'} ?? []) as $law_id => $law_name) {
            $data->actions[] = [
                'name' => "查看法律 {$law_name}",
                'method' => 'Law',
                'params' => [$law_id],
            ];
        }
        return $data;
    }
}
