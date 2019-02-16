<?php
namespace Swover\Framework;

use Ruesin\Utils\MySQL;

class Model
{
    protected static $table = '';

    protected static $primary = 'id';

    protected static $connection = '';

    /**
     * get base info
     *
     * @param $id
     * @param string|array $fields
     * @link https://medoo.in/api/get
     * @return bool|mixed
     */
    public static function get($id, $fields = null)
    {
        if ($fields === null) $fields = '*';
        $result = self::getDb()->get(static::$table, $fields, [static::$primary => $id]);
        return $result;
    }

    /**
     * get base info
     *
     * @param string|array $columns
     * @param array $where
     * @link https://medoo.in/api/get
     * @return bool|mixed
     */
    public static function getOne($columns = [], $where = [])
    {
        if (empty($columns)) $columns = '*';
        $result = self::getDb()->get(static::$table, $columns, $where);
        return $result;
    }

    /**
     * select
     *
     * @param string|array $columns
     * @param array $where
     * @return array|bool
     */
    public static function select($columns = [], $where = [])
    {
        if (empty($columns)) $columns = '*';
        return self::getDb()->select(static::$table, $columns, $where);
    }

    /**
     * insert info
     *
     * @param array $data single - ['name'=> 'sin','like'=>['apple','orange']] ; multi - [['name'=>'sin','like[JSON]'=>['apple','orange']],['name'=>'lin','like[JSON]'=>['banana']]]
     * @param bool $last_id
     * @link https://medoo.in/api/insert
     * @return bool|int
     */
    public static function insert($data = [], $last_id = false)
    {
        if (empty($data)) return false;

        $result = self::getDb()->insert(static::$table, $data);

        if ($last_id) {
            return self::getDb()->id();
        } elseif ($result) {
            return $result->rowCount();
        }
    }

    /**
     * delete
     *
     * @param $where !!! NOT NULL !!!
     * @link https://medoo.in/api/delete
     * @return int
     */
    public static function delete($where)
    {
        if (empty($where)) return false;

        $result = self::getDb()->delete(static::$table, $where);
        return $result->rowCount();
    }

    /**
     * update
     *
     * @param $data
     * @param $where
     * @link https://medoo.in/api/update
     * @return int
     */
    public static function update($data, $where)
    {
        $result = self::getDb()->update(static::$table, $data, $where);
        if (!$result) {
            return false;
        }
        return $result->rowCount();
    }

    /**
     * count
     *
     * @param $where
     * @link https://medoo.in/api/get
     * @return bool|mixed
     */
    public static function count($where)
    {
        return self::getDb()->count(static::$table, $where);
    }

    /**
     * has
     *
     * @param $where
     * @link https://medoo.in/api/get
     * @return bool|mixed
     */
    public static function has($where)
    {
        return self::getDb()->has(static::$table, $where);
    }

    public static function error()
    {
        return self::getDb()->error();
    }

    public static function lastSql()
    {
        return self::getDb()->last();
    }

    /**
     * @return mixed | \Medoo\Medoo | bool
     */
    private static function getDb()
    {
        $mysql_key = static::$connection ? : env('APP_NAME');
        return MySQL::getInstance($mysql_key);
    }
}
