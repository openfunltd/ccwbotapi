<?= $this->partial('common/header', $this) ?>
<?= $this->partial('admin/header', ['page' => 'follow']) ?>
<table class="table">
    <thead>
        <tr>
            <th>追蹤種類</th>
            <th>追蹤目標</th>
            <th>動作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->user->follows as $follow) { ?>
        <tr>
            <td><?= UserFollow::typeMap()[$follow->type] ?? '' ?></td>
            <td><?= $this->escape($follow->follow_key) ?></td>
            <td></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?= $this->partial('common/footer') ?>
