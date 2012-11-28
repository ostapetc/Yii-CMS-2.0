<table class="message-tbl">
    <tr valign="top">
        <td class="message-avatar">
            <?= $data->from_user->photo_html ?>
        </td>
        <td>
            <span class="message-date"><?= $data->value('date_create') ?></span>
            <span class="message-username"><?= $data->from_user->link ?></span>
            <br clear="all" />
            <div class="message-text"><?= CHtml::encode($data->text) ?></div>
        </td>
    </tr>
</table>

<hr/>