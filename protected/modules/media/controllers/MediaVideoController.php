<?
class MediaVideoController extends ClientController
{

    public static function actionsTitles()
    {
        return array(
            "manage"    => "Альбомы пользователя",
        );
    }


    public function subMenuItems()
    {
        return array(
            array(
                'label' => t('Все'),
                'url'   => array('content/page/index')
            ),
            array(
                'label' => t('Лучшие'),
                'url'   => array('content/page/top')
            ),
            array(
                'label'   => Yii::app()->user->isGuest
                    ? : t('Ваши') . '(' . Page::model()->count('user_id = ' . Yii::app()->user->id) . ')',
                'url'     => array('/page/user/' . Yii::app()->user->id),
                'visible' => !Yii::app()->user->isGuest
            )
        );
    }


    public function sidebars()
    {
        return array(
            array(
                'actions'  => array('create', 'update'),
                'sidebars' => array(
                    array(
                        'widget',
                        'content.portlets.SectionCreateSidebar',
                    ),
                    array(
                        'widget',
                        'tags.portlets.TagCreateSidebar',
                    ),
                    array(
                        'partial',
                        'content.views.page._sidebarFormNotices'
                    )
                )
            ),
            array(
                'actions'  => array('index'),
                'sidebars' => array(
                    array(
                        'widget',
                        'content.portlets.PageSectionsSidebar'
                    ),
                    array(
                        'widget',
                        'comments.portlets.CommentsSidebar',
                    ),
                    array(
                        'widget',
                        'media.portlets.YouTubePlayList'
                    )
                    /*array(
                        'widget',
                        'content.portlets.NavigatorSidebar',
                    ),*/
                )
            ),
            array(
                'actions'  => array('view'),
                'sidebars' => array(
                    array(
                        'widget',
                        'content.portlets.PageInfoSidebar'
                    )
                )
            ),
            array(
                'actions'  => array('userPages'),
                'sidebars' => array(
                    array(
                        'widget',
                        'content.portlets.userPagesSidebar'
                    )
                )
            ),
        );
    }


    public function actionManage($user_id = null)
    {
        if ($user_id === null)
        {
            $user_id = Yii::app()->user->model->id;
        }
        $user = User::model()->throw404IfNull()->findByPk($user_id);
        $this->page_title = 'Альбомы пользователя ' . $user->getLink();
        $dp = MediaFile::model()->getDataProvider($user);
        $this->render('userVideos', array(
            'model' => $user,
            'is_my' => Yii::app()->user->model->id == $user_id,
            'dp'    => $dp
        ));
    }
}
