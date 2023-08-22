<?php


namespace Models;


interface IConnect
{
    const DB_HOST = "localhost";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB_NAME = "abukai";
    public static function dbConnect(): \PDO;
}
