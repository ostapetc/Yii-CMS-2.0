<style type="text/css">
    #message-dialogs-ul a {
        padding-left: 0;
    }
</style>

<h4><?= t('Диалоги') ?></h4>

<? if ($users): ?>
    <ul class="nav nav-pills nav-stacked" id="message-dialogs-ul">
        <? foreach ($users as $user): ?>
            <li>
                <a href="<?= $this->createUrl('/social/message/index', array('to_user_id' => $user['id'])); ?>">
                    <?= $user->photo_html ?>
                    <?= $user->name ?>
                </a>
            </li>
        <? endforeach ?>
    </ul>
<? else: ?>
    <blockquote><?= t('не найдены') ?></blockquote>
<? endif ?>