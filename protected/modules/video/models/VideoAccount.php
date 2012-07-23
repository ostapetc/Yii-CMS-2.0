<?
/**
 * @property $id
 * @property $hosting
 * @property $api_key
 * @property $api_secret
 * @property $request_url
 * @property $auth_url
 * @property $access_url
 */
class VideoAccount extends ActiveRecord
{
    const PAGE_SIZE = 20;


    const HOSTING_VIMEO = 'vimeo';
    const HOSTING_RUTUBE = 'rutube';

    public static $hosting_options = array(
        self::HOSTING_VIMEO => 'vimeo',
        self::HOSTING_RUTUBE => 'rutube',
    );


    public function name()
    {
        return 'Видео аккаунты';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'video_accounts';
    }


    public function rules()
    {
        return array(
            array(
                'hosting, api_key, api_secret, request_url, auth_url, access_url',
                'required'
            ),
            array(
                'api_key, api_secret, request_url, auth_url, access_url',
                'length',
                'max' => 250
             ),
            array(
                'hosting',
                'in',
                'range' => self::$hosting_options
            ),
            array(
                '',
                'unique'
            ),
        );
    }


    public function relations()
    {
        return array(
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('hosting', $this->hosting, true);
        $criteria->compare('api_key', $this->api_key, true);
        $criteria->compare('api_secret', $this->api_secret, true);
        $criteria->compare('request_url', $this->request_url, true);
        $criteria->compare('auth_url', $this->auth_url, true);
        $criteria->compare('access_url', $this->access_url, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/video/videoaccount/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
        );
    }
}
