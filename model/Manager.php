<?php

namespace OpenClassrooms\oc_project_4\Model;

class Manager
{
    protected function dbConnect()
    {
        $servername = "mysql:dbname=dbs275849;host=db5000282612.hosting-data.io:3306";
        $username = "dbu71266";
        $password = "ZtnaG-1%3Am!";
        $options = array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);

        $db = new \PDO($servername, $username, $password, $options);
        return $db;
    }
}