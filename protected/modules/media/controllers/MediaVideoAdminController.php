<?
class MediaVideoAdminController extends AdminController
{
    public static function actionsTitles()
    {
        return array(
            "create"     => "Создать",
            "view"       => "Создать",
            "delete"     => "Удалить",
            "update"     => "Редактировать",
            "manage"     => "Управление альбомами",
        );
    }


    function getAndPrintVideoFeed($location = Zend_Gdata_YouTube::VIDEO_URI)
    {
        // set the version to 2 to receive a version 2 feed of entries
        $yt->setMajorProtocolVersion(2);
        dump($yt->getUserUploads('www.pismeco@gmail.com'));
        $videoFeed = $yt->getVideoFeed($location);

        $this->printVideoFeed($videoFeed);
    }


    function printVideoFeed($videoFeed)
    {
        $count = 1;
        foreach ($videoFeed as $videoEntry)
        {
            echo "Entry # " . $count . "<br/>";
            $this->printVideoEntry($videoEntry);
            echo "<br/>";
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
        foreach ($videoEntry->mediaGroup->content as $content)
        {
            if ($content->type === "video/3gpp")
            {
                echo 'Mobile RTSP link: ' . $content->url . "\n";
            }
        }

        echo "Thumbnails:\n";
        $videoThumbnails = $videoEntry->getVideoThumbnails();

        foreach ($videoThumbnails as $videoThumbnail)
        {
            echo $videoThumbnail['time'] . ' - ' . $videoThumbnail['url'];
            echo ' height=' . $videoThumbnail['height'];
            echo ' width=' . $videoThumbnail['width'] . "\n";
        }
    }


    public function actionGo()
    {

    }


    public function getApi()
    {
        $conf       = Yii::app()->params['youtube'];
        $httpClient = Zend_Gdata_ClientLogin::getHttpClient($username = $conf['user'],
            $password = $conf['pass'], $service = 'youtube', $client = null, $source = $conf['app'],
            // a short string identifying your application
            $loginToken = null, $loginCaptcha = null);
        return new Zend_Gdata_YouTube($httpClient, $conf['app'], $conf['user'], $conf['key']);
    }


    public function actionCreate()
    {
//        $model = new MediaVideo;
//        $form  = new Form('media.AlbumForm', $model);

        Yii::import('application.libs.*');
        require_once 'Zend/Loader.php';
        Zend_Loader::loadClass('Zend_Gdata_YouTube');
        Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
        Zend_Loader::loadClass('Zend_Gdata_AuthSub');

        $yt = $this->getApi();

        $myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();

        $myVideoEntry->setVideoTitle('My Test Movie');
        $myVideoEntry->setVideoDescription('My Test Movie');
        // The category must be a valid YouTube category!
        $myVideoEntry->setVideoCategory('Autos');

        // Set keywords. Please note that this must be a comma-separated string
        // and that individual keywords cannot contain whitespace
        $myVideoEntry->SetVideoTags('cars, funny');

        $tokenHandlerUrl = 'http://gdata.youtube.com/action/GetUploadToken';
        $tokenArray      = $yt->getFormUploadToken($myVideoEntry, $tokenHandlerUrl);
        $tokenValue      = $tokenArray['token'];
        $postUrl         = $tokenArray['url'];
        $nextUrl = Yii::app()->request->getCurrentUri();

        // build the form
        $form = '<form action="'. $postUrl .'?nexturl='. $nextUrl .
                '" method="post" enctype="multipart/form-data">'.
                '<input name="file" type="file"/>'.
                '<input name="token" type="hidden" value="'. $tokenValue .'"/>'.
                '<input value="Upload Video File" type="submit" />'.
                '</form>';

        $this->render('create', array('postUrl' => $postUrl, 'nextUrl' => $nextUrl, 'tokenValue' => $tokenValue));
    }


    public function actionView($id)
    {
        $this->layout     = '//layouts/middle';
        $model            = $this->loadModel($id);
        $this->page_title = 'Альбом: ' . $model->title;
        $form             = new Form('Media.UploadFilesForm', $model);
        $this->render('view', array(
            'model' => $model,
            'form'  => $form
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


    public function actionUserAlbums($userId)
    {
        $this->layout     = '//layouts/middle';
        $user             = User::model()->findByPk($userId);
        $this->page_title = 'Альбомы пользователя ' . $user->getLink();
        $form             = new Form('media.AlbumForm', $user->getAttachedModel('MediaAlbum'));
        $this->render('userAlbums', array(
            'user' => $user,
            'form' => $form
        ));
    }
}
