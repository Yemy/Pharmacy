<style>
	tbody tr td {
    font-family: 'Poppins', sans-serif;
    color: black;
}
b
{
	margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
    line-height: 1.33em;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
}
#popup_print {
    color: #000;
    margin: 0 auto;
}
html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var,b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
}
p {
    display: block;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
   	line-height: 1.33em;
    color: #7E7E7E;
}
</style>
<?php
session_start();
require_once('../assets/constants/config.php');

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
$stmt = $conn->prepare("SELECT * FROM sales WHERE id='".$_POST['id']."'");
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
<div id="printSection">
  <div class="col-md-12">
  <div class="text-center">
    <p style="text-align: center; ">
      <span style="color: rgba(0, 0, 0, 0.87); font-family: arial, sans-serif-light, sans-serif; font-size: 30px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal;">
      <b>Invoice</b>
    </span><br>
  </p>
</div>
<div style="clear:both;">
  <h4 class="text-center">Sale No.: #<?php echo "INV - ".$_POST['id'].""  ?></h4> 
  <div style="clear:both;"></div>
  <span class="float-left">Date: <?=$result['added_date']?></span>
  <br><div style="clear:both;"><span class="float-left">Customer: <?=$customer['name']?><br>
  <div style="clear:both;">
    <div style="clear:both;">
      <table class="table" cellspacing="0" border="0">
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
      <table class="table" cellspacing="0" border="0" style="margin-bottom:8px;">
        <tbody>
          <tr>
            <td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">Grand Total</td><td colspan="2" style="border-top:1px dashed #000; padding-top:5px; text-align:right; font-weight:bold;"><?=$_SESSION['currency']?><?=$result['grand_total']?></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">Paid</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;"><?=$_SESSION['currency']?><?=$deposit['amount']?></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">Remaining Amount</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;"><?=$_SESSION['currency']?><?=$remain?></td>
          </tr>
        </tbody>
      </table>

      <div style="border-top:1px solid #000; padding-top:10px;"><span class="float-left"><!-- College Road Outlet --></span><span class="float-right"><!-- Tel: +91 9373901114 --></span><div style="clear:both;"><center></center><p class="text-center" style="margin:0 auto;margin-top:10px;"><!-- Thanks for visiting our Shop ! Visit again ! --></p><div class="text-center" style="background-color:#000;padding:5px;width:85%;color:#fff;margin:0 auto;border-radius:3px;margin-top:20px;">Thanks for visiting our Shop ! Visit again !</div></div></div></div></div></div></div></div>
  <div class="modal-footer">
    <button class="btn btn-warning noprint" onclick="myFunction(this)" data-print="<?php echo $result['id']; ?>" id="no_print1"><i class="fa fa-print"></i> Print</button>
    <form method="POST">
      <button type="submit" name="cancel_modal" class="btn btn-danger noprint" id="no_print">Cancel</button>
    </form>
  </div>