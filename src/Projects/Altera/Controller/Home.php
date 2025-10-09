<?php 
namespace Projects\Altera\Controller;

use App\Controller\View;
use Projects\Altera\Model\Students;

class Home
{
    public function Index()
    {
        $Students = new Students();
        $datas = $Students->getStudents();

        // Connection à la bdd 
        // Traitements
        // Afficher une vue

        $name   = 'damien';
        $students = [
            ['name'=>'gilles'],
            ['name'=>'hugo'],
            ['name'=>'clément'],
        ];

        View::Init();
        View::$smarty->assign('students',$datas);
        View::$smarty->assign('name',$name);
        View::$smarty->display('index.tpl');
    }
}