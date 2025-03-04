<?php
class Author {
    private $id_author;
    private $name;

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

    public function getId_author() {
        return $this->id_author;
    }
    public function getName() {
        return $this->name;
    }

    //SETTERS 
    public function setId_author(int $id_author) {
        $this->id_author = $id_author;
    }
    public function setName(string $name) {
        $this->name = $name;
    }
}