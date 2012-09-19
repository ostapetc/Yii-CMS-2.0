<?
class MediaAlbumController extends ClientController
{
    public static function actionsTitles()
    {
        return array(
            "createUsers"      => "Создать",
            "view"             => "Создать",
            "delete"           => "Удалить",
            "update"           => "Редактировать",
            "manage"           => "Управление альбомами",
            "userAlbums"       => "Альбомы пользователя",
            "my"               => "Мои Альбомы",
            "go"               => "Мои Альбомы",
        );
    }


    function getAuthSubRequestUrl()
    {
        $next = 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $scope = 'http://gdata.youtube.com';
        $secure = false;
        $session = true;
        return Zend_Gdata_AuthSub::getAuthSubTokenUri($next, $scope, $secure, $session);
    }

    function getAuthSubHttpClient()
    {
        if (!Yii::app()->session->get('sessionToken') && !isset($_GET['token']) ){
            echo '<a href="' . $this->getAuthSubRequestUrl() . '">Login!</a>';
            return;
        } else if (!Yii::app()->session->get('sessionToken') && isset($_GET['token'])) {
            Yii::app()->session->add('sessionToken', Zend_Gdata_AuthSub::getAuthSubSessionToken($_GET['token']));
        }

        $httpClient = Zend_Gdata_AuthSub::getHttpClient($_SESSION['sessionToken']);
        return $httpClient;
    }

    function getAndPrintVideoFeed($location = Zend_Gdata_YouTube::VIDEO_URI)
    {
        $yt = new Zend_Gdata_YouTube();
        // set the version to 2 to receive a version 2 feed of entries
        $yt->setMajorProtocolVersion(2);
        $videoFeed = $yt->getVideoFeed($location);
        $this->printVideoFeed($videoFeed);
    }

    function printVideoFeed($videoFeed)
    {
        $count = 1;
        foreach ($videoFeed as $videoEntry) {
            echo "Entry # " . $count . "\n";
            $this->printVideoEntry($videoEntry);
            echo "\n";
            $count++;
        }
    }
    function printVideoEntry(Zend_Gdata_YouTube_VideoEntry $videoEntry)
    {
        // the videoEntry object contains many helper functions
        // that access the underlying mediaGroup object
        echo 'Video: ' . $videoEntry->getVideoTitle() . "\n";
        echo 'Video ID: ' . $videoEntry->getVideoId() . "\n";
        echo 'Updated: ' . $videoEntry->getUpdated() . "\n";
        echo 'Description: ' . $videoEntry->getVideoDescription() . "\n";
        echo 'Category: ' . $videoEntry->getVideoCategory() . "\n";
        echo 'Tags: ' . implode(", ", $videoEntry->getVideoTags()) . "\n";
        echo 'Watch page: ' . $videoEntry->getVideoWatchPageUrl() . "\n";
        echo 'Flash Player Url: ' . $videoEntry->getFlashPlayerUrl() . "\n";
        echo 'Duration: ' . $videoEntry->getVideoDuration() . "\n";
        echo 'View count: ' . $videoEntry->getVideoViewCount() . "\n";
        echo 'Rating: ' . $videoEntry->getVideoRatingInfo() . "\n";
        echo 'Geo Location: ' . $videoEntry->getVideoGeoLocation() . "\n";
        echo 'Recorded on: ' . $videoEntry->getVideoRecorded() . "\n";

        // see the paragraph above this function for more information on the
        // 'mediaGroup' object. in the following code, we use the mediaGroup
        // object directly to retrieve its 'Mobile RSTP link' child
        foreach ($videoEntry->mediaGroup->content as $content) {
            if ($content->type === "video/3gpp") {
                echo 'Mobile RTSP link: ' . $content->url . "\n";
            }
        }

        echo "Thumbnails:\n";
        $videoThumbnails = $videoEntry->getVideoThumbnails();

        foreach($videoThumbnails as $videoThumbnail) {
            echo $videoThumbnail['time'] . ' - ' . $videoThumbnail['url'];
            echo ' height=' . $videoThumbnail['height'];
            echo ' width=' . $videoThumbnail['width'] . "\n";
        }
    }
    public function actionGo()
    {
        Yii::import('application.libs.*');
        require_once 'Zend/Loader.php';
        Zend_Loader::loadClass('Zend_Gdata_YouTube');
        Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
        Zend_Loader::loadClass('Zend_Gdata_AuthSub');

        $conf = Yii::app()->params['youtube'];
        $httpClient = $this->getAuthSubHttpClient();
        $yt = new Zend_Gdata_YouTube($httpClient, $conf['app'], $conf['user'], $conf['key']);
        $this->getAndPrintVideoFeed();
        dump($yt);
        /*
         $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
            $username = $conf['user'],
            $password = $conf['pass'],
            $service = 'youtube',
            $client = null,
            $source = $conf['app'],
            $loginToken = $conf['key'],
            $loginCaptcha = null,
            $authenticationURL
        );
        */
    }



    public function actionCreateUsers()
    {
        $model            = new MediaAlbum(MediaAlbum::SCENARIO_CREATE_USERS);
        $user             = Yii::app()->user->model;
        $model->model_id  = get_class($user);
        $model->object_id = $user->id;

        $form = new Form('media.AlbumForm', $model);
        $this->performAjaxValidation($model);
        if ($form->submitted() && $model->save())
        {
            $this->redirect(array('my'));
        }

        $this->render('createUsers', array(
            'user'  => $user,
            'form'  => $form,
        ));
    }


    public function actionView($id)
    {
        $model            = MediaAlbum::model()->throw404IfNull()->findByPk($id);
        $this->page_title = 'Альбом: ' . $model->title;
        $form             = new Form('Media.UploadFilesForm', $model);

        $dp               = MediaFile::getDataProvider($model, 'files');
        $dp->pagination   = false;

        $this->render('view', array(
            'model' => $model,
            'form'  => $form,
            'dp' => $dp
        ));
    }


    public function actionUpload($model_id, $object_id, $tag)
    {
        if ($object_id == 0)
        {
            $object_id = 'tmp_' . Yii::app()->user->id;
        }

        $model            = new MediaFile('insert');
        $model->object_id = $object_id;
        $model->model_id  = $model_id;
        $model->tag       = $tag;

        if ($model->saveFile() && $model->userCanEdit() && $model->save())
        {
            $this->sendFilesAsJson(array($model));
        }
        else
        {
            echo CJSON::encode(array(
                'textStatus' => $model->error
            ));
        }
    }


    public function actionMy()
    {
        if (Yii::app()->user->isGuest)
        {
            $this->pageNotFound();
        }
        $dp = MediaAlbum::getDataProvider(Yii::app()->user->model);
        $this->render('userAlbums', array('user' => Yii::app()->user->model, 'is_my' => true, 'dp' => $dp));
    }

    public function actionUserAlbums($user_id = null)
    {
        if ($user_id == null || Yii::app()->user->model->id == $user_id)
        {
            $this->redirect(array('my'));
        }
        $user             = User::model()->throw404IfNull()->findByPk($user_id);
        $this->page_title = 'Альбомы пользователя ' . $user->getLink();
        $dp               = MediaAlbum::getDataProvider($user);
        $this->render('userAlbums', array('user' => $user, 'is_my' => false, 'dp' => $dp));
    }

}
