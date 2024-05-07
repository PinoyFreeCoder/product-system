<?php

include_once('./function.php');

$currentPage = $_GET['page'] ?? 1;
$itemsPerPage = 10;

$searchTerm = $_GET['search'] ?? '';
$totalItems = totalProducts($searchTerm);
$totalPages = ceil($totalItems / $itemsPerPage);


$products = getAllProducts($currentPage, $itemsPerPage, $searchTerm);
$pageLinks = generatePageLinks($totalPages, $currentPage, $searchTerm);



?>
<?php include_once('templates/header.php'); ?>
<div class="container">
    <h1 class="mt-5">Products</h1>
    <div class="mt-2">

        <?php if (isset($_SESSION['LoginUser'])) : ?>
            <a href="addProduct.php" class="btn bg-success text-white my-2">Add New Product</a>
        <?php endif; ?>

        <div class="d-flex flex-row-reverse">
            <form method="get" class="w-40">
                <div class="input-group mb-3">
                    <input type="search" class="form-control" placeholder="Search for product name..." name="search" required>
                    <button type="submit" class="btn btn-primary text-white input-group-append">Search</button>
                </div>
            </form>
        </div>



        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>Product Name</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) { ?>
                    <tr>
                        <td width="50px"><a href="details.php?ID=<?= $product['ID']; ?>" class="btn btn-sm bg-primary text-white">view</a></td>
                        <td><?= $product['product_name']; ?></td>
                        <td><?= $product['createdAt']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <p class="my-4 fw-bold">Total of <?= $totalItems; ?> products</p>
        <nav>
            <ul class="pagination">
                <?= $pageLinks; ?>
            </ul>
        </nav>
    </div>
</div>
<?php include_once('templates/footer.php'); ?>