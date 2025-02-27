<?php
class Manga {
    private $id_manga;
    private $name;
    private $description;
    private $published_date;
    private $thumbnail;

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

    public function getId_manga() {
        return $this->id_manga;
    }
    public function getName() {
        return $this->name;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getPublished_date() {
        return $this->published_date;
    }
    public function getThumbnail() {
        return $this->thumbnail;
    }

    //SETTERS 
    public function setId_manga(int $id_manga) {
        $this->id_manga = $id_manga;
    }
    public function setName(string $name) {
        $this->name = $name;
    }
    public function setDescription(string $description) {
        $this->description = $description;
    }
    public function setPublished_date(string $published_date) {
        $this->published_date = new DateTime($published_date);
    }
    public function setThumbnail(string $thumbnail) {
        $this->thumbnail = $thumbnail;
    }
}