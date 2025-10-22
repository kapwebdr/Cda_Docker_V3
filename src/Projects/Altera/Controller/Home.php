<?php 
namespace Projects\Altera\Controller;

use App\Controller\View;
use App\Controller\Session;
use Projects\Altera\Model\Students;

class Home
{
    public function Index()
    {
        Session::Set('basket',[12=>3,15=>89]);
        Session::Set('auth',[
            'role'=>'admin',
            'user'=>'damien',
            'last_connected'=>'2025'
        ]);

        var_dump(Session::Get('basket'));
        if(Session::Exists('auth'))
        {
            var_dump(Session::Get('auth'));
        }
     //   session_start();
        
        //echo session_id();
        // $_SESSION['basket'] = [];
        // $_SESSION['basket'] = [12=>3];

        // $_SESSION['auth']   = 
        // [
        //     'role'=>'admin',
        //     'user'=>'damien',
        //     'last_connected'=>'2025'
        // ];
        // session_destroy();
        // unset($_SESSION['auth']);
        // if(isset($_SESSION['auth'])
        //     && is_array($_SESSION['auth']))
        // {
        //     echo 'bonjour Mr '.$_SESSION['auth']['user'];
        // }
        //$_SERVER
        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';

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