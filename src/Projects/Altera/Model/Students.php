<?php
namespace Projects\Altera\Model;

use App\Model\Db;

class Students extends Db
{
    function getStudents()
    {
        $sql = 'Select * from etudiants';
        $rq = self::$db->prepare($sql);
        $rq->execute();
        return $rq->fetchAll();
    }
}