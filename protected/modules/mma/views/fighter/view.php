<? $this->page_title = $fighter->full_name; ?>

<table cellpadding="0" cellspacing="0" border="0" class="fighter-view-big">
    <tr valign="top">
        <td style="width: 200px;padding-right: 10px">
            <?= $fighter->getImageLink() ?>
        </td>
        <td valign="top" style="padding-left: 7px;width: 260px">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="2" style="padding-bottom: 15px">
                        <table border="0" cellspacing="0" cellpadding="0" style="margin-top: 10px;">
                            <tr style="vertical-align: top;line-height: 17px">
                                <td>
                                    <span class="fighter-age"><?= $fighter->age ?></span>
                                    <span class="fighter-params">веc: <?= $fighter->weight_value ?></span>
                                    <span class="fighter-params">рост: <?= $fighter->height_value ?></span>
                                <td style="padding-left: 30px">
                                    <span class="fighter-country"><?= $fighter->city ?></span>
                                    <span class="fighter-club"><?= $fighter->club_link ?></span>
                                    <span class="fighter-class"><?= $fighter->class_value ?></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <? foreach(array('wins', 'losses') as $label):  ?>
                    <?
                    $attr_prefix              = $label == 'wins' ? 'win_' : 'loss_';
                    $ko_attr_percent          = $attr_prefix . 'ko_percent';
                    $submissions_attr_percent = $attr_prefix . 'submissions_percent';
                    $decisions_attr_percent   = $attr_prefix . 'decisions_percent';

                    $ko_attr_value          = $attr_prefix . 'ko';
                    $submissions_attr_value = $attr_prefix . 'submissions';
                    $decisions_attr_value   = $attr_prefix . 'decisions';
                    ?>
                    <tr valign="top">
                        <td style="width: 50px">
                            <span class="label record <?= $label ?>">
                                <?= ($label == 'wins' ? "победы" : "поражения")  ?> <br/>
                                <span><?= $fighter->$label ?></span>
                            </span>
                        </td>
                        <td>
                            <table  class="fights-statistic-tbl" border="0">
                                <tr>
                                    <td style="width: 75px">
                                        <div class="progress progress-danger active">
                                            <div class="bar" style="width: <?= $fighter->$ko_attr_percent?>%;"></div>
                                        </div>
                                    </td>
                                    <td class="method-label <?= $label ?>">
                                        <?= $fighter->$ko_attr_value ?> ko/tko (<i><?= $fighter->$ko_attr_percent ?>%</i>)
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="progress progress-success active">
                                            <div class="bar" style="width: <?= $fighter->$submissions_attr_percent ?>%;"></div>
                                        </div>
                                    </td>
                                    <td class="method-label <?= $label ?>">
                                        <?= $fighter->$submissions_attr_value ?> сдачей (<i><?= $fighter->$submissions_attr_percent ?>%</i>)
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="progress progress-warning active">
                                            <div class="bar" style="width: <?= $fighter->$decisions_attr_percent ?>%;"></div>
                                        </div>
                                    </td>
                                    <td class="method-label <?= $label ?>">
                                        <?= $fighter->$decisions_attr_value ?> решением (<i><?= $fighter->$decisions_attr_percent ?>%</i>)
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                <? endforeach ?>
            </table>
        </td>
    </tr>
</table>
