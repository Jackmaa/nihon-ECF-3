<?php
class ModelBorrow extends Model {
    public function save($id_manga, $id_volume, $id_user) {
        $req = $this->getDb()->prepare("INSERT INTO borrow (id_manga, id_user, id_volume, borrow_date, return_date)
                                        VALUES (:id_manga, :id_user, :id_volume, :borrow_date, :return_date)");
        $req->bindParam(':id_manga', $id_manga, PDO::PARAM_INT);
        $req->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $req->bindParam(':id_volume', $id_volume, PDO::PARAM_INT);
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

    public function isAvailable(int $id_manga, int $id_volume) {
        $req = $this->getDb()->prepare(
            'SELECT COUNT(`id_volume`) AS "Borrowed"
            FROM `borrow`
            WHERE `id_manga`= :id_manga AND `id_volume` = :id_volume');
        $req->bindParam(":id_manga", $id_manga, PDO::PARAM_INT);
        $req->bindParam(":id_volume", $id_volume, PDO::PARAM_INT);
        $req->execute();
        return $result = $req->fetchColumn();
    }
}
