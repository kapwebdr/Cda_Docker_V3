<?php
namespace Projects\Altera\Controller;

use App\Controller\View;
use App\Controller\Session;
use App\Controller\ImageResizer;
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
        View::Init();

        // echo '<pre>';
        // var_dump($_FILES);
        // echo '</pre>';
         if(isset($_FILES)
            && is_array($_FILES)
            && isset($_FILES['fichiers'])
            && is_array($_FILES['fichiers'])
            && isset($_FILES['fichiers']['tmp_name'])
            )
        {
        //     $fichiers = $_FILES['fichiers'];

        //     echo $fichiers['name'].'('.$fichiers['size'].')'.'<br/>';
        //     echo $fichiers['tmp_name'].'<br/>';

        //     $result = move_uploaded_file($fichiers['tmp_name'],DIR_PROJECT_PRIVATE.'uploads/'.$fichiers['name']);
        //     var_dump($result);
        

            foreach($_FILES['fichiers']['name'] as $key=>$name)
            {
                $tmp_name = $_FILES['fichiers']['tmp_name'][$key];
                $result = move_uploaded_file($tmp_name,DIR_PROJECT_PRIVATE.'uploads/'.$name);

                $image= new ImageResizer(
                    [
                        'width'             => 50,
                        'height'            => 50,
                        'mode'              => 'cover',        // fit|cover|width|height
                        'output'            => 'png',        // format par défaut
                        'quality'           => 82,           // pour jpeg/webp
                        'png_compression'   => 9,            // 0 (rapide) → 9 (max compression)
                        'strip'             => true,
                        'background'        => 'white',
                        'progressive'       => true,
                    ]
                );
                $image->process(DIR_PROJECT_PRIVATE.'uploads/'.$name,
                DIR_PROJECT_PRIVATE.'uploads/50x50/'.$name);

                $image= new ImageResizer(
                    [
                        'width'             => 200,
                        'height'            => 200,
                        'mode'              => 'width',        // fit|cover|width|height
                        'output'            => 'png',        // format par défaut
                        'quality'           => 82,           // pour jpeg/webp
                        'png_compression'   => 9,            // 0 (rapide) → 9 (max compression)
                        'strip'             => true,
                        'background'        => 'white',
                        'progressive'       => true,
                    ]
                );
                $image->process(DIR_PROJECT_PRIVATE.'uploads/'.$name,
                DIR_PROJECT_PRIVATE.'uploads/200x200/'.$name);

                $image= new ImageResizer(
                    [
                        'width'             => 1000,
                        'height'            => 500,
                        'mode'              => 'height',        // fit|cover|width|height
                        'output'            => 'png',        // format par défaut
                        'quality'           => 82,           // pour jpeg/webp
                        'png_compression'   => 9,            // 0 (rapide) → 9 (max compression)
                        'strip'             => true,
                        'background'        => 'white',
                        'progressive'       => true,
                    ]
                );
                $image->process(DIR_PROJECT_PRIVATE.'uploads/'.$name,
                DIR_PROJECT_PRIVATE.'uploads/1000x100/'.$name);
            }
            echo '<pre>';
                var_dump($_POST);
            echo '</pre>';
        
        }

        if($_POST['valider'] &&
        $_POST['token'] = Session::Get('token')
        )
        {
            // requetes bdd... 
            // dsdsdf
            //
            header('location:/categories');
            exit();
        }
        else {
            $token = md5(microtime());
            Session::Set('token',$token);
            View::$smarty->assign('token',$token );
        }
        

        /**
         * 
         * <input type="hidden" name="token" value="{$token}"/>
          */


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