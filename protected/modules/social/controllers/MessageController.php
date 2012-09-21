<?

class MessageController extends ClientController
{
    public static function actionsTitles()
    {
        return array(
            'index' => 'Список Сообщение',
        );
    }


    public function sidebars()
    {
        return array(
            array(
                'actions' => array(
                    'index'
                ),
                'sidebars' => array(
                    array(
                        'widget',
                        'application.modules.social.portlets.MessageDialogsSidebar'
                    )
                )
            )
        );
    }


    public function subMenuItems()
    {
        return array(
            array(
                'label'   => t('Все'),
                'url'     => '',
                'visible' => Yii::app()->controller->action->id == 'index'
            ),
            array(
                'label'   => t('Полученные'),
                'url'     => '',
                'visible' => Yii::app()->controller->action->id == 'index'
            ),
            array(
                'label'   => t('Отправленные'),
                'url'     => '',
                'visible' => Yii::app()->controller->action->id == 'index'
            ),
        );
    }


	public function actionIndex($user_id = null)
	{
        $user = User::model()->throw404IfNull()->findByPk($user_id);

        $criteria = new CDbCriteria();
        $criteria->addCondition('to_user_id', Yii::app()->user->id);

        if ($user_id)
        {
            $criteria->addCondition('from_user_id', $user->id);
            $criteria->order = 'date_create DESC';
        }

		$data_provider = new CActiveDataProvider('Message');

		$this->render('index', array(
			'data_provider' => $data_provider,
		));
	}


}
