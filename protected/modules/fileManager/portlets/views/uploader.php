<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3><?= $this->title ?></h3>
</div>
<div class="modal-body">
        <div class="fileupload-buttonbar">
            <span class="btn btn-success fileinput-button">
                <i class="icon-plus icon-white"></i>
                <span>Добавить файлы...</span>
                <input type="file" name="file" multiple="">
            </span>
            <div class="clear"></div>
        </div>
        <div id="<? echo $this->id ?>-drop-zone" class="drop-zone">
            Перетащите сюда файлы
        </div>
        <div class="fileupload-content">
            <table class="files">
                <thead>
                <tr>
                    <th style="width: 60px"></th>
                    <? foreach ($this->fields as $header) { ?>
                    <th style="width: 150px"><? echo $header['header'];?></th>
                    <? } ?>
                    <th style="width: 50px"></th>
                    <th style="width: 50px">Размер</th>
                    <th style="width: 50px"></th>
                    <th style="width: 50px">Удалить</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div class="fileupload-progressbar"></div>
        </div>
</div>
<div class="modal-footer">
    <a class="btn btn-primary" href="#" data-dismiss="modal">Сохранить</a>
</div>
