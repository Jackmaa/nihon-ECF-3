<?php
class ModelManga extends Model {
    public function getMangaListByCat() {
        $req    = $this->getDb()->query('SELECT * FROM category, manga WHERE category.name = "shonen" AND manga.thumbnail != ""');
        $data   = $req->fetchAll(PDO::FETCH_ASSOC);
        $mangas = [];
        foreach ($data as $manga) {
            $mangas[] = new Manga($manga);
        }
        return $mangas;
    }
}

/*foreach ($mangas as $manga):
    <div class="manga">
        <a href="#"><img src="<?php echo $manga->getThumbnail() ?>" alt="<?php echo $manga->getName() ?>"><?php echo $manga->getName() ?></a>
        <span class="heart"><img src="public\asset\img\heart.svg" alt="Heart"></span>
        <figure><img src="public\asset\img\star.svg" alt="">(300)</figure>
    </div>
endforeach; ?>*/