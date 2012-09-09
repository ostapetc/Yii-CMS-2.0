<script id="template-upload" type="text/x-jquery-tmpl">
    <tr class="template-upload{{if error}} ui-state-error{{/if}}">
        <td class="preview"></td>
        <td class="title">${title}</td>
        <td class="descr">${text}</td>
        {{if error}}
        <td class="error" colspan="2">Error:
            {{if error === 'maxFileSize'}}<? echo Yii::t('MediaModule.interface', 'Файл слишком велик') ?>
            {{else error === 'minFileSize'}}<? echo Yii::t('MediaModule.interface', 'Файл слишком мал') ?>
            {{else error === 'acceptFileTypes'}}<? echo Yii::t('MediaModule.interface', 'Запрещенный тип файла') ?>
            {{else error === 'maxNumberOfFiles'}}<? echo Yii::t('MediaModule.interface', 'Превышено колличество файлов') ?>
            {{else}}${error}
            {{/if}}
        </td>
        {{else}}
        <td class="progress-holder start">
            <div></div>
            <button>Start</button>
        </td>
        {{/if}}
        <td class="cancel">
            <button class="btn btn-danger">
                <i class="icon-remove"></i>
            </button>
        </td>
    </tr>
</script>
<script id="template-download" type="text/x-jquery-tmpl">
    <tr id="${id}" class="template-download{{if error}} ui-state-error{{/if}}">
        {{if error}}
        <td></td>
        <td class="{title}">${title}</td>
        <td class="error" colspan="2">Error:
            {{if error === 1}}  <? echo Yii::t('MediaModule.interface', 'Файл превышает размер допустимый сервером (php.ini директива)') ?>
            {{else error === 2}}<? echo Yii::t('MediaModule.interface', 'файл слишком велик (HTML директива)') ?>
            {{else error === 3}}<? echo Yii::t('MediaModule.interface', 'Только часть файла была загружена') ?>
            {{else error === 4}}<? echo Yii::t('MediaModule.interface', 'Файл не был загружен') ?>
            {{else error === 5}}<? echo Yii::t('MediaModule.interface', 'Пропущена временная директория') ?>
            {{else error === 6}}<? echo Yii::t('MediaModule.interface', 'Ошибка при записи файла на диск') ?>
            {{else error === 7}}<? echo Yii::t('MediaModule.interface', 'Неверное расширение файла') ?>
            {{else error === 'maxFileSize'}}<? echo Yii::t('MediaModule.interface', 'Файл слишком велик') ?>
            {{else error === 'minFileSize'}}<? echo Yii::t('MediaModule.interface', 'Файл слишком мал') ?>
            {{else error === 'acceptFileTypes'}}<? echo Yii::t('MediaModule.interface', 'Запрещенный тип файла') ?>
            {{else error === 'maxNumberOfFiles'}}<? echo Yii::t('MediaModule.interface', 'Превышено колличество файлов') ?>
            {{else error === 'uploadedBytes'}}<? echo Yii::t('MediaModule.interface', 'Загружаемый файлы превысил допустимые размеры') ?>
            {{else error === 'emptyResult'}}<? echo Yii::t('MediaModule.interface', 'Файл пуст') ?>
            {{else}}${error}
            {{/if}}
        </td>
        {{else}}
        <td class="preview">
            {{if thumbnail_url}}
            {{html thumbnail_url}}
            {{/if}}
        </td>
        <? foreach ($this->fields as $field=> $sett): ?>
        <td style="width: <? echo $sett['size'];?>px;">
            <div class="<? echo $field ?> editable" data-attr="<? echo $field;?>" data-editable-type="<? echo $sett['type'];?>"
                 data-save-url="${edit_url}">
                <span>${<? echo $field;?>}</span>
            </div>
        </td>
        <? endforeach; ?>
        <td class="dnd-handler">
            <i class="icon-sortable"></i>
        </td>
        {{/if}}
        <td class="delete">
            <button data-type="${delete_type}" data-url="${delete_url}" class="btn btn-danger btn-small">
                <i class="icon-remove"></i>
            </button>
        </td>
    </tr>
</script>
