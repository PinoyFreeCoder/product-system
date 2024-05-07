<?php

error_reporting(E_ALL);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function connect()
{

    $host = '';
    $dbname = '';
    $username = '';
    $password = '';

    try {

        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function insertProduct($productName, $productDescription, $LogInUser)
{
    try {

        $pdo = connect();


        $sqlSetTimezone = "SET time_zone = '+08:00'";
        $pdo->exec($sqlSetTimezone);

        $stmt = $pdo->prepare("INSERT INTO products (product_name, product_description, added_by, createdAt) VALUES (:productName, :productDescription, :addedBy, NOW())");

        $stmt->bindParam(':productName', $productName);
        $stmt->bindParam(':productDescription', $productDescription);
        $stmt->bindParam(':addedBy', $LogInUser['email']);
        $stmt->execute();

        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        echo "Insertion failed: " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}

function deleteProduct($productId)
{
    try {
        $pdo = connect();

        $stmt = $pdo->prepare("DELETE FROM products WHERE ID = :productId");
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();

        echo "Product deleted successfully!";
    } catch (PDOException $e) {
        echo "Deletion failed: " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}

function editProduct($productId, $newProductName, $newDescription, $LogInUser)
{
    try {
        $pdo = connect();

        $sqlSetTimezone = "SET time_zone = '+08:00'";
        $pdo->exec($sqlSetTimezone);


        $stmt = $pdo->prepare("UPDATE products SET product_name = :newProductName, product_description = :newDescription, updated_by = :updatedBy, updatedAt = NOW() WHERE ID = :productId");

        $stmt->bindParam(':newProductName', $newProductName);
        $stmt->bindParam(':newDescription', $newDescription);
        $stmt->bindParam(':updatedBy', $LogInUser['email']);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();

        echo "Product edited successfully!";
    } catch (PDOException $e) {
        echo "Edit failed: " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}

function updateImageData($productId, $imageName)
{
    try {
        $pdo = connect();
        $stmt = $pdo->prepare("UPDATE products SET product_image = :imageName WHERE ID = :productId");

        $stmt->bindParam(':imageName', $imageName);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();

        echo "Product image was updated successfully!";
    } catch (PDOException $e) {
        echo "Edit failed: " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}

function totalProducts($searchTerm = "")
{
    try {
        $pdo = connect();

        if (!empty($searchTerm)) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE product_name LIKE :searchTerm");
            $stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
        } else {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM products");
        }

        $stmt->execute();

        $totalItems = $stmt->fetchColumn();
        return $totalItems;
    } catch (PDOException $e) {
        echo "Selection failed : " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}

function getAllProducts($currentPage, $itemsPerPage, $searchTerm = "")
{
    try {
        $pdo = connect();

        $offset = ($currentPage - 1) * $itemsPerPage;

        if (!empty($searchTerm)) {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE product_name LIKE :searchTerm LIMIT :offset, :itemsPerPage");
            $stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
        } else {
            $stmt = $pdo->prepare("SELECT * FROM products LIMIT :offset, :itemsPerPage");
        }


        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    } catch (PDOException $e) {
        echo "Selection failed : " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}

function generatePageLinks($totalPages, $currentPage, $searchTerm = "")
{
    if ($totalPages > 1) {
        $links = "";

        if ($currentPage > 1) {
            $prevPageLink = ($searchTerm !== "") ? "?page=" . ($currentPage - 1) . "&search=$searchTerm" : "?page=" . ($currentPage - 1);

            $links .= "<li class='page-item'><a href='$prevPageLink' class='page-link'> &laquo;  Previous </a></li>";
        }

        for ($page = 1; $page <= $totalPages; $page++) {
            $activeClass = ($page == $currentPage) ? 'active' : '';

            $pageLink = ($searchTerm !== "") ? "?page=$page&search=$searchTerm" : "?page=$page";

            $links .= "<li class='page-item'><a href='$pageLink' class='$activeClass page-link'>$page</a></li>";
        }

        if ($currentPage < $totalPages) {

            $nextPageLink = ($searchTerm !== "") ? "?page=" . ($currentPage + 1) . "&search=$searchTerm" : "?page=" . ($currentPage + 1);

            $links .= "<li class='page-item'><a href='$nextPageLink' class='page-link'>Next &raquo;</a></li>";
        }

        return $links;
    }
}

function getProductById($productId)
{
    try {
        $pdo = connect();

        $stmt = $pdo->prepare("SELECT * FROM products WHERE ID = :productId");
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product;
    } catch (PDOException $e) {
        echo "Selection failed : " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}

function uploadImage($fileInputName, $uploadDirectory, $newFilename)
{
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {

        $tempFile = $_FILES[$fileInputName]['tmp_name'];
        $originalFileName = $_FILES[$fileInputName]['name'];

        //validate file type
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $tempFile);
        finfo_close($fileInfo);

        $allowedType = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($mimeType, $allowedType)) {
            return "Error : Invalid file type. Only JPG, PNG, and GIF images are allowed.";
        }

        //Rename the uploaded file
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $newFileNameWithExtension = $newFilename . '.' . $fileExtension;
        $destination = $uploadDirectory . '/' . $newFileNameWithExtension;

        if (!move_uploaded_file($tempFile, $destination)) {
            return "Failed";
        } else {
            return $newFileNameWithExtension;
        }
    } else {
        return "Failed";
    }
}


function register($email, $password)
{
    try {
        $pdo = connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return "User already exists!";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUE (:email, :password)");
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->execute();
        return "success";
    } catch (PDOException $e) {
        echo "Register failed : " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}

function login($email, $password)
{
    try {
        $pdo = connect();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            //verify password
            if (password_verify($password, $row['password'])) {
                return $row;
            } else {
                return "Invalid credentials";
            }
        } else {
            return "User not found!";
        }
    } catch (PDOException $e) {
        echo "Login failed : " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}

function getUserById($userId)
{
    try {
        $pdo = connect();

        $stmt = $pdo->prepare("SELECT * FROM users WHERE ID = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    } catch (PDOException $e) {
        echo "Selection failed : " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}

function updateUserInfo($userId, $firstname, $lastname)
{
    try {
        $pdo = connect();
        $stmt = $pdo->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname  WHERE ID = :userId");
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return "success";
    } catch (PDOException $e) {
        echo "Update failed : " . $e->getMessage();
    } finally {
        $pdo = null;
    }
}
