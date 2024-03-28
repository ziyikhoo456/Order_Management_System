<?php
require('./config/constant.php');
session_start();

$status = ""; 

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['staffName'])) {
    header("Location: staff_login.php");
    exit();
}

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

if (isset($_POST['action']) && $_POST['action'] == 'create') {

    $prodName = mysqli_real_escape_string($conn, $_POST['prodName']);
    $prodStock = mysqli_real_escape_string($conn, $_POST['prodStock']);
    $prodPrice = mysqli_real_escape_string($conn, $_POST['prodPrice']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $staffID = $_SESSION['staffID'];
    $categoryID = mysqli_real_escape_string($conn, $_POST['categoryID']);  
    $uploadedFileName = "";

    if (isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $maxFileSize = 10 * 1024 * 1024; //10mb
        $uploadPath = 'img/product/';
        $fileType = $_FILES['imageFile']['type'];
        $fileSize = $_FILES['imageFile']['size'];
        $uploadedFileName = $_FILES['imageFile']['name']; 
    
        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
            //query to check whether file name exists in database
            $checkQuery = "SELECT COUNT(*) as count FROM product WHERE imageName = '$uploadedFileName'";
            $result1 = mysqli_query($conn, $checkQuery);
            $row = mysqli_fetch_assoc($result1);
    
            if ($row['count'] > 0) {
                //file name exists, rename 
                $status = "The image name $uploadedFileName already exists. Please rename the file before uploading again.";
                echo $status;
            } else {
                $targetFilePath = $uploadPath . $uploadedFileName; 
                if (!move_uploaded_file($_FILES['imageFile']['tmp_name'], $targetFilePath)) {
                    $status = "File upload failed, please try again.";
                    echo $status;
                }
            }
        } else {
           $status = "Invalid file type or size, please ensure the file is a JPEG, JPG or PNG and less than 10MB.";
           echo $status;
        }
    } 

    //if status message is empty only create, else no matter what error happen above also able to create
    if (empty($status)) {
        $insertQuery = "INSERT INTO product (prodName, prodStock, prodPrice, description, imageName, staffID, categoryID) 
                        VALUES ('$prodName', '$prodStock', '$prodPrice', '$description', '$uploadedFileName', '$staffID', '$categoryID')";
    
        if (mysqli_query($conn, $insertQuery)) {
            $status = "New product created successfully.";
        } else {
            $status = "Error creating product: " . mysqli_error($conn);
        }
    }
    $_SESSION['status'] = $status; 
    header("Location: create_product.php"); 
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
    <link rel="stylesheet" href="css/create.css" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Create Product</title>
    <link rel="icon" href="img/logo2.png" type="image/png">

</head>
<body>
    <div class="create-product-container">
        <h2 class="form-title">Create New Product</h2>
        <?php if ($status != ""): ?>
            <p class="status-message"><?php echo $status; ?></p>
        <?php endif; ?>
        <form action="" enctype="multipart/form-data" method="post" class="product-form">
            <input type="hidden" name="action" value="create">
            <div class="form-group">
                <label>Product Name:</label>
                <input type="text" name="prodName" required placeholder="Enter product name" oninput="clearStatusMessage()">
            </div>
            <div class="form-group">
                <label>Product Stock:</label>
                <input type="number" name="prodStock" required placeholder="Enter stock quantity" oninput="clearStatusMessage()">
            </div>
            <div class="form-group">
                <label>Product Price:</label>
                <input type="text" name="prodPrice" required placeholder="Enter price RM(xx.xx)" oninput="clearStatusMessage()">
            </div>
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" placeholder="Enter product description" oninput="clearStatusMessage()"></textarea>
            </div>
            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="imageFile" required>
            </div>
            <div class="form-group">
                <label>Category:</label>
                <select name="categoryID" required oninput="clearStatusMessage()">
                    <?php echo $categoryOptions; ?>
                </select>
            </div>
            <div class="form-actions">
            <div class="btn-group">
                <input type="submit" value="Create Product" class="button"><br>
                <a href="staffdashboard.php" class="button">Back to dashboard</a>
                <a href="logout.php" class="button">Logout</a>
            </div>
            </div>
        </form>
    </div>

    <script>
        function clearStatusMessage() { //clear the error message when staff input again
            var statusMessage = document.querySelector('.status-message');
            if (statusMessage) {
                statusMessage.textContent = '';
            }       
        }
    </script>
</body>
</html>