<?php
class ControllerManga extends Controller {

    public function __construct(AltoRouter $router) {
        parent::__construct($router);
    }

    // Method to display the home page
    public function home() {
        $model           = new ModelManga();
        $recommendations = $model->getMangaRecommendation();
        $categories      = $model->getCategories();
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
        if ($_SESSION["admin_logged_in"] === true) {
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
                $id_manga = $model->getMangaByName($name);
                $editor   = $_POST["editor"];
                $model->addEditor($id_manga, $editor);
                // Handle multiple categories (min 1, max 3)
                if (isset($_POST["category"]) && is_array($_POST["category"])) {
                    $selectedCategories = array_slice($_POST["category"], 0, 3); // Limit to 3 categories
                    foreach ($selectedCategories as $categoryId) {
                        $model->addCategory($id_manga, $categoryId);
                    }
                } else {
                    echo "Please select at least one category.";
                    exit;
                }
                $_SESSION["message"] = 'Manga created successfully.';
                header("location:" . $this->router->generate("admin_dashboard"));
            }
        } else {
            echo "Bish you ain't no Kami, you just a NINGEN";
        }
    }

    // Method to read a manga entry by ID
    public function read($id) {
        $model   = new ModelManga();
        $manga   = $model->getMangaById($id);
        $volumes = $model->getMangaVolumes($id);
        $review  = $model->mangaReview($id);
        $revAdd  = null;
        if (isset($_POST['review']) && isset($_POST['id_manga'])) {
            $revAdd = $model->addReview($_POST['review'], $_POST['id_manga'], $_SESSION['id_user']);
        }
        require_once './view/manga.php';
    }

    // Method to delete a manga entry by ID
    public function delete($id) {
        if ($_SESSION["admin_logged_in"] === true) {
            $model = new ModelManga();

            if ($model->deleteManga($id)) {
                echo json_encode(["success" => true, "message" => "Manga deleted successfully."]);
            } else {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Failed to delete manga."]);
            }
        } else {
            http_response_code(403);
            echo json_encode(["success" => false, "message" => "Sheh."]);
        }
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

    // public function readCategory($id){
    //     $model = new ModelManga();
    //     $category = $model->getCategoryDatas($id);
    //     $mangas = $model->getCategoryMangas($id);
    //     require_once './view/category.php';
    // }

    public function readCategory($category_name) {
        $model    = new ModelManga();
        $category = $model->getCategoryDatas($category_name);
        $mangas   = $model->getCategoryMangas($category->getId_category());
        require_once './view/category.php';
    }

    public function addRev() {
        $model = new ModelManga();
        $model->addReview($_POST['review'], $_POST['id_manga'], $_SESSION['id_user']); //TELL ME SI C'EST BON
        header('Location: /manga/' . $_POST['id_manga']);
    }
}