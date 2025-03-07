<?php
class ModelManga extends Model {
    // Get all the categories from the database
    public function getCategories() {
        $req = $this->getDb()->query('SELECT categories.category_name, categories.description FROM categories');
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

    public function deleteManga($id) {
        $req = $this->getDb()->prepare('DELETE FROM `manga` WHERE id_manga = :id');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();
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

    public function searchAdminManga($str) {
        $str = trim($str);
        $req = $this->getDb()->prepare(" SELECT
                manga.id_manga,
                manga.name,
                manga.id_author,
                manga.description,
                manga.published_date,
                manga.thumbnail
            FROM
                manga
            WHERE
                manga.name LIKE :str");
        $req->bindParam(":str", $str, PDO::PARAM_STR);
        $req->execute();

        while ($result = $req->fetch(PDO::FETCH_ASSOC)) {
            $mangas[] = new Manga($result);
        }
        return $mangas ?? [];
    }

    public function getAuthorById($id) {
        $req = $this->getDb()->prepare('SELECT `id_author`, `name` FROM `author` WHERE `id_author` = :id');
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();
        return new Author($req->fetch(PDO::FETCH_ASSOC));
    }
}
