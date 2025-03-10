<?php
class Cart {
    // Adds an item to the cart
    public static function addToCart(array $id_res): array {
        // Initialize the cart session if it doesn't exist
        if (! isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Validate the input data
        if (
            count($id_res) === 2 &&   // Ensure the array has exactly 2 elements
            is_numeric($id_res[0]) && // Ensure the first element is numeric (manga ID)
            is_numeric($id_res[1])    // Ensure the second element is numeric (volume ID)
        ) {
            // Cast the IDs to integers
            $id_manga  = (int) $id_res[0];
            $id_volume = (int) $id_res[1];

            // Check if the item is already in the cart
            if (! in_array([$id_manga, $id_volume], $_SESSION['cart'])) {
                // Add the item to the cart
                $_SESSION['cart'][] = [$id_manga, $id_volume];
            }
        } else {
            // Throw an exception if the input data is invalid
            throw new InvalidArgumentException("Invalid cart entry. Expected an array with two numeric values.");
        }

        // Return the updated cart
        return $_SESSION['cart'];
    }

    // Removes an item from the cart
    public static function removeFromCart(array $id_res): array {
        // Check if the cart exists in the session
        if (isset($_SESSION['cart'])) {
            // Filter out the item to be removed and reindex the array
            $_SESSION['cart'] = array_values(array_filter($_SESSION['cart'], fn($item) => $item !== $id_res));
        }

        // Return the updated cart
        return $_SESSION['cart'];
    }

    // Clears the entire cart
    public static function clearCart(): void {
        $_SESSION['cart'] = [];
    }

    // Retrieves the current cart
    public static function getCart(): array {
        // Return the cart if it exists, otherwise return an empty array
        return $_SESSION['cart'] ?? [];
    }
}