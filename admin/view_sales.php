<?php
require_once('../assets/constants/config.php');
require_once('constants/check-login.php');
include('header.php');
?>
<?php 
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
$stmt = $conn->prepare("SELECT * FROM sales WHERE id='".$_GET['id']."'");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT sum(deposit_amount) as amount FROM sales_deposit WHERE sales_id='".$result['id']."'");
$stmt->execute();
$deposit= $stmt->fetch(PDO::FETCH_ASSOC);

$remain=$result['grand_total']-$deposit['amount'];

$stmt = $conn->prepare("SELECT * FROM customers WHERE id='".$result['customer_id']."'");
$stmt->execute();
$customer= $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM sales_item WHERE sales_id='".$result['id']."'");
$stmt->execute();
$items = $stmt->fetchAll();

$stmt = $conn->prepare("SELECT * FROM sales_deposit WHERE sales_id='".$result['id']."'");
$stmt->execute();
$deposits = $stmt->fetchAll();

?>
<!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row mb-1">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">Invoice</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Invoice
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section class="card">
                    <div id="invoice-template" class="card-body">
                        <!-- Invoice Company Details -->
                        <div id="invoice-company-details" class="row">
                            <div class="col-md-6 col-sm-12 text-center text-md-left">
                                <div class="media">
                                    <img src="../assets/uploads/settings/<?=$logo?>" alt="company logo" class="" />
                                    <div class="media-body">
                                        <ul class="ml-2 px-0 list-unstyled">
                                            <li class="text-bold-800"><?=$_SESSION['email']?></li>
                                            <li>4025 Oak Avenue,</li>
                                            <li>Nashik,</li>
                                            <li>Mharashtra 32940,</li>
                                            <li>India</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 text-center text-md-right">
                                <h2>INVOICE</h2>
                                <ul class="px-0 list-unstyled">
                                    <li>Remain Amount</li>
                                    <li class="lead text-bold-800"><?=$_SESSION['currency']?><?=$remain?></li>
                                </ul>
                            </div>
                        </div>
                        <!--/ Invoice Company Details -->

                        <!-- Invoice Customer Details -->
                        <div id="invoice-customer-details" class="row pt-2">
                            <div class="col-sm-12 text-center text-md-left">
                                <p class="text-muted">Bill To</p>
                            </div>
                            <div class="col-md-6 col-sm-12 text-center text-md-left">
                                <ul class="px-0 list-unstyled">
                                    <li class="text-bold-800"><?=$customer['name']?></li>
                                    <li><?=$customer['address']?></li>
                                    <li><?=$customer['telephone']?></li>
                                    <li><?=$customer['fax']?></li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-sm-12 text-center text-md-right">
                                <p><span class="text-muted">Invoice Date :</span><?=$result['added_date']?></p>
                            </div>
                        </div>
                        <!--/ Invoice Customer Details -->

                        <!-- Invoice Items Details -->
                        <div id="invoice-items-details" class="pt-2">
                            <div class="row">
                                <div class="table-responsive col-sm-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Item & Description</th>
                                                <th class="text-right">Rate</th>
                                                <th class="text-right">Qty</th>
                                                <th class="text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach ($items as $item) { 
                                                $stmt = $conn->prepare("SELECT * FROM medicine WHERE id='".$item['medicine_id']."'");
                                                $stmt->execute();
                                                $medicine = $stmt->fetch(PDO::FETCH_ASSOC);

                                                ?>
                                            <tr>
                                                <th scope="row"><?=$i?></th>
                                                <td>
                                                    <p><?=$medicine['genetic_name']?></p>
                                                    <p class="text-muted"><?=$medicine['description']?></p>
                                                </td>
                                                <td class="text-right"><?=$_SESSION['currency']?><?=$medicine['sale_price']?></td>
                                                <td class="text-right"><?=$item['qty']?></td>
                                                <td class="text-right"><?=$_SESSION['currency']?><?=$item['amount']?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7 col-sm-12 text-center text-md-left">
                                    <p class="lead">Deposits :</p>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="table-responsive">
                                                <table class="table table-borderless table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td>Amount :</td>
                                                            <td class="text-right">Date</td>
                                                        </tr>
                                                        <?php foreach ($deposits as $deposit1) { ?>
                                                        <tr>
                                                            <td><?=$_SESSION['currency']?><?=$deposit1['deposit_amount']?> </td>
                                                            <td class="text-right"><?=$deposit1['added_date']?></td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-12">
                                    <p class="lead">Total due</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="text-bold-800">Total</td>
                                                    <td class="text-bold-800 text-right"><?=$_SESSION['currency']?><?=$result['grand_total']?></td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Made</td>
                                                    <td class="pink text-right"><?=$_SESSION['currency']?><?=$deposit['amount']?></td>
                                                </tr>
                                                <tr class="bg-grey bg-lighten-4">
                                                    <td class="text-bold-800">Balance Due</td>
                                                    <td class="text-bold-800 text-right"><?=$_SESSION['currency']?><?=$remain?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
<?php include 'footer.php'; ?>