<?php
class MangaDTO implements JsonSerializable {
    public readonly Manga $manga;
    public readonly string $author;
    public readonly string $categories;
    public readonly string $editor;

    public function __construct(Manga $manga, string $author,  $categories, string $editor) {
        $this->manga = $manga;
        $this->author = $author;
        $this->categories = $categories;
        $this->editor = $editor;
    }
    
    public function jsonSerialize(): mixed {
        return [
            'manga'       => $this->manga,
            'author'      => $this->author,
            'categories'  => $this->categories,
            'editor'      => $this->editor
        ];
    }
}