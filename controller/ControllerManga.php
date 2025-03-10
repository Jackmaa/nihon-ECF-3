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
        $model   = new ModelManga();
        $manga   = $model->getMangaById($id);
        $volumes = $model->getMangaVolumes($id);
        require_once './view/manga.php';
    }

    // Method to delete a manga entry by ID
    public function delete($id) {
        $model = new ModelManga();
        $model->deleteManga($id);
        header('Location: /');
    }

    public function search() {
        $search        = '%' . $_POST['search'] . '%';
        $model         = new ModelManga();
        $searchResults = $model->searchManga($search);
        header('Content-Type: application/json');
        echo json_encode($searchResults);

    }

    // Method to handle AJAX request for author search
    public function authorAJAX() {
        $search  = '%' . $_POST['author'] . '%';
        $model   = new ModelManga();
        $authors = $model->getMangaAuthor($search);
        header('Content-Type: application/json');
        echo json_encode($authors);

    }

    public function readAuthor($id) {
        $model  = new ModelManga();
        $author = $model->getAuthorById($id);
        require_once './view/author.php';
    }

    public function likeManga() {
        header('Content-Type: application/json');

        $data     = json_decode(file_get_contents("php://input"), true);
        $manga_id = $data['manga_id'] ?? null;

        if (! isset($_SESSION['id_user'])) {
            echo json_encode(['error' => 'Not logged in']);
            exit;
        }

        $id_user = $_SESSION['id_user'];

        if (! $manga_id) {
            echo json_encode(['error' => 'Invalid request']);
            exit;
        }
        $manga = new Manga(['id_manga' => $manga_id]);
        // Toggle like
        $liked      = $manga->toggleLike($id_user);
        $like_count = $manga->getLikesCount();
        echo json_encode([
            'liked'      => $liked,
            'like_count' => $like_count,
        ]);
    }

    public function getUserLikedMangas() {
        header('Content-Type: application/json');
        $data     = json_decode(file_get_contents("php://input"), true);
        $manga_id = $data['manga_id'] ?? null;
        // Instantiate Manga object
        $manga = new Manga(['id_manga' => $manga_id]);

        if (! isset($_SESSION['id_user'])) {
            echo json_encode(['liked_mangas' => []]);
            exit;
        }

        $likedMangas = $manga->isLikedByUser($_SESSION['id_user']);

        echo json_encode(['liked_mangas' => $likedMangas]);
    }

}