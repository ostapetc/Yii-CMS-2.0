<script id="template-upload" type="text/x-jquery-tmpl">
    <tr class="template-upload{{if error}} ui-state-error{{/if}}">
        <td class="preview"></td>
        <td class="title">${title}</td>
        <td class="descr">${text}</td>
        {{if error}}
        <td class="error" colspan="2">Error:
            {{if error === 'maxFileSize'}}<?php echo Yii::t('FileManagerModule.interface', 'Файл слишком велик') ?>
            {{else error === 'minFileSize'}}<?php echo Yii::t('FileManagerModule.interface', 'Файл слишком мал') ?>
            {{else error === 'acceptFileTypes'}}<?php echo Yii::t('FileManagerModule.interface', 'Запрещенный тип файла') ?>
            {{else error === 'maxNumberOfFiles'}}<?php echo Yii::t('FileManagerModule.interface', 'Превышено колличество файлов') ?>
            {{else}}${error}
            {{/if}}
        </td>
        {{else}}
        <td class="progress">
            <div></div>
        </td>
        <td class="size">${sizef}</td>
        <td class="start">
            <button>Start</button>
        </td>
        {{/if}}
        <td class="cancel">
            <button>Cancel</button>
        </td>
    </tr>
</script>
<script id="template-download" type="text/x-jquery-tmpl">
    <tr id="${id}" class="template-download{{if error}} ui-state-error{{/if}}">
        {{if error}}
        <td></td>
        <td class="{title}">${title}</td>
        <td class="size">${size}</td>
        <td class="error" colspan="2">Error:
            {{if error === 1}}  <?php echo Yii::t('FileManagerModule.interface', 'Файл превышает размер допустимый сервером (php.ini директива)') ?>
            {{else error === 2}}<?php echo Yii::t('FileManagerModule.interface', 'файл слишком велик (HTML директива)') ?>
            {{else error === 3}}<?php echo Yii::t('FileManagerModule.interface', 'Только часть файла была загружена') ?>
            {{else error === 4}}<?php echo Yii::t('FileManagerModule.interface', 'Файл не был загружен') ?>
            {{else error === 5}}<?php echo Yii::t('FileManagerModule.interface', 'Пропущена временная директория') ?>
            {{else error === 6}}<?php echo Yii::t('FileManagerModule.interface', 'Ошибка при записи файла на диск') ?>
            {{else error === 7}}<?php echo Yii::t('FileManagerModule.interface', 'Неверное расширение файла') ?>
            {{else error === 'maxFileSize'}}<?php echo Yii::t('FileManagerModule.interface', 'Файл слишком велик') ?>
            {{else error === 'minFileSize'}}<?php echo Yii::t('FileManagerModule.interface', 'Файл слишком мал') ?>
            {{else error === 'acceptFileTypes'}}<?php echo Yii::t('FileManagerModule.interface', 'Запрещенный тип файла') ?>
            {{else error === 'maxNumberOfFiles'}}<?php echo Yii::t('FileManagerModule.interface', 'Превышено колличество файлов') ?>
            {{else error === 'uploadedBytes'}}<?php echo Yii::t('FileManagerModule.interface', 'Загружаемый файлы превысил допустимые размеры') ?>
            {{else error === 'emptyResult'}}<?php echo Yii::t('FileManagerModule.interface', 'Файл пуст') ?>
            {{else}}${error}
            {{/if}}
        </td>
        {{else}}
        <td class="preview">
            {{if thumbnail_url}}
            {{html thumbnail_url}}
            {{/if}}
        </td>
        <?php foreach ($this->fields as $field=>$sett): ?>
			<td style="width: <?php echo $sett['size'];?>px;">
				<div class="<?php echo $field ?> editable" data-attr="<?php echo $field;?>" data-editable-type="<?php echo $sett['type'];?>"
                     data-save-url="${edit_url}">
					<span>${<?php echo $field;?>}</span>
				</div>
			</td>
		<?php endforeach; ?>
        <td class="dnd-handler"><img height="20" src="<?php echo $this->assets?>/img/hand.png"/></td>
        <td class="size">${size}</td>
        {{/if}}
        <td></td>
        <td class="delete">
            <button data-type="${delete_type}" data-url="${delete_url}">Удалить</button>
        </td>
    </tr>
</script>
