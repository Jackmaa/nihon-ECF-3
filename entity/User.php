<?php
class User {
    private $id_user;
    private $username;
    private $email;
    private $password;
    private $signing_date;
    private $id_role;
    private $premium;
    private $profile_pic;

    public function __construct(array $datas) {
        $this->hydrate($datas);
    }

    public function hydrate(array $datas) {
        foreach ($datas as $key => $value) {
            $method = "set" . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    //GETTERS 

    public function getId_user() {
        return $this->id_user;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getSigning_date() {
        return $this->signing_date;
    }
    public function getId_role() {
        return $this->id_role;
    }
    public function getPremium() {
        return $this->premium;
    }
    public function getProfile_pic() {
        return $this->profile_pic;
    }

    //SETTERS 
    public function setId_user(int $id) {
        $this->id_user = $id;
    }
    public function setUsername(string $username) {
        $this->username = $username;
    }
    public function setEmail(string $email) {
        $this->email = $email;
    }
    public function setPassword(string $password) {
        $this->password = $password;
    }
    public function setSigning_date(string $signing_date) {
        $this->signing_date = new DateTime($signing_date);
    }
    public function setId_role(int $id_role) {
        $this->id_role = $id_role;
    }
    public function setPremium(bool $premium) {
        $this->premium = $premium;
    }
    public function setProfile_pic(string $profile_pic) {
        $this->profile_pic = $profile_pic;
    }
}