<?php
class ControllerManga extends Controller {

    public function __construct(AltoRouter $router) {
        parent::__construct($router);
    }

    public function home() {
        $model  = new ModelManga();
        $mangas = $model->getMangaListByCat();
        require_once './view/home.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model          = new ModelManga();
            $author         = $model->getMangaAuthorByName($_POST['author']);
            $authorId       = $author['id_author'];
            $name           = $_POST['name'];
            $description    = $_POST['description'];
            $published_date = $_POST['published_date'];
            $thumbnail      = $_FILES['thumbnail']['name'];
            $tmp_thumbnail  = $_FILES['thumbnail']['tmp_name'];
            move_uploaded_file($tmp_thumbnail, './public/asset/img/' . $thumbnail);
            $thumbnail = './public/asset/img/' . $thumbnail;
            $model->createManga($name, $authorId, $description, $published_date, $thumbnail);
            $message = 'Manga created successfully.';
            header('Location: ' . $this->router->generate('home'));
            exit;
        }
        require_once './view/createmanga.php';
    }
}