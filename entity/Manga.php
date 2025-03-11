<?php
class Manga implements JsonSerializable {
                             // Properties
    private $id_manga;       // Unique identifier for the manga
    private $name;           // Name of the manga
    private $description;    // Description of the manga
    private $published_date; // Publication date of the manga
    private $thumbnail;      // Thumbnail image URL for the manga
    private static $db;      // Static database connection

    // Constructor
    public function __construct(array $datas) {
        // Hydrate the object with provided data
        $this->hydrate($datas);
    }

    // Hydrate the object with data
    public function hydrate(array $datas) {
        foreach ($datas as $key => $value) {
            // Generate the setter method name (e.g., setName for 'name')
            $method = "set" . ucfirst($key);

            // Check if the setter method exists and call it
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Get the database connection
    protected function getDb() {
        // Initialize the database connection if it hasn't been set
        if (self::$db == null) {
            self::setDb();
        }

        return self::$db;
    }

    // Set the database connection
    private static function setDb() {
        try {
            // Initialize the PDO connection with UTF-8 encoding
            self::$db = new PDO("mysql:host=localhost;dbname=nihon;charset=utf8mb4", "root", "");
        } catch (PDOException $e) {
            // Handle database connection errors
            echo $e->getMessage();
        }
    }

    // Getters
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

    // Setters
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
        // Convert the published date string to a DateTime object
        $this->published_date = new DateTime($published_date);
    }

    public function setThumbnail(string $thumbnail) {
        $this->thumbnail = $thumbnail;
    }

    // Like System
    public function toggleLike($id_user) {
        // Check if the user has already liked the manga
        $req = $this->getDb()->prepare("SELECT id_fav FROM fav WHERE id_user = ? AND id_manga = ?");
        $req->execute([$id_user, $this->id_manga]);
        $like = $req->fetch();

        if ($like) {
            // If the user has already liked the manga, remove the like
            $req = $this->getDb()->prepare("DELETE FROM fav WHERE id_user = ? AND id_manga = ?");
            $req->execute([$id_user, $this->id_manga]);
            error_log("Unliked manga_id: {$this->id_manga} by user_id: $id_user");
            return false; // Unliked
        } else {
            // If the user hasn't liked the manga, add a like
            $req = $this->getDb()->prepare("INSERT INTO fav (id_user, id_manga) VALUES (?, ?)");
            $req->execute([$id_user, $this->id_manga]);
            error_log("Liked manga_id: {$this->id_manga} by user_id: $id_user");
            return true; // Liked
        }
    }

    // Get the total number of likes for the manga
    public function getLikesCount() {
        $req = $this->getDb()->prepare("SELECT COUNT(*) FROM fav WHERE id_manga = ?");
        $req->execute([$this->id_manga]);
        $count = $req->fetchColumn();
        error_log("Manga_id {$this->id_manga} has $count likes");
        return $count;
    }

    // Check if the manga is liked by a specific user
    public function isLikedByUser($id_user) {
        $req = $this->getDb()->prepare("SELECT COUNT(*) FROM fav WHERE id_user = ? AND id_manga = ?");
        $req->execute([$id_user, $this->id_manga]);
        return $req->fetchColumn() > 0; // Returns true if the user has liked the manga
    }

    // Serialize the object to JSON
    public function jsonSerialize(): mixed {
        return [
            'id_manga'       => $this->id_manga,
            'name'           => $this->name,
            'description'    => $this->description,
            'published_date' => $this->published_date->format('Y-m-d'), // Format the date as a string
            'thumbnail'      => $this->thumbnail,
        ];
    }
}