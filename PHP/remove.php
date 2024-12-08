<?php
require_once ('DBConnection.php');

$Wishlist = "SELECT wishlistID, customerID FROM Wishlist";
$WishlistItem = "SELECT wishlistID, wishlistItemID FROM WishlistItem";
$WishlistResult = $conn->query($Wishlist);
if (isset($_COOKIE["customerID"])) {
    $customerID = $_COOKIE["customerID"];
    if (mysqli_num_rows($WishlistResult) > 0) {
        while ($row = mysqli_fetch_assoc($WishlistResult)) {
            if ($row['customerID'] == $customerID) {
                $WishlistID = $row['wishlistID'];
                $WishlistItemResult = $conn->query($WishlistItem);
                if (mysqli_num_rows($WishlistItemResult) > 0) {
                    while ($row = mysqli_fetch_assoc($WishlistItemResult)) {
                        if ($row['WishlistID'] == $WishlistID) {
                            $sql = "DELETE FROM WhishListItem WHERE id=$row[WishlistItemID]";
                        }
                    }
                }
            }
        }
    }
}
mysqli_close($conn);
?>
