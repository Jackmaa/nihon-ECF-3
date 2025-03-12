<?php
class ModelBorrow extends Model {
    // Save a borrow record
    public function save($id_manga, $id_volume, $id_user) {
        $req = $this->getDb()->prepare(
            "INSERT INTO borrow (id_user,id_manga, id_volume, borrow_date, return_date)
             VALUES ( :id_user, :id_manga, :id_volume, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 21 DAY))"
        );
        $req->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $req->bindParam(':id_manga', $id_manga, PDO::PARAM_INT);
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

    public function clearCart(int $id_user) {
        $req = $this->getDb()->prepare(
            "DELETE FROM reservation
             WHERE id_user = :id_user");
        $req->bindParam(":id_user", $id_user, PDO::PARAM_INT);
        $req->execute();
    }

    public function getBorrowedBooks() {
        $req = $this->getDb()->prepare(
            'SELECT id_borrow, id_user, id_manga, id_volume, borrow_date, return_date, `status`
            FROM borrow
            LIMIT 3');
        $req->execute();
        $results = $req->fetchAll(PDO::FETCH_ASSOC);
        $borrows = [];
        foreach ($results as $borrow) {
            $borrows[] = new Borrow($borrow);
        }

        return $borrows;
    }

    public function getStatusEnum() {
        // Execute a query to get the column information for the 'status' field in the 'borrow' table
        $req = $this->getDb()->query("SHOW COLUMNS FROM borrow WHERE Field = 'status'");

        // Fetch the result as an associative array
        $row = $req->fetch(PDO::FETCH_ASSOC);

        // Initialize an empty array to store the ENUM values
        $enumValues = [];

        // Check if the 'Type' field matches the pattern of an ENUM definition (e.g., enum('value1','value2',...))
        if (preg_match("/^enum\((.*)\)$/", $row['Type'], $matches)) {
            // Extract the ENUM values and store them as an array
            // str_getcsv() properly handles the extraction by splitting values at commas and removing surrounding quotes
            $enumValues = str_getcsv($matches[1], ",", "'");
        }

        // Return the extracted ENUM values as an array
        return $enumValues;
    }

    public function updateStatus(int $id_borrow, string $status) {
        $req = $this->getDb()->prepare("UPDATE borrows SET status = :status WHERE id_borrow = :id_borrow");
        $req->bindParam(":id_borrow", $id_borrow, PDO::PARAM_INT);
        $req->bindParam(":status", $status);
        if ($req->execute()) {
            return true;
        } else {
            return false;
        }
    }
}