<?php
require_once('../assets/constants/config.php');
require_once('constants/check-login.php');
include('header.php');
?>
<?php 
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
$stmt = $conn->prepare("SELECT * FROM medicine_category WHERE delete_status=0");
$stmt->execute();
$categories = $stmt->fetchAll(); ?>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row mb-1">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Add Medicine</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Add Medicine
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Input Validation start -->
                <section class="input-validation">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form-horizontal" action="app/medicine" method="post" enctype="multipart/form-data" novalidate>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <h5>Genetic name <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" name="genetic_name" class="form-control mb-1" required data-validation-required-message="Genetic name is required">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Brand Name <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <input type="text" name="brand_name" class="form-control mb-1" required data-validation-required-message="Brand Name is required">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Description </h5>
                                                        <div class="controls">
                                                            <textarea name="description" class="form-control mb-1" placeholder="Description" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Country </h5>
                                                        <div class="controls">
                                                            <input type="text" name="country" class="form-control mb-1">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Product Number </h5>
                                                        <div class="controls">
                                                            <input type="text" class="form-control mb-1" name="product_no">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Importer date <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="date" name="importer_date" class="form-control mb-1" data-validation-required-message="Importer date is required">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Expire date <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="date" name="expire_date" class="form-control mb-1" data-validation-required-message="Expire date is required">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Side effect <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <textarea name="side_effect" class="form-control mb-1"  required placeholder="Side effect" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <h5>Category <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <select name="category" id="select"  class="form-control mb-1" required>
                                                                <option value="">Select Your Category</option>
                                                                <?php foreach ($categories as $value) {  ?>
                                                                <option value="<?=$value['id']?>"><?=$value['name']?>&lrm;</option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Quantity <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <input type="number" name="qty" class="form-control mb-1" required data-validation-required-message="Quantity is required" min="1">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Sale price <span class="required">*</span></h5>
                                                        <div class="controls">
                                                            <input type="number" name="sale_price" class="form-control mb-1" required data-validation-required-message="Quantity is required" min="0">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Supplied Name </h5>
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <select name="supplied_name"  class="form-control mb-1 select2">
                                                                <option value="">Select Supplied Name</option>
                                                                <option value="Deved">Deved</option>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Original Price</h5>
                                                        <div class="controls">
                                                            <div class="input-group">
                                                                <input type="number" name="original_price" class="form-control" min="1" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="form-group">
                                                        <h5>Discount </h5>
                                                        <div class="controls">
                                                            <input type="number" name="discount" class="form-control mb-1">
                                                        </div>
                                                    </div> -->
                                                    <div class="form-group">
                                                        <h5>Medicine type </h5>
                                                        <div class="controls">
                                                            <select class="form-control select2" name="icon">
                                                                <option>Select one</option>
                                                                <option value="Syrup">Syrup</option>
                                                                <option value="Pills">Pills</option>
                                                                <option value="Syringe">Syringe</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Barcode </h5>
                                                        <div class="controls">
                                                            <input type="text" name="barcode" class="form-control mb-1" placeholder="Barcode">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <h5>Image upload </h5>
                                                        <div class="controls">
                                                            <input type="file" name="image">
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <button type="submit" name="btn_save" class="btn btn-success">Submit <i class="la la-thumbs-o-up position-right"></i></button>
                                                        <a href="manage" class="btn btn-danger">Cancel <i class="la la-close position-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Input Validation end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <?php include 'footer.php'; ?>