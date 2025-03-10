<?php
class Borrow {
    private int $id_borrow;
    private int $id_manga;
    private int $id_user;
    private DateTime $borrow_date;
    private bool $user_premium;
    private string $return_date;

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
    public function getId() {
        return $this->id_borrow;
    }

    public function getId_manga() {
        return $this->id_manga;
    }

    public function getId_user() {
        return $this->id_user;
    }

    public function getBorrow_date() {
        return $this->borrow_date;
    }

    public function getUser_premium() {
        return $this->user_premium;
    }

    public function getReturn_date() {
        return $this->return_date;
    }
//SETTERS
    public function setId(int $id_borrow) {
        $this->id_borrow = $id_borrow;
    }

    public function setId_manga(int $id_manga) {
        $this->id_manga = $id_manga;
    }

    public function setId_user(int $id_user) {
        $this->id_user = $id_user;
    }

    public function setBorrow_date(string $borrow_date) {
        $this->borrow_date = new DateTime($borrow_date);
    }

    public function setUser_premium(bool $user_premium) {
        $this->user_premium = $user_premium;
    }

    public function setReturn_date($return_date) {
        $this->return_date = $return_date;
    }
}