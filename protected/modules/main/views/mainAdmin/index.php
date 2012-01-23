<?php
Yii::app()->clientScript->registerCssFile($this->module->assetsUrl() . '/css/modules.css');

$this->page_title = 'Модули';
$this->tabs = array();
?>

<?php foreach ($modules as $class => $data): ?>
    <?php $assets_dir = Yii::app()->getModule($data['dir'])->assetsUrl(); ?>
    <table class="modules">
        <tr valign="top">
            <td class="image">
                <img src="<?php echo $assets_dir . "/img/icon.png"; ?>" border="0" />
            </td>
            <td>
				<h3><?php echo $data["name"]; ?></h3> &nbsp;
				<span class='version'>версия <?php echo $data["version"]; ?></span>
				<br clear="all" />
				<?php echo $data["description"]; ?>
				<br/><br/>

				<?php if (isset($data['admin_menu'])): ?>
					<?php foreach ($data['admin_menu'] as $title => $url): ?>
						<a href="<?php echo $url ?>"><?php echo $title ?></a>
					<?php endforeach ?>
				<?php endif ?>

            </td>
        </tr>
    </table>
    <div class='separator'></div>
<?php endforeach ?>


