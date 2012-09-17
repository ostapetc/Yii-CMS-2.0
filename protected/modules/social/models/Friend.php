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

    const USERS_STATUS_FRIENDS         = 'friends';
    const USERS_STATUS_NOT_FRIENDS    = 'not_friends';
    const USERS_STATUS_USER_A_WAITING = 'user_a_waiting';
    const USERS_STATUS_USER_B_WAITING = 'user_b_waiting';


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
                'user_a_id',
                'uniqueFriendship'
            ),
            array(
                'user_a_id',
                'rightFriendship'
            ),
        );
    }


    public function uniqueFriendship($attr)
    {
        $status = self::getUsersStatus($this->user_a_id, $this->user_b_id);
        if ($status != self::USERS_STATUS_NOT_FRIENDS)
        {
            $this->addError($attr, t('заявка в друзья уже была подана'));
        }
    }


    public function rightFriendship($attr)
    {
        if ($this->user_a_id == $this->user_b_id)
        {
            $this->addError($attr, t('нельзя приглашать себя в друзья'));
        }
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


    public static function getUsersStatus($user_a_id, $user_b_id)
    {
        $sql = "SELECT is_confirmed,
                       user_a_id,
                       user_b_id
                       FROM " . self::model()->tableName() . "
                       WHERE (
                                user_a_id = :user_a_id AND
                                user_b_id = :user_b_id
                             )
                             OR
                             (
                                user_a_id = :user_b_id AND
                                user_b_id = :user_a_id
                             )";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam('user_a_id', $user_a_id, PDO::PARAM_INT);
        $command->bindParam('user_b_id', $user_b_id, PDO::PARAM_INT);

        $friendship = $command->queryRow();
        if ($friendship)
        {
            if ($friendship['is_confirmed'])
            {
                return self::USERS_STATUS_FRIENDS;
            }
            else
            {
                return $friendship['user_a_id'] == $user_a_id ? self::USERS_STATUS_USER_A_WAITING : self::USERS_STATUS_USER_B_WAITING;
            }
        }
        else
        {
            return self::USERS_STATUS_NOT_FRIENDS;
        }

        p($friendship);
    }
}
