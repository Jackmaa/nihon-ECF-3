<?php
class ModelBorrow extends Model {
    // Save a borrow record
    public function save($id_manga, $id_volume, $id_user) {
        $req = $this->getDb()->prepare(
            "INSERT INTO borrow (id_manga, id_user, id_volume, borrow_date, return_date)
             VALUES (:id_manga, :id_user, :id_volume, NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY))"
        );
        $req->bindParam(':id_manga', $id_manga, PDO::PARAM_INT);
        $req->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $req->bindParam(':id_volume', $id_volume, PDO::PARAM_INT);
        $req->execute();
    }

    // Get the number of books currently borrowed by a user
    public function userBorrowCount(int $id_user): int {
        $req = $this->getDb()->prepare(
            "SELECT COUNT(*) FROM borrow WHERE id_user = ? AND return_date > NOW()"
        );
        $req->execute([$id_user]);
        return (int) $req->fetchColumn();
    }

    // Get the maximum number of books a user can borrow
    public function maxBooksAllowed(int $id_user): int {
        $user = new ModelUser();
        $user->getUser($id_user);
        return $user->isPremium($id_user) ? 5 : 3; // Premium users can borrow 5 books, others 3
    }

    // Get manga details by ID
    public function getMangaId(int $id_manga) {
        $req = $this->getDb()->prepare(
            "SELECT id_manga, name, id_author, description, published_date, thumbnail
             FROM manga WHERE id_manga = :id"
        );
        $req->bindParam(':id', $id_manga, PDO::PARAM_INT);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);

        return $result ? new Manga($result) : null;
    }

    // Check if a manga volume is available for borrowing
    public function isAvailable(int $id_manga, int $id_volume): bool {
        $req = $this->getDb()->prepare(
            "SELECT COUNT(id_volume) AS Borrowed
             FROM borrow
             WHERE id_manga = :id_manga AND id_volume = :id_volume"
        );
        $req->bindParam(":id_manga", $id_manga, PDO::PARAM_INT);
        $req->bindParam(":id_volume", $id_volume, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchColumn() == 0; // Available if count is 0
    }

    // Add a reservation to the reservation table
    public function addToReservationTable(int $id_user, int $id_manga, int $id_volume) {
        $req = $this->getDb()->prepare(
            "INSERT INTO reservation (id_user, id_manga, id_volume, placed, exp_date)
             VALUES (:id_user, :id_manga, :id_volume, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 DAY))"
        );
        $req->bindParam(":id_user", $id_user, PDO::PARAM_INT);
        $req->bindParam(":id_manga", $id_manga, PDO::PARAM_INT);
        $req->bindParam(":id_volume", $id_volume, PDO::PARAM_INT);
        $req->execute();
    }

    public function removeFromReservationTable(int $id_user, int $id_manga, int $id_volume) {
        $req = $this->getDb()->prepare(
            "DELETE FROM reservation
             WHERE id_user = :id_user AND id_manga = :id_manga AND id_volume = :id_volume"
        );
        $req->bindParam(":id_user", $id_user, PDO::PARAM_INT);
        $req->bindParam(":id_manga", $id_manga, PDO::PARAM_INT);
        $req->bindParam(":id_volume", $id_volume, PDO::PARAM_INT);
        $req->execute();
    }
}