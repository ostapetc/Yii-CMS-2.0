<table width="99%">
    <? foreach ($fighters as $i => $fighter): ?>
        <tr valign="top">
            <td width="140">
                <?= $fighter->getImageLink() ?>
            </td>
            <td valign="top">
                <table width="100%" border="1">
                    <tr>
                        <td width="50">
                            #<?= ++$i ?> <?= $fighter->link ?>
                        </td>
                    </tr>
                    <tr valign="top" >
                    <tr valign="top" >
                        <td>
                            <span class="label record">
                                wins <br/>
                                <span><?= $fighter->wins ?></span>
                            </span>
                        </td>
                        <td>
                            <table width="100%" class="fights-statistic-tbl" border="1">
                                <tr>
                                    <td>
                                        <div class="progress progress-danger active">
                                            <div class="bar" style="width: 30%;"></div>
                                        </div>
                                    </td>
                                    <td>победы</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="progress progress-success active">
                                            <div class="bar" style="width: 59%;"></div>
                                        </div>
                                    </td>
                                    <td>поражения</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="progress progress-warning active">
                                            <div class="bar" style="width: 75%;"></div>
                                        </div>
                                    </td>
                                    <td>ничьи</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="label record">
                                losses <br/>
                                <span><?= $fighter->losses ?></span>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2"><br/></td>
        </tr>
    <? endforeach ?>
</table>