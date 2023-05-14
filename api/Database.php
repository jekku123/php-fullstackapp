<?php

class Database
{
    private $host = "db";
    private $dbname = "fullstackapp";
    private $user = "root";
    private $pass = "lionPass";

    private $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE =>
    PDO::FETCH_ASSOC];

    private $conn = null;

    public function connect()
    {
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->user, $this->pass, $this->options);
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }

        return $this->conn;
    }

    public function sanitize_input($data)
    {
        $data = strip_tags($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        $data = trim($data);
        return $data;
    }

    public function jsonResponse($status, $content)
    {
        return json_encode(['status' => $status, 'message' => $content]);
    }

    public function is_valid($data, $type)
    {
        switch ($type) {
            case 'text':
                return preg_match("/^[a-zA-Z-' ]*$/", $data);
                break;

            case 'mobile':
                return (preg_match('/^[0-9]{10}+$/', $data) && strlen($data) === 10);
                break;

            case 'email':
                return filter_var($data, FILTER_VALIDATE_EMAIL);
                break;
            default:
                break;
        }
    }
}
