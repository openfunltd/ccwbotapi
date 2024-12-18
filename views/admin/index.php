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
            <th>ID</th>
            <th>Name</th>
            <th>Associates</th>
            <th>is_admin</th>
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
<?= $this->partial('common/footer') ?>
