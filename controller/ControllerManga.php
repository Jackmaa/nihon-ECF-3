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

    // Méthode pour mettre à jour un manga
    public function update($id) {
        $model = new ModelManga();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (! isset($_FILES['thumbnail']) || $_FILES['thumbnail']['error'] !== UPLOAD_ERR_OK) {
                header('Location: /?upload=error');
                exit();
            }

            // Gérer l'upload et la conversion
            $thumbnailPath = $this->handleThumbnailUpload($_FILES['thumbnail'], "manga_$id");

            // Mettre à jour le manga en base de données
            if ($thumbnailPath) {
                $model->updateManga($id, $_POST['name'], $_POST['description'], $_POST['published_date'], $thumbnailPath);
            }

            header('Location: /?update=success');
            exit();
        }

        $data = $model->getManga($id);
        require_once './view/update.php';
    }

    // Méthode pour créer un manga
    public function create() {
        $model = new ModelManga();
        if ($_SESSION["admin_logged_in"] !== true) {
            echo "Bish you ain't no Kami, you just a NINGEN";
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $author = $model->getMangaAuthorByName($_POST['author']);
            if (! $author) {
                $model->createAuthor($_POST['author']);
                $author = $model->getMangaAuthorByName($_POST['author']);
            }

            $authorId       = $author['id_author'];
            $name           = $_POST['name'];
            $description    = $_POST['description'];
            $published_date = $_POST['published_date'];

            // Vérifier et gérer l'upload de la couverture
            if (! isset($_FILES['thumbnail']) || $_FILES['thumbnail']['error'] !== UPLOAD_ERR_OK) {
                echo "Erreur d'upload de la couverture.";
                exit();
            }

            $thumbnailPath = $this->handleThumbnailUpload($_FILES['thumbnail'], "manga_" . uniqid());

            if ($thumbnailPath) {
                $model->createManga($name, $authorId, $description, $published_date, $thumbnailPath);
                $id_manga = $model->getMangaByName($name);

                $model->addEditor($id_manga, $_POST["editor"]);
                $model->addVolumes($id_manga, $_POST["volumes"]);

                // Ajouter les catégories (max 3)
                if (isset($_POST["category"]) && is_array($_POST["category"])) {
                    $selectedCategories = array_slice($_POST["category"], 0, 3);
                    foreach ($selectedCategories as $categoryId) {
                        $model->addCategory($id_manga, $categoryId);
                    }
                } else {
                    echo "Veuillez sélectionner au moins une catégorie.";
                    exit();
                }

                $_SESSION["message"] = 'Manga créé avec succès.';
                header("Location: " . $this->router->generate("admin_dashboard"));
                exit();
            } else {
                echo "Erreur lors du traitement de l'image.";
                exit();
            }
        }
    }

    // Fonction de gestion des uploads
    private function handleThumbnailUpload($file, $fileName) {
        $targetDir     = "public/asset/img/";
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedTypes  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (! in_array($fileExtension, $allowedTypes)) {
            return false;
        }

        // Définir le chemin temporaire et final
        $tempFilePath  = $targetDir . $fileName . "." . $fileExtension;
        $finalFilePath = $targetDir . $fileName . ".webp";

        // Déplacer le fichier temporaire
        if (! move_uploaded_file($file['tmp_name'], $tempFilePath)) {
            return false;
        }

        // Convertir et redimensionner l'image
        if (ImageProcessor::processImage($tempFilePath, $finalFilePath, 200, 300)) {
            unlink($tempFilePath); // Supprimer l'original
            return $finalFilePath;
        }

        return false;
    }

    // Method to read a manga entry by ID
    public function read($id) {
        $model      = new ModelManga();
        $manga      = $model->getMangaById($id);
        $volumes    = $model->getMangaVolumes($id);
        $review     = $model->mangaReview($id);
        $also_liked = $model->getAlsoLiked($id);
        $revAdd     = null;
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
    // Method to search Mangas for the search bar
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
    // Method to display the page of an author
    public function readAuthor($id) {
        $model  = new ModelManga();
        $author = $model->getAuthorById($id);
        require_once './view/author.php';
    }

    //Methode to like a Manga (I worked hard at it for it to suck)
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

    //Method to Change the display of the heart icon
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

    //Method to display the Category page
    public function readCategory($category_name) {
        $model    = new ModelManga();
        $category = $model->getCategoryDatas($category_name);
        $mangas   = $model->getCategoryMangas($category->getId_category());
        require_once './view/category.php';
    }

    //Method to add a review to a manga
    public function addRev() {
        $model = new ModelManga();
        $model->addReview($_POST['review'], $_POST['id_manga'], $_SESSION['id_user']); //TELL ME SI C'EST BON
        $id = $_POST['id_manga'];
        header("Location:" . $this->router->generate("read", ["id" => $id]));
        exit;
    }

    public function addVolume() {
        header('Content-Type: application/json'); // Ensure JSON response
        $data = json_decode(file_get_contents("php://input"), true);

        if (! $data || ! isset($data['id_manga']) || ! isset($data['id_volume'])) {
            echo json_encode([
                "success" => false,
                "message" => "Invalid input data.",
            ]);
            return;
        }

        $model = new ModelManga();
        if ($model->addVolume($data['id_manga'], $data['id_volume'])) {
            echo json_encode([
                "success" => true,
                "message" => "Volume added successfully.",
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Failed to add volume.",
            ]);
        }
    }
    public function deleteVolume() {
        $data = json_decode(file_get_contents("php://input"), true);

        $model = new ModelManga();
        if ($model->deleteVolume($data['id_manga'], $data['id_volume'])) {
            json_encode([
                "success" => true,
                "message" => "Volume deleted successfully."]);

        } else {
            json_encode([
                "success" => false,
                "message" => "Failed to delete volume.",
            ]);
        }
    }

    public function getVolumes($id) {
        $model   = new ModelManga();
        $volumes = $model->getMangaVolumes($id);
        header('Content-Type: application/json');
        echo json_encode($volumes);
    }

}