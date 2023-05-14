<?php

class Datastorage
{
    private $conn = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function get_all()
    {
        $sql = "SELECT * FROM users";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();
        $users = $stmt->fetchAll();

        return $users;
    }

    public function get($id)
    {
        $sql = "SELECT * FROM users";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
        $user = $stmt->fetch();

        return $user;
    }

    public function add($username, $email, $mobile)
    {
        $sql = "INSERT INTO users 
                (username, email, mobile) 
                VALUES
                (:username, :email, :mobile)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mobile', $mobile);

        $stmt->execute();

        return true;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM users 
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return true;
    }

    public function update($id, $username, $email, $mobile)
    {
        $sql = "UPDATE users SET 
                username = :username, 
                email =:email, 
                mobile =:mobile,
                updated_at =:updated_at 
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $updated_at = date('Y-m-d');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':updated_at', $updated_at);

        $stmt->execute();

        return true;
    }
}
