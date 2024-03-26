<?php
require('./config/constant.php');
session_start();

$status = ""; 

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['staffName'])) {
    header("Location: staff-login.php");
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
    <title>Create Product</title>
</head>
<body>
    <h2>Create New Product</h2>
    <form action="" enctype="multipart/form-data" method="post">
        <input type="hidden" name="action" value="create">
        Product Name: <input type="text" name="prodName" required><br>
        Product Stock: <input type="number" name="prodStock" required><br>
        Product Price: <input type="text" name="prodPrice" required><br>
        Description: <textarea name="description"></textarea><br>
        Image: <input type="file" name="imageFile" required><br>
        Category: <select name="categoryID" required>
        <?php echo $categoryOptions; ?></select><br>
        <input type="submit" value="Create Product" ><br>
        <a href="staffdashboard.php">Back to dashboard</a>
        <a href="logout.php">Logout</a>
    </form>
</body>
</html>

<?php if ($status != ""): ?>
    <p><?php echo $status; ?></p>
<?php endif; ?>