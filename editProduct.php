 <?php
    include_once('function.php');
    if (!isset($_SESSION['LoginUser'])) {
        header("Location: login.php");
    }


    $id = $_GET['ID'];
    if (isset($id)) {
        $product = getProductById($id);
    }

    if (isset($_POST['submit'])) {

        editProduct($_POST['ID'], $_POST['product_name'], $_POST['product_description'], $_SESSION['LoginUser']);

        if ($_FILES['image']['name']) {
            $milliseconds = intval(microtime(true) * 1000);
            $imageName = uploadImage('image', 'uploads', $milliseconds . "_" . $_POST['ID']);
            if ($imageName != "Failed") {
                updateImageData($_POST['ID'], $imageName);
            }
        }

        header("Location: details.php?ID=" . $_POST['ID']);
    }

    ?>
 <?php include_once('templates/header.php'); ?>
 <div class="container">
     <?php if ($product) : ?>
         <h1 class="my-5">Edit Product form</h1>
         <form method="POST" enctype="multipart/form-data">
             <div class="mb-3">
                 <label class="form-label">Product Name</label>
                 <input type="text" name="product_name" id="product_name" class="form-control form-control-lg" placeholder="Specify product name..." required value="<?= $product['product_name']; ?>">
             </div>
             <div class="mb-3">
                 <label class="form-label">Product Description</label>
                 <textarea rows="5" name="product_description" id="description" class="form-control" placeholder="Specify product description..." required><?= $product['product_description']; ?></textarea>
             </div>
             <div class="my-4">
                 <input type="file" name="image" id="image">
             </div>
             <button type="submit" name="submit" class="bg-primary btn btn-lg my-4 text-white">Update</button>
             <input type="hidden" name="ID" value="<?= $product['ID']; ?>">
         </form>
     <?php else : ?>
         <h3 class="mt-5">Product does not exist.</h3>
     <?php endif; ?>

 </div>
 <?php include_once('templates/footer.php'); ?>