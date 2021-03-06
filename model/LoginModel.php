<?php

require_once('DBModel.php');

class LoginModel extends DBModel
{
    function getAll()
    {
        $query = $this->getDb()->prepare('SELECT * FROM user');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUserByUsername($username)
    {
        $query = $this->getDb()->prepare('SELECT * FROM user WHERE username = ?');
        $query->execute(array(($username)));
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function isMailInUse($email)
    {
        $query = $this->getDb()->prepare('SELECT email FROM user');
        $query->execute();
        $resultado = $query->fetchAll(PDO::FETCH_COLUMN);
        foreach ($resultado as $date)
            if ($email === $date)
                return true;
        return false;
    }

    //** hace una  */

    public function getUsers()
    {
        $query = $this->getDb()->prepare('SELECT * FROM user');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    //** crea un nuevo usuario en la tabla user */

    public function addNewUser($user, $pass, $email)
    {
        $passEnc = password_hash($pass, PASSWORD_DEFAULT);
        $query = $this->getDb()->prepare('INSERT INTO user (username,password,email) VALUES (?, ?, ?)');
        $query->execute([$user, $passEnc, $email]);
    }


    //** esta funcion borra un usuario de la tabla user */

    function deleteUser($id){
        $sentencia = $this->getDb()->prepare("DELETE FROM user WHERE id=?");
        $sentencia->execute([$id]);
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }


    // * Estas funciones dan de alta o baja es estado del usuario de admin a usuaio y viceversa /

    function updateToUser($id){
        $sentencia = $this->getDb()->prepare('UPDATE user SET admin=0 WHERE id=?');
        $sentencia->execute(array($id));
    }

    function updateToAdmin($id){
        $sentencia = $this->getDb()->prepare('UPDATE user SET admin=1 WHERE id=?');
        $sentencia->execute(array($id));
    }

}
