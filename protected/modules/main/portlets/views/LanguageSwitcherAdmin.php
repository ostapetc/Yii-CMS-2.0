<?php
$selected_lang = isset(Yii::app()->session["admin_panel_lang"]) ? Yii::app()->session["admin_panel_lang"] : null;

$cs = Yii::app()->clientScript;
$cs->registerScriptFile('/js/admin/language_switcher.js');
$cs->registerCssFile('/css/admin/language_switcher.css');
?>

<div id="country-select">
    <form action="/main/mainAdmin/SessionLanguage" id="select-lang-form">
        <select id="country-options" name="lang">
            <?php foreach ($langs as $lang): ?>
                <?php
                $selected = "";
                if ($selected_lang && $selected_lang == $lang->id)
                {
                    $selected = "selected";
                }
                ?>
                <option value="<?php echo $lang->id; ?>" <?php echo $selected; ?>><?php echo $lang->name; ?></option>
            <?php endforeach ?>
        </select>
        <input type="hidden" name="back_url" value="<?php echo base64_encode($_SERVER["REQUEST_URI"]); ?>">
        <input value="Select" type="submit"/>
    </form>
</div>