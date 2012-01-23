<ul id="menu_port">
<a href="#" style="padding-top:20px !important;">
    <img src="/images/site/bottom_z.png" width="209" height="42" alt="Заказать сайт"/>
</a>
</ul>


<div id="result_port">
    <div id="panel_port" class="cf">
        <span id="hh"><?php Yii::t('Content.main', 'Контакты'); ?></span>
        <div id="navigator">
            <a href="/" id="aHome">AGA-studio</a> / <span>Контакты</span>
        </div>
    </div>
    <div id="panel_line"></div>

    <div id="frontContact" class="cf">
        <?php echo PageBlock::model()->getText('contacts'); ?>

        <form id="letter"><label>Введите Ваше имя:<br/>
            <input type="text"/></label><br/>
            <label>Адрес e-mail:<br/>
                <input type="text"/></label><br/>
            <label>Тема сообщения:<br/>
                <input type="text"/></label><br/>
            <br/>
            <label class="texta">Введите текст сообщения:<br/>
                <textarea></textarea></label><br/>

            <input type="submit" id="sub" value=" "/></form>
    </div>
</div>


