<h1>Список заказанных товаров</h1>
<div style='width:500px; margin:30px;'>
    <?php
    $this->widget('mailer.portlets.GridMail', array(
        'id'          => 'order-product-grid',
        'dataProvider'=> $dataProvider,
        //-@var string стили для тега <tbody>
        'tableStyle'  => 'padding:0; border:1px #ccc solid; margin:0; width: 500px;',
        //- @var string стили для тега <td> вложенного в <tbody>
        'tdbodyStyle' => 'text-align:right; padding: 10px;',
        //- @var string стили для тега <tr> вложенного в <thead>
        'trheadStyle' => '',
        //- @var string стили для тега <tbody>
        'tbodyStyle'  => '',
        //- @var string стили для тнга <thead>
        'theadStyle'  => 'background-color:#eee',
        //-@var string стили для четных строк тега <tr>
        'trStyleOdd'  => 'background-color:#FFF;border:1px #f0f0f0 solid;',
        //-@var string стили для нечетных строк тега <tr>
        'trStyleEven' => 'background-color:#FFF;border:1px #fff solid;',
        'summaryText' => 'Общаяя сумма {count}-ти товаров {totalSum}.',
        //-@var string стили для тега <th> вложенного в <thead>
        'theadThStyle'=> 'padding:5px;margin:0;',
        //-@var string стили для тега <tfoot>
        'tfootStyle'  => 'padding:0;',
        //-@var string стили для тега <tr> вложенного в <tfoot>
        'tfootTrStyle'=> '',
        //-@var string стили для тега <div>
        'summaryStyle'=> 'text-align:right; border:none;',
        'columns'     => array(
            'id',
            'title',
            'quantity',
            'price',
            'variant_title',
            array(
                'header'=> 'variant_value',
                'value' => '$data->variant_value'
            )
        ),
    )); ?>
</div>