<?php
class Borrow {
    private int $id;
    private int $manga_id;
    private int $user_id;
    private string $borrow_date;
    private ?string $return_date;

    public function __construct(int $manga_id, int $user_id, bool $extra_week = false) {
        $this->manga_id    = $manga_id;
        $this->user_id     = $user_id;
        $this->borrow_date = date('Y-m-d');
        $borrow_duration   = $extra_week ? 3 : 2;

        $this->return_date = date('Y-m-d', strtotime("+$borrow_duration weeks"));
    }
}
