<?php
class ModelManga extends Model {
    public function getMangaList() {
        $req  = $this->getDb()->query('SELECT `id_manga`, `name`, `description`, `published_date`, `thumbnail` FROM `manga`');
        $data = $req->fetch(PDO::FETCH_ASSOC);
        var_dump($data);
        return new Manga($data);
    }
}