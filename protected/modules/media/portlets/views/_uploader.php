<div id="<?= $this->id ?>">
    <div class="fileupload-buttonbar">
        <span class="btn btn-success fileinput-button">
            <i class="icon-plus icon-white"></i>
            <span>Добавить файлы...</span>
            <input type="file" name="file" <? echo $this->multiple ? 'multiple=""' : '' ?> />
        </span>
        <span>Или</span>
        <input placeholder="Вставьте ссылку на ресурс" type="text" class="link-parser"  />
        <br class="clear"/>
    </div>
    <div id="<? echo $this->id ?>-drop-zone" class="drop-zone">
        Перетащите сюда файлы
    </div>
    <div class="fileupload-content">
        <table class="files">
            <thead>
            <tr>
                <th style="width:<?php echo $this->preview_width ?>"></th>
                <? foreach ($this->fields as $header) { ?>
                <th style="width: 250px"><? echo $header['header'];?></th>
                <? } ?>
                <th style="width: 50px"></th>
                <th style="width: 50px">Удалить</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
        <div class="fileupload-progressbar"></div>
    </div>
</div>