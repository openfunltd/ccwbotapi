<?php
$follows = [];
$users = [];
foreach (UserFollow::search(1) as $follow) {
    $id = $follow->type . ':' . $follow->follow_key;
    if (!isset($follows[$id])) {
        $follows[$id] = [];
    }
    $follows[$id][] = $follow;
    $users[$follow->user_id] = true;
}

foreach (User::search(['user_id' => array_keys($users)]) as $user) {
    $users[$user->user_id] = $user;
}

?>
<?= $this->partial('common/header', $this) ?>
<?= $this->partial('admin/header', ['page' => 'follow']) ?>
<table class="table">
    <thead>
        <tr>
            <th>Type</th>
            <th>key</th>
            <th>count</th>
            <th>users</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($follows as $id => $follow) { ?>
        <tr>
            <td><?= explode(':', $id)[0] ?></td>
            <td><?= explode(':', $id, 2)[1] ?></td>
            <td><?= count($follow) ?></td>
            <td>
                <ul>
                    <?php foreach ($follow as $f) { ?>
                    <li><?= $users[$f->user_id]->name ?></li>
                    <?php } ?>
                </ul>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?= $this->partial('common/footer') ?>
