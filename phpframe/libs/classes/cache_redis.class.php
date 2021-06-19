<?php

/**
 * redis简单操作封装类
 *
 * @author SummerZhao
 *        
 */
class cache_redis
{

    /**
     * redis实体对象
     */
    public $redis;

    /**
     * 超时时间
     */
    public $expires;

    /**
     * redis封装类构造函数
     *
     * @param array $config
     *            redis配置信息
     * @return Redis
     */
    function __construct()
    {
        if (! is_object($this->redis)) {
            $this->redis = new Redis();
            $this->redis->connect(REDIS_HOST, REDIS_PORT);
            $this->expires = REDIS_TIMEOUT;
        }
        return $this->redis;
    }

    /**
     * 写入redis
     *
     * @param string $key            
     * @param string $value
     *            数据
     * @param number $timeOut
     *            超时时间	$timeOut>0，超时时间为$timeOut;$timeOut=0，默认配置时间;$timeOut<0，不设置超时时间
     * @return unknown
     */
    public function set($key, $value, $timeOut = 0)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }
        $retRes = $this->redis->set($key, $value);
        if ($timeOut > 0) {
            $this->redis->setTimeout($key, $timeOut);
        } else {
            if ($this->expires > 0) {
                $this->redis->setTimeout($key, $this->expires);
            }
        }
        return $retRes;
    }

    /**
     * 通过KEY获取数据
     *
     * @param string $key
     *            KEY名称
     */
    public function get($key)
    {
        $result = $this->redis->get($key);
        return json_decode($result, TRUE);
    }

    /**
     * 删除一条数据
     *
     * @param string $key
     *            KEY名称
     */
    public function delete($key)
    {
        return $this->redis->delete($key);
    }

    /**
     * 清空数据
     */
    public function flushAll()
    {
        return $this->redis->flushAll();
    }

    /**
     * 数据入队列
     *
     * @param string $key
     *            KEY名称
     * @param string|array $value
     *            获取得到的数据
     * @param bool $right
     *            是否从右边开始入
     */
    public function push($key, $value, $right = true)
    {
        $value = json_encode($value);
        return $right ? $this->redis->rPush($key, $value) : $this->redis->lPush($key, $value);
    }

    /**
     * 数据出队列
     *
     * @param string $key
     *            KEY名称
     * @param bool $left
     *            是否从左边开始出数据
     */
    public function pop($key, $left = true)
    {
        $val = $left ? $this->redis->lPop($key) : $this->redis->rPop($key);
        return json_decode($val);
    }

    /**
     * 数据自增
     *
     * @param string $key
     *            KEY名称
     */
    public function increment($key)
    {
        return $this->redis->incr($key);
    }

    /**
     * 数据自减
     *
     * @param string $key
     *            KEY名称
     */
    public function decrement($key)
    {
        return $this->redis->decr($key);
    }

    /**
     * key是否存在，存在返回ture
     *
     * @param string $key
     *            KEY名称
     */
    public function exists($key)
    {
        return $this->redis->exists($key);
    }

    /**
     * 返回redis对象
     * redis有非常多的操作方法，只封装了一部分
     * 拿着这个对象就可以直接调用redis自身方法
     */
    public function redis()
    {
        return $this->redis;
    }
}

?>