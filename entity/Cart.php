<?php
class Cart {
    public static function addToCart(array $id_res): array {
        if (! isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Ensure `$id_res` is an array with exactly two integers
        if (
            count($id_res) === 2 &&
            is_int($id_res[0]) &&
            is_int($id_res[1])
        ) {
            // Check if the item is already in the cart
            $exists = array_filter($_SESSION['cart'], fn($item) => $item === $id_res);

            if (empty($exists)) {
                $_SESSION['cart'][] = $id_res;
            }
        } else {
            throw new InvalidArgumentException("Invalid cart entry. Expected an array with two integers.");
        }

        return $_SESSION['cart'];
    }

    public static function removeFromCart(array $id_res): array {
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item !== $id_res);
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
