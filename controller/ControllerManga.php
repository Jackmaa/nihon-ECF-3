<?php
class ControllerManga extends Controller{

public function __construct(AltoRouter $router) {
    parent::__construct($router);
}

    public function home() {
        $model  = new ModelManga();
        $mangas = $model->getMangaListByCat();
        require_once './view/home.php';
    }

    public function update($id){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){       
                $model = new ModelManga();
                var_dump($_FILES);

                $thumbnail      = $_FILES['thumbnail']['name'];
                $tmp_thumbnail  = $_FILES['thumbnail']['tmp_name'];
                move_uploaded_file($tmp_thumbnail, './public/asset/img/' . $thumbnail);
                $thumbnail = './public/asset/img/' . $thumbnail;

                $model->updateManga($_POST['id'], $_POST['name'], $_POST['description'], $_POST['published_date'], $thumbnail);
                var_dump($_POST);


                header('Location: /');

        } else {
            $get = new ModelManga();
            $data = $get->getManga($id);
            require_once('./view/update.php');
        }
    }
}