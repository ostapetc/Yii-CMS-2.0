<?php $this->page_title = Yii::t('FaqModule.main', 'Часто задаваемые вопросы'); ?>

<div class="submit_feedback">
    <a href="<?php echo $this->url("/faq/create"); ?>"><?php echo Yii::t('FaqModule.main', 'задать вопрос'); ?></a>
</div>

<br/>

<?php if ($sections): ?>
    <b><?php echo Yii::t('FaqModule.main', 'Разделы'); ?></b>

    <ul style="margin-left:20px;margin-top:20px">
        <?php foreach ($sections as $section): ?>
            <li>
                <a href="<?php echo $this->url("/faq/section/{$section->id}"); ?>">
                    <?php echo $section->name; ?>
                </a>
                <br/>
                <br/>
            </li>
        <?php endforeach ?>
    </ul>
<?php endif ?>
