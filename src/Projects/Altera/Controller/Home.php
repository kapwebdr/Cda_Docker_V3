<?php 
namespace Projects\Altera\Controller;

use App\Controller\View;
class Home
{
    public function Index()
    {
        
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
        View::$smarty->assign('students',$students);
        View::$smarty->assign('name',$name);
        View::$smarty->display('index.tpl');
    }
}