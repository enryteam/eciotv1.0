<?php

class WeightRouter
{

    private static $_weightArray = array();

    private static $_gcd; // 表示集合S中所有服务器权值的最大公约数
    private static $_baseNumber;

    public function init(array $weightArray)
    {
        self::$_weightArray = array_sort($weightArray, 'weight', SORT_ASC);
        // self::$_gcd = self::getGcd(self::$_weightArray);
        self::$_gcd = 10000;
        self::$_baseNumber = self::getBaseNumber(self::$_weightArray);
    }

    private static function getGcd(array $weightArray)
    {
        $temp = array_shift($weightArray);
        $min = $temp['weight'];
        $status = false;
        foreach ($weightArray as $val) {
            $min = min($val['weight'], $min);
        }
        
        if ($min == 1) {
            return 1;
        } else {
            
            for ($i = $min; $i > 1; $i --) {
                
                foreach ($weightArray as $val) {
                    if (is_int($val['weight'] / $i)) {
                        $status = true;
                    } else {
                        $status = false;
                        break;
                    }
                }
                if ($status) {
                    return $i;
                } else {
                    return 1;
                }
            }
        }
    }

    private static function getBaseNumber(array $weightArray)
    {
        if (empty($weightArray)) {
            return false;
        }
        $baseNumber = 0;
        foreach ($weightArray as $key => $value) {
            $baseNumber += $value['weight'] * self::$_gcd;
        }
        return $baseNumber;
    }

    public function getWeight()
    {
        $randNumber = rand(1, self::$_baseNumber);
        // $randNumber = 1;
        $start = 0;
        $end = 0;
        foreach (self::$_weightArray as $k => $v) {
            $start = $end;
            $end = $start + $v['weight'] * self::$_gcd;
            if ($randNumber > $start && $randNumber <= $end) {
                $prize = $k;
                return self::$_weightArray[$k];
            }
        }
    }
}
?>