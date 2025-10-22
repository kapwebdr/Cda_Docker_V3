<?php
namespace Projects\Altera\Controller;

use App\Controller\View;

class User
{

    // routes, /login method POST qui récup le formulaire de login
    /*
        <form method="post" action="/login">
            <input type="text" name="user/>
            <input type="password" name="password"/>
            <input type="submit" name="connection"/>
        </form>
    */
    public function login()
    {
        /*
        => On recherche en Base de données si user existe.
        => On vérfie le Hash du password dans la base vs le hash du password envoyé.
        => Si tout est OK :
            => on créé la session : 
                Session::Set('auth',[ données des résultats de la base]);
        */
    }

    public function isConnected()
    {
        /*
            je vérifie si Session::Exist('auth') est OK
            Si ok, je vérfie si le user + password hash dans la session,
            sont bon dans la bdd + compte actif. 
            Si tout est bon return true
            Si un soucis 
            session_destroy() et redirection page login.
        */
    }

    // public function getUserById($vars)
    // {
    //     var_dump($vars);
    //     $id = $vars['id'];
    // }
    public function uploadAvatar()
    {
        echo '<pre>';
        var_dump($_FILES);
        echo '</pre>';
        // if(isset($_FILES)
        //     && is_array($_FILES)
        //     && isset($_FILES['fichiers'])
        //     && is_array($_FILES['fichiers'])
        //     && isset($_FILES['fichiers']['tmp_name'])
        //     )
        // {
        //     $fichiers = $_FILES['fichiers'];

        //     echo $fichiers['name'].'('.$fichiers['size'].')'.'<br/>';
        //     echo $fichiers['tmp_name'].'<br/>';

        //     $result = move_uploaded_file($fichiers['tmp_name'],DIR_PROJECT_PRIVATE.'uploads/'.$fichiers['name']);
        //     var_dump($result);
        // }

        foreach($_FILES['fichiers']['name'] as $key=>$name)
        {
            $tmp_name = $_FILES['fichiers']['tmp_name'][$key];
            $result = move_uploaded_file($tmp_name,DIR_PROJECT_PRIVATE.'uploads/'.$name);
        }

        echo '<pre>';
            var_dump($_POST);
        echo '</pre>';
        
        View::Init();
        View::$smarty->display('upload.tpl');
    }
    public function getUserById(int $id,string $title='')
    {
      //  session_start();
        echo '----';
        var_dump($_SESSION);
        echo '----';
        var_dump($id);
        var_dump($title);
    }

    public function getAvatar($file)
    {
        $filepath = DIR_PROJECT_PRIVATE.'uploads/'.$file;
        if( file_exists($filepath) )
        {
            header('Content-Type: image/png');
            header('Content-Length: ' . filesize($filepath));
            header('Cache-Control: public, max-age=86400'); // 1 jour
            header('Content-Disposition: inline; filename="' . basename($filepath) . '"');
            readfile($filepath);
        }
    }

}