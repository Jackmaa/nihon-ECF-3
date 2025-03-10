<?php
class ModelBurrow extends Model {
    public function save($manga_id, $user_id, $borrow_date, $return_date) {
        $req = $this->getDb()->prepare("INSERT INTO borrows (manga_id, user_id, borrow_date, return_date) VALUES (?, ?, ?, ?)");
        return $req->execute([$manga_id, $user_id, $borrow_date, $return_date]);
    }

    public function userBorrowCount(int $user_id): int {
        $req = $this->getDb()->prepare("SELECT COUNT(*) FROM borrows WHERE user_id = ? AND return_date > NOW()");
        $req->execute([$user_id]);
        return (int) $req->fetchColumn();
    }

    public static function maxBooksAllowed(int $user_id): int {
        $user = new ModelUser();
        $user->getUser($user_id);
        return $user->isPremium($user_id) ? 5 : 3;
    }
}
