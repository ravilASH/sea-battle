<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "game".
 *
 * @property int $id
 * @property int $left_gamer
 * @property int $right_gamer
 * @property string $attack_side
 *
 * @property User $leftGamer
 * @property User $rightGamer
 */
class Game extends \yii\db\ActiveRecord
{
    const SIDE_LEFT = 'left';
    const SIDE_RIGHT = 'right';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['left_gamer', 'right_gamer'], 'required'],
            [['left_gamer', 'right_gamer'], 'default', 'value' => null],
            [['left_gamer', 'right_gamer'], 'integer'],
            [['attack_side'], 'default', 'value' => self::getFirstStepSide()],
            [['attack_side'], 'string', 'max' => 255],
            [['left_gamer'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['left_gamer' => 'id']],
            [['right_gamer'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['right_gamer' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'left_gamer' => 'Left Gamer',
            'right_gamer' => 'Right Gamer',
            'attack_side' => 'Attack Side',
        ];
    }

    /**
     * возвращает все стороны игры
     * @return array
     */
    public static function getSides()
    {
        return [ self::SIDE_LEFT , self::SIDE_RIGHT ];
    }

    public static function getFirstStepSide()
    {
        return self::SIDE_LEFT;
    }

    /**
     * Отдает пользователя делающего текущий ход
     */
    public function getCurrentUser() : User
    {
        switch ($this->attack_side){
            case self::SIDE_RIGHT;
            return $this->rightGamer;
            case self::SIDE_LEFT;
            return $this->leftGamer;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeftGamer()
    {
        return $this->hasOne(User::className(), ['id' => 'left_gamer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRightGamer()
    {
        return $this->hasOne(User::className(), ['id' => 'right_gamer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDecks()
    {
        return $this->hasMany(Figure::className(), ['game_id' => 'id'])->inverseOf('game');
    }

    public function getLeftDecks()
    {
        return $this->hasMany(Figure::className(), ['game_id' => 'id'])->onCondition(['side'=>self::SIDE_LEFT]);
    }

    public function getRightDecks()
    {
        return $this->hasMany(Figure::className(), ['game_id' => 'id'])->onCondition(['side'=>self::SIDE_RIGHT]);
    }

    public function getField ($side)
    {
        return null;
    }

    /**
     * Нуждается ли игра в заполении
     * @return string|false
     */
    public function isNeedToFillBySide()
    {
        if (!$this->leftDecks) {
            return self::SIDE_LEFT;
        }
        if (!$this->rightDecks){
            return self::SIDE_RIGHT;
        }
        return false;
    }

    public function getNext()
    {
        return ($this->attack_side == self::SIDE_LEFT) ? self::SIDE_RIGHT : self::SIDE_LEFT;
    }

    public function fillSide($data){
        $side = $this->isNeedToFillBySide();
        foreach ($data as $coordinates){
            $coordinates = array_values(array_flip($coordinates));
            $deck =  new Figure();
            $deck->coordinates = array_shift($coordinates);
            $deck->side = $side;
            $deck->game_id = $this->id;
            $deck->save();
        }
        $this->attack_side = $this->getNext();
        $this->save();
        $this->refresh();
    }
}
