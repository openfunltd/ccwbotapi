<?php
$features = [
    'index' => '用戶',
    'follow' => '追蹤',
];
?>
<ul class="nav nav-tabs">
    <?php foreach ($features as $key => $feature) { ?>
        <li class="nav-item">
        <a class="nav-link <?= $this->if($this->page === $key, 'active', '') ?>" href="/admin/<?= $key ?>">
            <?= $this->escape($feature) ?>
        </a>
        </li>
    <?php } ?>
</ul>
