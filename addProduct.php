 <?php
    include_once('function.php');
    if (!isset($_SESSION['LoginUser'])) {
        header("Location: login.php");
    }

    if (isset($_POST['submit'])) {


        $id = insertProduct($_POST['product_name'], $_POST['product_description'], $_SESSION['LoginUser']);
        if ($id) {
            $imageName = uploadImage('image', 'uploads', $id);
            if ($imageName != "Failed") {
                updateImageData($id, $imageName);
            }
            header("Location: details.php?ID=" . $id);
        }
    }

    ?>
 <?php include_once('templates/header.php'); ?>
 <div class="container">
     <h1 class="my-5">Add New Product form</h1>
     <form method="POST" enctype="multipart/form-data">
         <div class="mb-3">
             <label class="form-label">Product Name</label>
             <input type="text" name="product_name" id="product_name" class="form-control form-control-lg" placeholder="Specify product name..." required>
         </div>
         <div class="mb-3">
             <label class="form-label">Product Description</label>
             <textarea rows="5" name="product_description" id="description" class="form-control" placeholder="Specify product description..." required></textarea>
         </div>
         <div class="my-4">
             <input type="file" name="image" id="image">
         </div>
         <button type="submit" name="submit" class="bg-primary btn btn-lg my-4 text-white">Save</button>
     </form>
 </div>
 <?php include_once('templates/footer.php'); ?>