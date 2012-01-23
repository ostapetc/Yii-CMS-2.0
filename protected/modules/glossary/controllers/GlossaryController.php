<?php

class GlossaryController extends BaseController
{
    public static function actionsTitles()
    {
        return array(
            "View"  => "Просмотр определения",
            "Index" => "Список определений"
        );
    }

    public function actionView($id)
    {
        $this->render('view', array(
            'model'=> $this->loadModel($id)
        ));
    }

    public function actionIndex($Glossary_alphapage = null, $p_rst = null, $page = null)
    {
        if ($Glossary_alphapage === null && $p_rst === null && $page === null)
        {
            $char = Glossary::getLastNoEmptyChar('letter');
            $index = ApPagination::getWordIndex($char);

            $this->redirect($this->url('index', array('Glossary_alphapage' => $index)));
        }

        $config = array(
            'criteria'        => Glossary::model()->active()->byTitle()->dbCriteria,
            'alphapagination' => array(
                'attribute'     => 'letter',
                'pagination'    => array(
                    'pageSize' => Glossary::PAGE_SIZE,
                ),
                'charSet' => ApPagination::getAllLetters(),
                'activeCharSet' => Glossary::noEmptyChars('letter')
            )
        );

        $this->render('index', array(
            'dp' => new ApActiveDataProvider('Glossary', $config)
        ));
    }

}

