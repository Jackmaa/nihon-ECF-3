<?php
class Manga {
    private $id_manga;
    private $name;
    private $description;
    private $published_date;
    private $thumbnail;
    private static $db;

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

    // Get the database connection
    protected function getDb() {
        if (self::$db == null) {
            self::setDb();
        }

        return self::$db;
    }

    // Set the database connection
    private static function setDb() {
        try {
            //charset utf8mb4 enables the storage of emoji (may not use it)
            self::$db = new PDO("mysql:host=localhost;dbname=nihon;charset=utf8mb4", "root", "");
        } catch (PDOException $e) {
            echo $e->getMessage();
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

    // Like System
    public function toggleLike($id_user) {
        $req = $this->getDb()->prepare("SELECT id_fav FROM fav WHERE id_user = ? AND id_manga = ?");
        $req->execute([$id_user, $this->id_manga]);
        $like = $req->fetch();

        if ($like) {
            $req = $this->getDb()->prepare("DELETE FROM fav WHERE id_user = ? AND id_manga = ?");
            $req->execute([$id_user, $this->id_manga]);
            error_log("Unliked manga_id: {$this->id_manga} by user_id: $id_user");
            return false; // Unliked
        } else {
            $req = $this->getDb()->prepare("INSERT INTO fav (id_user, id_manga) VALUES (?, ?)");
            $req->execute([$id_user, $this->id_manga]);
            error_log("Liked manga_id: {$this->id_manga} by user_id: $id_user");
            return true; // Liked
        }
    }

    public function getLikesCount() {
        $req = $this->getDb()->prepare("SELECT COUNT(*) FROM fav WHERE id_manga = ?");
        $req->execute([$this->id_manga]);
        $count = $req->fetchColumn();
        error_log("Manga_id {$this->id_manga} has $count likes");
        return $count;
    }
}
