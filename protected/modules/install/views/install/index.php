<p>Системные требования:</p>
<table class="table table-striped table-bordered table-condensed">
    <thead>
        <tr></tr>
    </thead>
    <tbody>
        <? foreach ($support as $technology => $data) { ?>
            <tr class="<?= $data['is_support'] ? 'support' : 'not-support'; ?>">
                <td><?= $technology ?></td>
                <td><?= $data['version'] ?></td>
                <td><?= $data['minimal_version'] ?></td>
            </tr>
        <? } ?>
    </tbody>
</table>

<a class="btn" href="<?= $this->createUrl('step1') ?>">Продолжить &rarr;</a>
