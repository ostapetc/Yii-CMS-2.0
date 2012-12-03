<div class="well fighter-view-small" style="width: 635px;padding:10px">
    <table cellpadding="0" cellspacing="0" border="0">
            <tr valign="top">
                <td style="width: 140px">
                    <?= $fighter->getImageLink() ?>
                </td>
                <td valign="top" style="padding-left: 7px;width: 260px">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="2" style="padding-bottom: 7px">
                                <?= $fighter->link ?>
                            </td>
                        </tr>

                        <? foreach(array('wins', 'losses') as $label):  ?>
                            <?
                            $attr_prefix              = $label == 'wins' ? 'win_' : 'loss_';
                            $ko_attr_percent          = $attr_prefix . 'ko_percent';
                            $submissions_attr_percent = $attr_prefix . 'submission_percent';
                            $decisions_attr_percent   = $attr_prefix . 'decisions_percent';

                            ?>
                            <tr valign="top">
                                <td style="width: 50px">
                                    <span class="label record">
                                        <?= $label ?> <br/>
                                        <span><?= $fighter->wins ?></span>
                                    </span>
                                </td>
                                <td>
                                    <table  class="fights-statistic-tbl" border="0">
                                        <tr>
                                            <td style="width: 75px">
                                                <div class="progress progress-danger active progress-small">
                                                    <div class="bar" style="width: <?= $fighter->$ko_attr_percent?>%;"></div>
                                                </div>
                                            </td>
                                            <td class="method-label-small">ko/tko</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="progress progress-success active progress-small">
                                                    <div class="bar" style="width: <?= $fighter->$submissions_attr_percent ?>%;"></div>
                                                </div>
                                            </td>
                                            <td class="method-label-small">сдачей</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="progress progress-warning active progress-small">
                                                    <div class="bar" style="width: <?= $fighter->$decisions_attr_percent ?>%;"></div>
                                                </div>
                                            </td>
                                            <td class="method-label-small">решением</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        <? endforeach ?>
                        <tr>
                            <td colspan="2">
                                <table border="0" cellspacing="0" cellpadding="0" style="margin-top: 10px;width: 240px">
                                    <tr style="vertical-align: top;line-height: 17px">
                                        <td style="width: 75px">
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
                    </table>
                </td>
                <td class="fighter-media">
                    <span>Последние бои</span>
                    <a href="">Pride 33 Elemelianenko vs Rashad Evans</a>
                    <a href="">Pride 33 Elemelianenko vs Rashad Evans</a>
                    <a href="">Pride 33 Elemelianenko vs Rashad Evans</a>
                    <div style="margin-top: 5px"></div>
                    <span>Последние новости</span>
                    <a href="">Андрей Арловский подствердил статус стеклянной челюсти</a>
                    <a href="">Андрей Арловский подствердил статус стеклянной челюсти</a>
                    <a href="">Андрей Арловский подствердил статус стеклянной челюсти</a>
                </td>
            </tr>
    </table>
</div>