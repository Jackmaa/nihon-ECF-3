<?php
class ModelBurrow extends Model {
    public function save($id_manga, $id_user, $borrow_date, $return_date) {
        $req = $this->getDb()->prepare("INSERT INTO borrow (id_manga, id_user, borrow_date, return_date)
                                        VALUES (:id_manga, :id_user, :borrow_date, :return_date)");
        $req->bindParam(':id_manga', $id_manga, PDO::PARAM_INT);
        $req->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $req->bindParam(':borrow_date', $borrow_date, PDO::PARAM_STR);
        $req->bindParam(':return_date', $return_date, PDO::PARAM_STR);
    }

    public function userBorrowCount(int $id_user): int {
        $req = $this->getDb()->prepare("SELECT COUNT(*) FROM borrow WHERE id_user = ? AND return_date > NOW()");
        $req->execute([$id_user]);
        return (int) $req->fetchColumn();
    }

    public function maxBooksAllowed(int $id_user): int {
        $user = new ModelUser();
        $user->getUser($id_user);
        return $user->isPremium($id_user) ? 5 : 3;
    }

    public function getMangaId(int $id_manga) {
        $req = $this->getDb()->prepare(
            'SELECT
                `id_manga`,
                `name`,
                `id_author`,
                `description`,
                `published_date`,
                `thumbnail`
            FROM
                `manga`
            WHERE
                id_manga = :id');
        $req->bindParam('id', $id_manga, PDO::PARAM_INT);
        $req->execute();

        $result = $req->fetch(PDO::FETCH_ASSOC);

        return $result ? new Manga($result) : null;
    }
}
