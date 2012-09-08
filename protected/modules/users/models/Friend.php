<?php
/** 
 * 
 * !Attributes - атрибуты БД
 * @property                 $is_confirmed
 * @property                 $id
 * @property                 $user_a_id
 * @property                 $user_b_id
 * @property                 $date_create
 * 
 * !Accessors - Геттеры и сеттеры класа и его поведений
 * @property                 $errorsFlatArray
 * 
 * !Scopes - именованные группы условий, возвращают этот АР
 * @method   Friend          published()
 * @method   Friend          sitemap()
 * @method   Friend          ordered()
 * @method   Friend          last()
 * 
 */

class Friend extends ActiveRecord
{
    const PAGE_SIZE = 20;



    public function name()
    {
        return 'Друзья';
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'friends';
    }


    public function rules()
    {
        return array(
            array(
                'user_a_id, user_b_id, is_confirmed',
                'required'
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
        $criteria->compare('user_a_id', $this->user_a_id, true);
        $criteria->compare('user_b_id', $this->user_b_id, true);
        $criteria->compare('is_confirmed', $this->is_confirmed, true);
        $criteria->compare('date_create', $this->date_create, true);

        return new ActiveDataProvider(get_class($this), array(
            'criteria'   => $criteria,
            'pagination' =>array(
                'pageSize' => self::PAGE_SIZE
            )
        ));
    }


    public static function userFriendsCount($user_id)
    {
        $sql = "SELECT COUNT(*)
                       FROM friends
                       WHERE user_a_id = {$user_id} OR
                             user_b_id = {$user_id}";

        return Yii::app()->db->createCommand($sql)->queryScalar();
    }
}
