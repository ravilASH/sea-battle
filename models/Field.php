<?php
/**
 * Created by PhpStorm.
 * User: ravil
 * Date: 15.12.18
 * Time: 22:43
 */

namespace app\models;


use yii\base\BaseObject;

class Field
{
    const DIMENTION = 10;

    public static function getEmptyCells()
    {
        $cells = [];
        foreach (array_fill(0, self::DIMENTION, 0) as $rowNumber => $row){
            foreach (array_fill(0, self::DIMENTION, 0) as $colNumber => $col){
                $cells[] = new Cell(Cell::EMPTY_STATE, $rowNumber.':'.$colNumber);
            }
        }
        return $cells;
    }
}