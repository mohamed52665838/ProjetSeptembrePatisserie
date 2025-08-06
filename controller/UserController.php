<?php

    include_once __DIR__ . '/../config/Connection.php';
    include_once __DIR__ . '/../model/User.php';

    class UserController {
        // public function getUsers() {
        //     $connection = Config::getConnexion();
        //     $query = "SELECT * FROM users";
        //     $stat = $connection->query($query);
        //     return $stat->fetchAll(PDO::FETCH_ASSOC);
        // }
       public function list()
    {
        $db = Connection::getConnexion();
        try {
            $liste = $db->query("SELECT * FROM users");
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
        /**
         * Summary of addUser
         * @param mixed $userObj (nom, prenom, email, password, role)
         * @return void
         */

public function userExists(string $username, string $email): bool {
    $connection = Connection::getConnexion();
    $sql = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['username' => $username, 'email' => $email]);
    return $stmt->fetchColumn() > 0;
}


     public function addUser(User $userObj): bool {
    $connection = Connection::getConnexion();

    // Vérification doublon
    if ($this->userExists($userObj->getUsername(), $userObj->getEmail())) {
        throw new Exception("⚠️ Ce username ou email existe déjà !");
    }

    $userObj->setPassword(password_hash($userObj->getPassword(), PASSWORD_BCRYPT));

    $sql = "INSERT INTO users (nom, prenom, username, email, role, password) 
            VALUES (:nom, :prenom, :username, :email, :role, :password)";
    $stat = $connection->prepare($sql);

    $stat->bindValue(':nom', $userObj->getNom());
    $stat->bindValue(':prenom', $userObj->getPenom());
    $stat->bindValue(':username', $userObj->getUsername());
    $stat->bindValue(':email', $userObj->getEmail());
    $stat->bindValue(':role', $userObj->getRole());
    $stat->bindValue(':password', $userObj->getPassword());

    return $stat->execute();
}

   
function delete($id)
    {
        $db = Connection::getConnexion();
        
        $req = $db->prepare("DELETE FROM users WHERE id = :id");
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function updateUser(User $userObj, int $id): bool {
    $connection = Connection::getConnexion();
    $sql = "UPDATE users 
            SET nom = :nom, prenom = :prenom, username = :username, 
                email = :email, role = :role 
            WHERE id = :id";
    $stat = $connection->prepare($sql);

    $stat->bindValue(':nom', $userObj->getNom());
    $stat->bindValue(':prenom', $userObj->getPenom());
    $stat->bindValue(':username', $userObj->getUsername());
    $stat->bindValue(':email', $userObj->getEmail());
    $stat->bindValue(':role', $userObj->getRole());
    $stat->bindValue(':id', $id, PDO::PARAM_INT);

    return $stat->execute();
}



}

?>