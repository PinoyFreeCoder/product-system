<?php
error_reporting(E_ALL);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('./function.php');
$id = $_GET['ID'];
if (isset($id)) {
    $product = getProductById($id);
}

if (isset($_POST['delete'])) {
    deleteProduct($_POST['ID']);
    header("location: ./");
}

?>
<?php include_once('templates/header.php'); ?>
<div class="container">
    <?php if ($product) : ?>
        <h1 class="mt-5"><?= $product['product_name']; ?></h1>
        <div class="mt-2">

            <?php if (isset($_SESSION['LoginUser'])) : ?>
                <form method="POST">
                    <div class="btn-group my-4">
                        <a href="editProduct.php?ID=<?= $product['ID']; ?>" class="btn btn-primary">Edit Product</a>
                        <button type="submit" name="delete" class="btn btn-danger">Delete Product</button>
                        <input type="hidden" name="ID" value="<?= $product['ID']; ?>">
                    </div>
                </form>
            <?php endif; ?>



            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Description</th>
                        <td><?= $product['product_description']; ?></td>
                    </tr>
                    <tr>
                        <th>Added By</th>
                        <td><?= $product['added_by']; ?></td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td><?= $product['createdAt']; ?></td>
                    </tr>
                    <tr>
                        <th>Updated By</th>
                        <td><?= $product['updated_by']; ?></td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td><?= $product['updatedAt']; ?></td>
                    </tr>
                    <tr>
                        <th align="center">Product Image</th>
                        <td> <img src="<?= $product['product_image'] != "" ? 'uploads/' . $product['product_image'] : 'assets/default.png'  ?>" alt="<?= $product['product_name']; ?>" /> </td>
                    </tr>
                </thead>

            </table>
        </div>
    <?php else : ?>
        <h3 class="mt-5">Product does not exist.</h3>
    <?php endif; ?>
</div>
<?php include_once('templates/footer.php'); ?>