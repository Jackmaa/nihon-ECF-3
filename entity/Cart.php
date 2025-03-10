<?php
class Cart {
    public static function addToCart(array $id_res): array {
        if (! isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Validation des données
        if (
            count($id_res) === 2 &&
            is_numeric($id_res[0]) &&
            is_numeric($id_res[1])
        ) {
            $id_manga  = (int) $id_res[0];
            $id_volume = (int) $id_res[1];

            // Vérifier si l'élément est déjà dans le panier
            if (! in_array([$id_manga, $id_volume], $_SESSION['cart'])) {
                $_SESSION['cart'][] = [$id_manga, $id_volume];
            }
        } else {
            throw new InvalidArgumentException("Invalid cart entry. Expected an array with two numeric values.");
        }

        return $_SESSION['cart'];
    }

    public static function removeFromCart(array $id_res): array {
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_values(array_filter($_SESSION['cart'], fn($item) => $item !== $id_res));
        }

        return $_SESSION['cart'];
    }

    public static function clearCart(): void {
        $_SESSION['cart'] = [];
    }

    public static function getCart(): array {
        return $_SESSION['cart'] ?? [];
    }
}
