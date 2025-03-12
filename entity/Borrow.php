<?php
class Borrow {
    private int $id_borrow;
    private int $id_manga;
    private int $id_user;
    private int $id_volume;
    private DateTime $borrow_date;
    private DateTime $return_date;

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
    public function getId_borrow() {
        return $this->id_borrow;
    }
    public function getId_user() {
        return $this->id_user;
    }
    public function getId_manga() {
        return $this->id_manga;
    }

    public function getId_volume() {
        return $this->id_volume;
    }

    public function getBorrow_date() {
        return $this->borrow_date;
    }

    public function getReturn_date() {
        return $this->return_date;
    }
//SETTERS
    public function setId_borrow(int $id_borrow) {
        $this->id_borrow = $id_borrow;
    }

    public function setId_manga(int $id_manga) {
        $this->id_manga = $id_manga;
    }

    public function setId_user(int $id_user) {
        $this->id_user = $id_user;
    }

    public function setId_volume(int $id_volume) {
        $this->id_volume = $id_volume;
    }

    public function setBorrow_date(string $borrow_date) {
        $this->borrow_date = new DateTime($borrow_date);
    }

    public function setReturn_date($return_date) {
        $this->return_date = new DateTime($return_date);
    }
}