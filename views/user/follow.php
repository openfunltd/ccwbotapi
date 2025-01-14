<?= $this->partial('common/header', $this) ?>
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
            <td>
                <form method="post" action="?method=delete&type=<?= intval($follow->type) ?>&follow_key=<?= urlencode($follow->follow_key) ?>">
                    <input type="hidden" name="csrf_token" value="<?= $this->csrf_token ?>">
                    <button type="submit" class="btn btn-danger">取消追蹤</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?= $this->partial('common/footer') ?>
