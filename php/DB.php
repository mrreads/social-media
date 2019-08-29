<?php

class DB
{
    public static $dbh = null;

    public static function getDbh()
    {
        self::$dbh = new PDO('mysql:host=localhost;dbname=social-media', 'root', '2342');
        return self::$dbh;
    }

    // DB::query("SELECT * FROM users");

    public static function query($query)
    {
        $sth = self::getDbh()->prepare("$query");
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public static function queryAll($query)
    {
        $sth = self::getDbh()->prepare("$query");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    // ARRAY['номер массива']['название колонки'];

    public static function queryCount($query)
    {
        $sth = self::getDbh()->prepare("$query");
        $sth->execute();
        $data = $sth->fetchAll();
        $data = count($data);
        return $data;
    }
}

// foreach ($sql = DB::queryAll("SELECT * FROM users") as $data)
// {
//    echo $data['user_email'];
// }
