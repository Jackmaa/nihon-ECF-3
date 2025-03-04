<?php
class ControllerManga extends Controller {

    public function __construct(AltoRouter $router) {
        parent::__construct($router);
    }

    // Method to display the home page
    public function home() {
        $model          = new ModelManga();
        $recommendation = $model->getMangaRecommendation();
        $categories     = $model->getCategories();
        foreach ($categories as $category) {
            $mangas[$category['category_name']] = $model->getMangaListByCat($category['category_name']);
        }

        require_once './view/home.php';
    }

    // Method to update a manga entry
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new ModelManga();
            var_dump($_FILES);

            // Handle file upload for thumbnail
            $thumbnail     = $_FILES['thumbnail']['name'];
            $tmp_thumbnail = $_FILES['thumbnail']['tmp_name'];
            move_uploaded_file($tmp_thumbnail, './public/asset/img/' . $thumbnail);
            $thumbnail = './public/asset/img/' . $thumbnail;

            // Update manga details in the database
            $model->updateManga($_POST['id'], $_POST['name'], $_POST['description'], $_POST['published_date'], $thumbnail);
            var_dump($_POST);

            // Redirect to home page after update
            header('Location: /');
        } else {
            $get  = new ModelManga();
            $data = $get->getManga($id);
            require_once './view/update.php';
        }
    }

    // Method to create a new manga entry
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model  = new ModelManga();
            $author = $model->getMangaAuthorByName($_POST['author']);
            if (! $author) {
                // Author does not exist, create a new author
                $model->createAuthor($_POST['author']);
                $author = $model->getMangaAuthorByName($_POST['author']);
            }

            // Get author ID and other manga details from the form
            $authorId       = $author['id_author'];
            $name           = $_POST['name'];
            $description    = $_POST['description'];
            $published_date = $_POST['published_date'];
            $thumbnail      = $_FILES['thumbnail']['name'];
            $tmp_thumbnail  = $_FILES['thumbnail']['tmp_name'];
            move_uploaded_file($tmp_thumbnail, './public/asset/img/' . $thumbnail);
            $thumbnail = './public/asset/img/' . $thumbnail;

            // Create new manga entry in the database
            $model->createManga($name, $authorId, $description, $published_date, $thumbnail);
            $message = 'Manga created successfully.';
            header('Location: ' . $this->router->generate('home'));
            exit;
        }
        require_once './view/createmanga.php';
    }

    // Method to read a manga entry by ID
    public function read($id) {
        $model = new ModelManga();
        $manga = $model->getMangaById($id);
        var_dump($manga);
        require_once './view/manga.php';
    }

    // Method to delete a manga entry by ID
    public function delete($id) {
        $model = new ModelManga();
        $model->deleteManga($id);
        header('Location: /');
    }

    // Method to handle AJAX request for author search
    public function authorAJAX() {
        $search  = '%' . $_POST['author'] . '%';
        $model   = new ModelManga();
        $authors = $model->getMangaAuthor($search);
        echo json_encode($authors);
        header('Content-Type: application/json');
    }
}