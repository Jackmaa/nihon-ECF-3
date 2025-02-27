<?php
class ControllerManga {
    public function home() {
        $model  = new ModelManga();
        $mangas = $model->getMangaList();
        require_once './view/home.php';
    }
}