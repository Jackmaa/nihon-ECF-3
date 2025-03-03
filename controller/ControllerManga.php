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

    public function update($id) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new ModelManga();
            var_dump($_FILES);

            $thumbnail     = $_FILES['thumbnail']['name'];
            $tmp_thumbnail = $_FILES['thumbnail']['tmp_name'];
            move_uploaded_file($tmp_thumbnail, './public/asset/img/' . $thumbnail);
            $thumbnail = './public/asset/img/' . $thumbnail;

            $model->updateManga($_POST['id'], $_POST['name'], $_POST['description'], $_POST['published_date'], $thumbnail);
            var_dump($_POST);

            header('Location: /');

        } else {
            $get  = new ModelManga();
            $data = $get->getManga($id);
            require_once './view/update.php';
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model  = new ModelManga();
            $author = $model->getMangaAuthorByName($_POST['author']);
            if (! $author) {
                // Author does not exist, create a new author
                $model->createAuthor($_POST['author']);
                $author = $model->getMangaAuthorByName($_POST['author']);
            }

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

    public function read($id) {
        $model = new ModelManga();
        $manga = $model->getMangaById($id);
        var_dump($manga);
        require_once './view/manga.php';
    }

    public function delete($id) {
        $model = new ModelManga();
        $model->deleteManga($id);
        header('Location: /');
    }

    public function authorAJAX() {
        $search  = '%' . $_POST['author'] . '%';
        $model   = new ModelManga();
        $authors = $model->getMangaAuthor($search);
        echo json_encode($authors);
        header('Content-Type: application/json');
    }
}