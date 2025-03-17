<?php
class ModelManga extends Model {
    // Get all the categories from the database
    public function getCategories() {
        $req = $this->getDb()->query('SELECT categories.id_category, categories.category_name, categories.description FROM categories');
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEditorList() {
        $req = $this->getDb()->query("SELECT id_editor, `name` FROM editor");
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    // Get all mangas from the database by category (shonen)
    public function getMangaListByCat(string $category) {
        $req = $this->getDb()->prepare(
            'SELECT *
            FROM manga
            INNER JOIN manga_category ON manga.id_manga = manga_category.manga_id
            INNER JOIN categories ON manga_category.category_id = categories.id_category
            WHERE categories.category_name = :category');
        $req->bindParam(':category', $category, PDO::PARAM_STR);
        $req->execute();
        $data   = $req->fetchAll(PDO::FETCH_ASSOC);
        $mangas = [];
        foreach ($data as $manga) {
            $mangas[] = new Manga($manga);
        }
        return $mangas;
    }

    public function getMangaByName(string $name) {
        $req = $this->getDb()->prepare("SELECT manga.id_manga FROM manga WHERE manga.name LIKE :name");
        $req->bindParam(":name", $name, PDO::PARAM_STR);
        $req->execute();
        return $req->fetch(PDO::FETCH_COLUMN);
    }

    public function getMangaRecommendation() {
        $req = $this->getDb()->query(
            'SELECT
            manga.id_manga, manga_recommendation.message, manga.name, manga.id_author, manga.description, manga.published_date, manga.thumbnail
            FROM manga
            INNER JOIN manga_recommendation ON manga.id_manga = manga_recommendation.id_manga');
        $data            = $req->fetchAll(PDO::FETCH_ASSOC);
        $recommendations = [];
        foreach ($data as $recommendation) {
            $message = $recommendation['message'];
            unset($recommendation['message']);
            $manga             = $recommendation;
            $recommendations[] = new MangaRecommendation(new Manga($manga), $message);
        }

        return $recommendations;
    }

    //For the manga/id page
    public function getManga(int $id) {
        $req = $this->getDb()->prepare(
            'SELECT
                    `id_manga`,
                    `name`,
                    `id_author`,
                    `description`,
                    `published_date`,
                    `thumbnail`
                FROM
                    `manga`
                WHERE
                    id_manga = :id');
        $req->bindParam('id', $id, PDO::PARAM_INT);
        $req->execute();

        $result = $req->fetch(PDO::FETCH_ASSOC);

        return $result ? new Manga($result) : null;
    }

    //Get all the volumes of a manga
    public function getMangaVolumes(int $id) {
        $req = $this->getDb()->prepare(
            'SELECT
                `id_volume`
            FROM
                `manga_volume`
            WHERE
                id_manga = :id');
        $req->bindParam('id', $id, PDO::PARAM_INT);
        $req->execute();
        $volumes = [];
        while ($result = $req->fetch(PDO::FETCH_COLUMN)) {
            $volumes[] = $result;
        }
        return $volumes;
    }

    public function addVolumes(int $id_manga, int $volumes) {
        while ($volumes && $volumes > 0) {
            $req = $this->getDb()->prepare(
                'INSERT INTO `manga_volume` (`id_manga`, `id_volume`) VALUES (:id_manga, :id_volume)'
            );
            $req->bindParam(':id_manga', $id_manga, PDO::PARAM_INT);
            $req->bindParam(':id_volume', $volumes, PDO::PARAM_INT);
            $req->execute();
            $volumes--;
        }
        return true;
    }

// Add a new volume
    public function addVolume($id_manga, $id_volume) {
        $req = $this->getDb()->prepare(
            "INSERT INTO manga_volume (id_manga, id_volume) VALUES (:id_manga, :id_volume)"
        );
        $req->bindParam(":id_manga", $id_manga, PDO::PARAM_INT);
        $req->bindParam(":id_volume", $id_volume, PDO::PARAM_INT);
        return $req->execute();
    }

// Delete a volume
    public function deleteVolume($id_manga, $id_volume) {
        $req = $this->getDb()->prepare(
            "DELETE FROM manga_volume WHERE id_manga = :id_manga AND id_volume = :id_volume"
        );
        $req->bindParam(":id_manga", $id_manga, PDO::PARAM_INT);
        $req->bindParam(":id_volume", $id_volume, PDO::PARAM_INT);
        return $req->execute();
    }

    public function updateManga(int $id, string $name, string $description, string $published_date, string $thumbnail) {
        $req = $this->getDb()->prepare(
            'UPDATE `manga`
            SET
            `name` = :name,
            `description` = :description,
            `published_date` = :published_date,
            `thumbnail` = :thumbnail
            WHERE id_manga = :id');
        $req->bindParam(':name', $name, PDO::PARAM_STR);
        $req->bindParam(':description', $description, PDO::PARAM_STR);
        $req->bindParam(':published_date', $published_date, PDO::PARAM_STR);
        $req->bindParam(':thumbnail', $thumbnail, PDO::PARAM_STR);
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();
    }
    // Get a mangaka by name (for the create method)
    public function getMangaAuthorByName(string $name) {
        $req = $this->getDb()->prepare(
            'SELECT
                id_author
            FROM
                author
            WHERE
                name = :name');
        $req->bindParam(':name', $name, PDO::PARAM_STR);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    //Create a manga
    public function createManga(string $name, int $author, string $description, string $published_date, string $thumbnail) {
        $req = $this->getDb()->prepare(
            'INSERT INTO
                    manga (name, id_author, description, published_date, thumbnail)
            VALUES
                    (:name, :author, :description, :published_date, :thumbnail)');
        $req->bindParam(':name', $name, PDO::PARAM_STR);
        $req->bindParam(':author', $author, PDO::PARAM_STR);
        $req->bindParam(':description', $description, PDO::PARAM_STR);
        $req->bindParam(':published_date', $published_date, PDO::PARAM_STR);
        $req->bindParam(':thumbnail', $thumbnail, PDO::PARAM_STR);
        $req->execute();
    }

    public function getMangaById(int $id) {
        $req = $this->getDb()->prepare(
            'SELECT
                manga.id_manga,
                manga.name,
                manga.id_author,
                manga.description,
                manga.published_date,
                manga.thumbnail,
                author.name AS author_name,
                GROUP_CONCAT(DISTINCT categories.category_name SEPARATOR \', \') AS category_names,
                editor.name AS editor_name
            FROM
                manga
            LEFT JOIN
                manga_category ON manga.id_manga = manga_category.manga_id
            LEFT JOIN
                categories ON manga_category.category_id = categories.id_category
            INNER JOIN
                manga_editor ON manga_editor.id_manga = manga.id_manga
            INNER JOIN
                editor ON manga_editor.id_editor = editor.id_editor
            INNER JOIN
                author ON manga.id_author = author.id_author
            WHERE
                manga.id_manga = :id
            GROUP BY
                manga.id_manga, manga.name, manga.id_author, manga.description, manga.published_date, manga.thumbnail, author.name, editor.name;');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();
        $data        = $req->fetch(PDO::FETCH_ASSOC);
        $author_name = $data['author_name'];
        $categories  = $data['category_names'];
        $editor_name = $data['editor_name'];
        unset($data['author_name']);
        unset($data['category_names']);
        unset($data['editor_name']);
        return new MangaDTO(new Manga($data), $author_name, $categories, $editor_name);
    }

    public function getAlsoLiked(int $id) {
        $req = $this->getDb()->prepare("SELECT m.id_manga, m.name, m.thumbnail
            FROM manga m
            JOIN manga_category mc ON m.id_manga = mc.manga_id
            WHERE mc.category_id = (
                SELECT category_id
                FROM manga_category
                WHERE manga_id = :id_manga
                LIMIT 1
            )
            AND m.id_manga != :id_manga
            ORDER BY RAND()
            LIMIT 3;");
        $req->bindParam(':id_manga', $id, PDO::PARAM_INT);
        $req->execute();
        $data   = $req->fetchAll(PDO::FETCH_ASSOC);
        $mangas = [];
        foreach ($data as $manga) {
            $mangas[] = new Manga($manga);
        }
        return $mangas;
    }

    public function deleteManga($id) {
        $req = $this->getDb()->prepare('DELETE FROM `manga` WHERE id_manga = :id');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();
    }

    // public function getCategoryDatas($id){
    //     $req = $this->getDb()->prepare("SELECT * FROM category WHERE id_category = :id_category");
    //     $req->execute(['id_category' => $id]);
    //     $category = $req->fetch();
    //     return $category;
    // }

    public function getCategoryDatas($name) {
        $req = $this->getDb()->prepare("SELECT `id_category`, `category_name`, `description` FROM categories WHERE category_name = :category_name");
        $req->execute(['category_name' => $name]);
        $category = $req->fetch(PDO::FETCH_ASSOC);
        return new Category($category);
    }

    public function getCategoryMangas($id) {
        $req = $this->getDb()->prepare("SELECT `manga`.* FROM manga INNER JOIN manga_category ON `manga`.`id_manga` = `manga_category`.`manga_id` INNER JOIN `categories` ON `manga_category`.`category_id` = `categories`.`id_category` WHERE `manga_category`.`category_id` = :id_category");
        $req->execute([':id_category' => $id]);
        $mangas = [];
        while ($result = $req->fetch(PDO::FETCH_ASSOC)) {
            $mangas[] = new Manga($result);
        }
        return $mangas;
    }

    public function createAuthor($authorName) {
        $req = $this->getDb()->prepare("INSERT INTO author (name) VALUES (:name)");
        $req->bindParam(':name', $authorName);
        $req->execute();
    }

    public function getMangaAuthor($name) {
        $req = $this->getDb()->prepare('SELECT `name` FROM `author` WHERE `name` LIKE :name ORDER BY `name` ASC LIMIT 4');
        $req->bindParam(':name', $name, PDO::PARAM_STR);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchManga($str) {
        $str = trim($str);
        $req = $this->getDb()->prepare(" SELECT
                manga.id_manga,
                manga.name,
                manga.id_author,
                manga.description,
                manga.published_date,
                manga.thumbnail,
                author.name AS author_name
            FROM
                manga
            INNER JOIN
                author ON manga.id_author = author.id_author
            WHERE
                manga.name LIKE :str OR `author`.`name` LIKE :str");
        $req->bindParam(":str", $str, PDO::PARAM_STR);
        $req->execute();

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mangaReview($id) {
        $req = $this->getDb()->prepare(
            "SELECT review.*, user.username, user.profile_pic
            FROM `review`
            INNER JOIN `user` ON review.id_user = user.id_user
            WHERE `id_manga` = :id"
        );
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteReview(int $id) {
        $req = $this->getDb()->prepare(
            "DELETE FROM `review` WHERE `id_review` = :id"
        );
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();
    }

    public function addReview($review, $id_manga, $id_user) {
        if (isset($_POST['review'])) {
            $req = $this->getDb()->prepare(
                "INSERT INTO `review` (`review`, `id_manga`, `id_user`, `published_date`) VALUES (:review, :id_manga, :id_user, NOW())"
            );
            $req->bindParam(':review', $review, PDO::PARAM_STR);
            $req->bindParam(':id_manga', $id_manga, PDO::PARAM_INT);
            $req->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $req->execute();
        }
    }

    public function searchAdminManga($str) {
        $str = trim($str);
        $req = $this->getDb()->prepare(
            "SELECT
                manga.id_manga,
                manga.name,
                manga.id_author,
                manga.description,
                manga.published_date,
                manga.thumbnail,
                author.name AS author_name,
                GROUP_CONCAT(DISTINCT categories.category_name SEPARATOR ', ') AS category_names,
                editor.name AS editor_name
            FROM manga
            LEFT JOIN manga_category ON manga.id_manga = manga_category.manga_id
            LEFT JOIN categories ON manga_category.category_id = categories.id_category
            LEFT JOIN manga_editor ON manga.id_manga = manga_editor.id_manga
            LEFT JOIN editor ON manga_editor.id_editor = editor.id_editor
            INNER JOIN author ON manga.id_author = author.id_author
            WHERE manga.name LIKE :str
            GROUP BY manga.id_manga;");
        $req->bindParam(":str", $str, PDO::PARAM_STR);
        $req->execute();

        while ($result = $req->fetch(PDO::FETCH_ASSOC)) {
            $author_name = $result['author_name'];
            $categories  = $result['category_names'];
            $editor_name = $result['editor_name'];
            unset($result['author_name']);
            unset($result['category_names']);
            unset($result['editor_name']);
            $mangas[] = new MangaDTO(new Manga($result), $author_name, $categories, $editor_name);
        }
        return $mangas ?? [];
    }

    public function getAuthorById($id) {
        $req = $this->getDb()->prepare('SELECT `id_author`, `name` FROM `author` WHERE `id_author` = :id');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();
        return new Author($req->fetch(PDO::FETCH_ASSOC));
    }

    public function addCategory($id_manga, $id_category) {
        $req = $this->getDb()->prepare("INSERT INTO manga_category(manga_id, category_id) VALUES (:id_manga,:id_category)");
        $req->bindParam(":id_manga", $id_manga, PDO::PARAM_INT);
        $req->bindParam(":id_category", $id_category, PDO::PARAM_INT);
        $req->execute();
    }

    public function addEditor($id_manga, $id_editor) {
        $req = $this->getDb()->prepare("INSERT INTO manga_editor(id_manga, id_editor) VALUES (:id_manga,:id_editor)");
        $req->bindParam(":id_manga", $id_manga, PDO::PARAM_INT);
        $req->bindParam(":id_editor", $id_editor, PDO::PARAM_INT);
        $req->execute();
    }
}
