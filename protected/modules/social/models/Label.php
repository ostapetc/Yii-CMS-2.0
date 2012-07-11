<?
/**
 * @property $id
 * @property $desc
 * @property $icon
 */
class Label extends ActiveRecord
{
    const PAGE_SIZE = 20;

    const ICON_DIR = '/upload/icon/';


    public function name()
    {
        return 'Ярлыки';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'labels';
    }


    public function rules()
    {
        return array(
            array(
                '',
                'required'
            ),
            array(
                'desc',
                'length',
                'max' => 100
             ),
            array(
                'icon',
                'length',
                'max' => 36
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
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('icon', $this->icon, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public function getHref()
    {
        return Yii::app()->createUrl('/social/label/view', array('id' => $this->id));
    }


    public function uploadFiles()
    {
        return array(
            'icon' => array(
                'dir' => self::ICON_DIR
            ),
        );
    }
}
