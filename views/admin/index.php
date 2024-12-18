<?php
$assocs = [];
foreach (UserAssociate::search(1) as $assoc) {
    if (!isset($assocs[$assoc->user_id])) {
        $assocs[$assoc->user_id] = [];
    }
    $assocs[$assoc->user_id][] = $assoc;
}

?>
<?= $this->partial('common/header', $this) ?>
<?= $this->partial('admin/header', ['page' => 'index']) ?>
<table class="table">
    <thead>
        <tr>
            <th>使用者代碼</th>
            <th>顯示名稱</th>
            <th>關聯</th>
            <th>是否為管理員</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach (User::search(1) as $user) { ?>
            <tr>
                <td><?= $user->user_id ?></td>
                <td><?= $this->escape($user->name) ?></td>
                <td>
                    <ul>
                        <?php foreach ($assocs[$user->user_id] ?? [] as $assoc) { ?>
                        <li>
                        [<?= UserAssociate::getSourceName($assoc->source_id) ?>]
                        <?= $assoc->uid ?></li>
                        <?php } ?>
                    </ul>
                </td>
                <td><?= $user->is_admin ? 1 : '' ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<hr>
<h1>新增管理員</h1>
<form method="post" action="/admin/addadmin">
    <input type="hidden" name="csrf_token" value="<?= $this->csrf_token ?>">
    <div class="form-group">
        <label for="user_id">Email</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>
    <button type="submit" class="btn btn-primary">新增</button>
</form>
<?= $this->partial('common/footer') ?>
