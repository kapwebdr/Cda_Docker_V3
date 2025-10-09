<?php
namespace Projects\Altera\Controller;

class User
{
    // public function getUserById($vars)
    // {
    //     var_dump($vars);
    //     $id = $vars['id'];
    // }

    public function getUserById(int $id,string $title='')
    {
        var_dump($id);
        var_dump($title);
    }
}