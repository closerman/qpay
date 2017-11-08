<?php
/**
 * Created by PhpStorm.
 * User: bing
 * Date: 17-10-11
 * Time: 下午1:02
 */
namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;
trait  ConditionBuild
{
//    private $condition = [];
    private static $suffixMap = [
        '__gte__' => '>=',
        '__lte__' => '<=',
        '__lt__' => '<',
        '__gt__' => '>',
        '__ne__' => '<>',
        '__in__' => 'IN',
        '__nin__' => 'NIN',
        '__between__' => 'BETWEEN',
        '__like__' => 'LIKE',
        '__regexp__' => 'REGEXP'
    ];

    public static function processSuffix($key)
    {
        foreach(static::$suffixMap as $suffix => $operator){
            if(strpos($key,$suffix)){
                return [
                    strstr($key,$suffix,true), $operator
                ];
            }
        }
        return [$key, '='];
    }

    public static function processOppositeQuery($key)
    {
        $prefix = '__not__';

        $len = strlen($prefix);

        $opposite = false;

        if(substr($key, 0, $len) == $prefix){
            $key = substr($key, $len);
            $opposite = true;
        }

        return [$key, $opposite];
    }

    /**
     * @param array $sum
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    public function sum()
    {
        if(!$this->sum){
            return [];
        }
        $sum = '';
        foreach($this->sum as $key){
            $key and $sum.= "SUM({$key}) AS {$key},";
        }
        $sum = DB::raw(substr($sum,0,-1));
        $builder = clone $this->builder;
        return $sum?$builder->select($sum)->first():[];
    }

    public function addQuery()
    {
        foreach($this->condition as $key=>$value){

            list($key, $opposite) = static::processOppositeQuery($key);

         /*   if(sizeof($keys = explode($this->nestSeparator , $key)) > 1){
                $this->addRelativeFilter($keys, $value, $opposite);
                continue;
            }*/

            list($key, $operator) = static::processSuffix($key);

            if(!in_array($operator,['IN','BETWEEN']) && is_array($value)){
                $this->builder = $this->builder->whereHas($key, $this->getNestQueryCallback($value, $opposite));
                continue;
            }

            //$value = $this->adaptValue($key, $value);

            if($operator == 'IN'){
                $this->builder = $this->builder->whereIn($key, (array)$value);
            }elseif($operator == 'NIN'){
                $this->builder = $this->builder->whereNotIn($key, (array)$value);
            }else{
                $this->builder = $this->builder->where($key, $operator, $value);
            }

        }

        return $this;
    }



}