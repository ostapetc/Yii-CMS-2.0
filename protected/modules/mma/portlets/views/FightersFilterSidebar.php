
<ul class="nav nav-list page-info-sidebar">
    <li class="nav-header">Поиск бойца</li>
    <li>
        <?= CHtml::textField('fighter-filter-name', '', ['id' => 'fighter-filter-name', 'placeholder' => 'по имени, фамилии, прозвищу']) ?>
    </li>
    <li>
        <?= CHtml::textField('fighter-filter-association', '', ['id' => 'association', 'placeholder' => 'по клубу']) ?>
    </li>
    <li>
        <?= CHtml::label('Весовая категория', 'fighter-filter-class') ?>
        <?= CHtml::dropDownList('fighter-filter-class', '', Fighter::$class_options, ['empty' => 'не указана']) ?>
    </li>
</ul>
