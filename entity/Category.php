<?php
class Category {
                             // Properties
    private $id_category;       // Unique identifier for the category
    private $category_name;           // Name of the category
    private $description;    // Description of the category

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

    // Getters
    public function getId_category() {
        return $this->id_category;
    }

    public function getCategory_name() {
        return $this->category_name;
    }

    public function getDescription() {
        return $this->description;
    }

    // Setters
    public function setId_category(int $id_category) {
        $this->id_category = $id_category;
    }

    public function setCategory_name(string $name) {
        $this->category_name = $name;
    }

    public function setDescription(string $description) {
        $this->description = $description;
    }
}