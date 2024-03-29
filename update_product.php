<?php
require('./config/constant.php');
session_start();

$status = ""; 

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['staffName'])) {
    header("Location: staff_login.php");
    exit();
}

$query = "SELECT p.*, c.catName FROM product p INNER JOIN category c ON p.categoryID = c.categoryID";
$products = mysqli_query($conn, $query);

$categoryOptions = "";
$catsql = "SELECT categoryID, catName FROM category ORDER BY catName ASC";
$result = mysqli_query($conn, $catsql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categoryOptions .= "<option value='" . $row['categoryID'] . "'>" . htmlspecialchars($row['catName']) . "</option>";
    }
} else {
    $categoryOptions = "<option value=''>No such category found!</option>";
}

//similar approach as create_product
if (isset($_POST['update'])) {

    $productID = mysqli_real_escape_string($conn, $_POST['prodID']);
    $prodName = mysqli_real_escape_string($conn, $_POST['prodName']);
    $prodStock = mysqli_real_escape_string($conn, $_POST['prodStock']);
    $prodPrice = mysqli_real_escape_string($conn, $_POST['prodPrice']);
    $shortDesc = mysqli_real_escape_string($conn, $_POST['shortDesc']);
    $longDesc = mysqli_real_escape_string($conn, $_POST['longDesc']);
    $categoryID = mysqli_real_escape_string($conn, $_POST['categoryID']);
    $imageName = ""; 


    if (isset($_FILES['newImageFile']) && $_FILES['newImageFile']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $maxFileSize = 10 * 1024 * 1024;
        $uploadPath = 'img/product/';
        $fileType = $_FILES['newImageFile']['type'];
        $fileSize = $_FILES['newImageFile']['size'];
        $newUploadedFileName = $_FILES['newImageFile']['name'];

        //unlinking old image, when uploaded new image
        $oldimageQuery = "SELECT imageName FROM product WHERE prodID = '$productID'";
        $oldimageResult = mysqli_query($conn, $oldimageQuery);
        $currentImageName = "";
        if ($oldimageNameRow = mysqli_fetch_assoc($oldimageResult)) {
            $currentImageName = $oldimageNameRow['imageName'];
        }
        $currentImagePath = $uploadPath . $currentImageName;
        
        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
            $checkQuery = "SELECT COUNT(*) as count FROM product WHERE imageName = '$newUploadedFileName'";
            $result2 = mysqli_query($conn, $checkQuery);
            $row = mysqli_fetch_assoc($result2);

            if ($row['count'] > 0) {
                $status = "The image name $newUploadedFileName already exists. Please rename the file before uploading again.";
                echo $status;
            } else {
                $targetFilePath = $uploadPath . $newUploadedFileName;
                if (move_uploaded_file($_FILES['newImageFile']['tmp_name'], $targetFilePath)) {
                    
                    if ($currentImageName && $currentImageName != $newUploadedFileName && file_exists($currentImagePath)) {
                        unlink($currentImagePath);
                    } //unlink the old image if new image is uploaded

                    $imageName = $newUploadedFileName; //if file name different
                } else {
                    $status = "File upload failed, please try again.";
                    echo $status;
                }
            }
        } 
        else {
            $status = "Invalid file type or size, please ensure the file is a JPEG, JPG or PNG and less than 10MB.";
            echo $status;
        }
    }
    else {
        $imageNameQuery = "SELECT imageName FROM product WHERE prodID = '$productID'";
        $imageNameResult = mysqli_query($conn, $imageNameQuery);
        if($imageNameRow = mysqli_fetch_assoc($imageNameResult)){
            $imageName = $imageNameRow['imageName'];
        }
    }

    $currentProductQuery = "SELECT prodName, prodStock, prodPrice, shortDesc, longDesc, imageName, categoryID FROM product WHERE prodID = '$productID'";
    $currentProductResult = mysqli_query($conn, $currentProductQuery);

    $changesMade = false;

    if ($currentProductRow = mysqli_fetch_assoc($currentProductResult)) {
    
        if ($currentProductRow['prodName'] !== $prodName ||
            $currentProductRow['prodStock'] !== $prodStock ||
            $currentProductRow['prodPrice'] !== $prodPrice ||
            $currentProductRow['shortDesc'] !== $shortDesc ||
            $currentProductRow['longDesc'] !== $longDesc ||
            $currentProductRow['imageName'] !== $imageName ||
            $currentProductRow['categoryID'] !== $categoryID) {
            $changesMade = true;
        }
    }

    if (empty($status) && $changesMade) {
        // Update product in database
        $updateQuery = "UPDATE product 
                        SET prodName = '$prodName', prodStock = '$prodStock', prodPrice = '$prodPrice', shortDesc = '$shortDesc', longDesc = '$longDesc' , imageName = '$imageName', categoryID = '$categoryID' 
                        WHERE prodID = '$productID'";

        if (mysqli_query($conn, $updateQuery)) {
            $status = "Product updated successfully.";
            echo $status;
        } else {
            $status = "Error updating product: " . mysqli_error($conn);
        }
    } else {
        $status = "No changes are made";
    }
    $_SESSION['status'] = $status;
    header("Location: update_product.php");
    exit();
}

if (isset($_SESSION['status'])) {
    $status = $_SESSION['status'];
    unset($_SESSION['status']);
} else {
    $status = "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/update.css" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Update Products</title>
    <link rel="icon" href="img/logo2.png" type="image/png">
</head>
<body>
    <div class="update-product-container">
        <h2>Update Product</h2>
        <?php if ($status != ""): ?>
            <p class="status-message"><?php echo $status; ?></p>
        <?php endif; ?>
        <table>
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Product Stock</th>
            <th>Product Price</th>
            <th>Short Description</th>
            <th>Long Description</th>
            <th>Image Name</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while($product = mysqli_fetch_assoc($products)): ?> <!-- fetching product row from product table  -->
            <tr>
                <form method="post" enctype="multipart/form-data">
                    <td><input type="text" name="prodName" value="<?php echo htmlspecialchars($product['prodName']); ?>"></td>
                    <td><input type="number" name="prodStock" value="<?php echo $product['prodStock']; ?>"></td>
                    <td><input type="number" name="prodPrice" value="<?php echo $product['prodPrice']; ?>"></td>
                    <td><textarea name="shortDesc"><?php echo htmlspecialchars($product['shortDesc']); ?></textarea></td>
                    <td><textarea name="longDesc"><?php echo htmlspecialchars($product['longDesc']); ?></textarea></td>
                    <td>
                        <div class="file-input-container">
                            <label for="file-upload"><?php echo htmlspecialchars($product['imageName']); ?></label>
                            <input type="file" name="newImageFile">
                        </div>
                    </td>
                    <td>
                        <select name="categoryID"> <!-- instead of showing categoryID, show the category name -->
                            <?php echo str_replace("value='" . $product['categoryID'] . "'", "value='" . $product['categoryID'] . "' selected", $categoryOptions); ?>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="prodID" value="<?php echo $product['prodID']; ?>">
                        <input type="submit" name="update" value="Update">
                    </td>
                </form>
            </tr>
         <?php endwhile; ?> <!-- flag to end the while loop, if not infinite looping  -->
        </tbody>
        </table>
        <div class="btn-container">
            <a href="staffdashboard.php" class="button">Back to dashboard</a>
            <a href="logout.php" class="button">Logout</a>
        </div>
    </div>
</body>
</html>