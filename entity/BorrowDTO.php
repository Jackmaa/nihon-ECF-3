<?php

class BorrowDTO{
    public readonly Borrow $borrow;
    public readonly MangaDTO $manga;

    public function __construct(Borrow $borrow, MangaDTO $manga) {
        $this->borrow = $borrow;
        $this->manga = $manga;
    }

}