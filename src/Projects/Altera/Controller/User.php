<?php
namespace Projects\Altera\Controller;

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

    public function getUserById(int $id,string $title='')
    {
      //  session_start();
        echo '----';
        var_dump($_SESSION);
        echo '----';
        var_dump($id);
        var_dump($title);
    }
}