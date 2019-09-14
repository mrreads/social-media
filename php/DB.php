<?php

class DB
{
    public static $dbh;

    public static function getDbh()
    {
        $host = 'localhost';
        $dbname = 'social-media';
        $user = 'root';
        $pass = '2342';

        self::$dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        return self::$dbh;
    }

    // Возвращает одномерный массив массив.
    // $data['название колонки'];
    public static function query($query)
    {
        $sth = self::getDbh()->prepare("$query");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    // Возвращает двумерный массив массив.
    // $data['номер массива']['название колонки'];
    public static function queryAll($query)
    {
        $sth = self::getDbh()->prepare("$query");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    // Возвращает количетсво строк.
    public static function queryCount($query)
    {
        $sth = self::getDbh()->prepare("$query");
        $sth->execute();
        $data = $sth->fetchAll();
        $data = count($data);
        return $data;
    }

    // Для выполнения запросов по типу UPDATE, INSERT
    public static function queryExecute($query)
    {
        $sth = self::getDbh()->prepare("$query");
        $sth->execute();
    }
}

// Для вывода данных используется такая конструкция:
// foreach ($sql = DB::query("SELECT * FROM users") as $data)
// {
//    echo $data['user_email'];
// }
