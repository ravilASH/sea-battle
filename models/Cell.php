<?php
/**
 * Created by PhpStorm.
 * User: ravil
 * Date: 15.12.18
 * Time: 22:53
 */

namespace app\models;


use yii\base\BaseObject;

/**
 * Class Cell
 * @package app\models
 * @property $state string
 * @property $coordinates string
 */
class Cell
{
    const EMPTY_STATE = 'empty';
    const HIT_STATE = 'hit';
    const MISS_STATE = 'miss';
    const DECK_STATE = 'deck';

    protected $coordinates;
    protected $state;

    public function __construct($state, $coordinates)
    {
        $this->coordinates = $coordinates;
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getCoordinates()
    {
        return $this->coordinates;
    }
}