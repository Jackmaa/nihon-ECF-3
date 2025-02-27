<?php
class ControllerManga {
    public function home() {
        $model  = new ModelManga();
        $mangas = $model->getMangaListByCat();
        require_once './view/home.php';
    }
}