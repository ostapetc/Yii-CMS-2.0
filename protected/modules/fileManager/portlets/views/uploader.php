<div id="<?php echo $this->id ?>" class="uploader portlet-content" style="display: none">
    <div class="fileupload-buttonbar">
        <label class="fileinput-button">
            <span>Добавить файлы...</span>
            <input type="file" name="file" multiple>
        </label>
        <button type="submit" class="start">Начать загрузку</button>
    </div>
    <div id="<?php echo $this->id ?>-drop-zone" class="drop-zone">
        Перетащите сюда файлы
    </div>
    <div class="fileupload-content">
        <table class="files">
            <thead>
                <tr>
                    <th style="width: 60px"></th>
                    <?php foreach ($this->fields as $header): ?>
						<th style="width: 150px"><?php echo $header['header'];?></th>
					<?php endforeach; ?>
                    <th style="width: 100px">Сортировка</th>
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
