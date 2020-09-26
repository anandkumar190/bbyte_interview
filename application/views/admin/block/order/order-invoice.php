<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Jadibootiwala Invoice</title>
<link rel="stylesheet" type="text/css" href="{site_url}skin/front/invoice/style.css" />
</head>
<body>
<div align="center">
	<div class="contant-div">
        <div class="main-div">
            <div class="logo-div">
                <img src="{site_url}skin/front/invoice/logo-1.png" class="logo-img" />
            </div>
            <div class="logo-ls-div">
                <strong>Tax Invoice/Bill of Supply/Cash Memo </strong><br />(Original for Recipient)
            </div>
        </div>
        <div class="main-div">
            <div class="sold-div">
                <strong>Sold By</strong><br /><?php echo $companyData['company_name']; ?> <br />* <?php echo $companyData['address']; ?>
            </div>
            <div class="address-div">
                <strong>Billing Address</strong><br /><?php echo $orderData[0]['add_name']; ?> <br /><?php echo $orderData[0]['address_1']; ?> <br />  <?php echo $orderData[0]['address_2']; ?> <br /><?php echo $orderData[0]['city']; ?>, <?php echo $orderData[0]['country_name']; ?> <br />Phone: <?php echo $orderData[0]['phone_number']; ?>
            </div>
        </div>
        <div class="main-div">
            <div class="sold-div">
				<?php if($companyData['pan_number']){ ?>
                <strong>PAN NO:</strong> <?php echo $companyData['pan_number']; ?> <br />
				<?php } ?>
				<?php if($companyData['gst_number']){ ?>
				<strong>GST Registration No:</strong> <?php echo $companyData['gst_number']; ?>
				<?php } ?>
            </div>
            <div class="address-div">
                <strong>Shipping Address</strong><br /><?php echo $orderData[0]['add_name']; ?> <br /><?php echo $orderData[0]['address_1']; ?> <br />  <?php echo $orderData[0]['address_2']; ?> <br /><?php echo $orderData[0]['city']; ?>, <?php echo $orderData[0]['country_name']; ?> <br />Phone: <?php echo $orderData[0]['phone_number']; ?>
            </div>
        </div>
        <div class="main-div">
            <div class="sold-div">
                <strong>Order Number:</strong> <?php echo $orderData[0]['order_display_id']; ?> <br /><strong>Order Date:</strong> <?php echo date('d M, Y',strtotime($orderData[0]['created'])); ?>
            </div>
            <div class="address-div">
                <strong>Invoice Number:</strong> <?php echo $invoiceData['invoice_display_id']; ?><br /><strong>Invoice Date :</strong> <?php echo date('d M, Y',strtotime($invoiceData['created'])); ?>
            </div>
        </div>


        <div class="table-div">
        	<table width="100%">
            	<tr>
                	<th class="heading1" width="2%"><strong>SR.<br/>NO.</strong></th>
                	<th class="heading2" width="35%" align="left"><strong>Description</strong></th>
                	<th class="heading3" width="10%" align="right"><strong>Unit <br /> Price</strong></th>
                	<th class="heading4" width="5%"><strong>Qty</strong></th>
                	<th class="heading5" width="10%" align="right"><strong>Net<br/>Amount</strong></th>
                	<th class="heading6" width="10%" align="right"><strong>Tax<br/>Rate</strong></th>
                	<th class="heading7" width="15%" align="right"><strong>Tax<br/>Type</strong></th>
                	<th class="heading8" width="15%" align="right"><strong>Tax<br/>Amount</strong></th>
                	<th class="heading9" width="20%" align="right"><strong>Total<br/>Amount</strong></th>
                </tr>
				<?php if(isset($orderData[0]['productInfo']) && $orderData[0]['productInfo']){
				$total_tax_amount = 0;
				$total_gross_amount = 0;
				?>
				<?php foreach($orderData[0]['productInfo'] as $key=>$list){ 
					$total_tax_amount+=$list['gst_amount'];
					$total_gross_amount+=$list['gross_amount'];
				?>
            	<tr>
                	<th class="heading1"><?php echo $key + 1; ?>.</th>
                	<th class="heading2" align="left"><?php echo $list['product_name']; ?></th>
                	<th class="heading3" align="right">&#8377; <?php echo number_format($list['product_base_price'],2); ?></th>
                	<th class="heading4"><?php echo $list['product_qty']; ?></th>
                	<th class="heading5" align="right">&#8377; <?php echo number_format($list['product_total_price'],2); ?></th>
                	<th class="heading6" align="right"><?php echo number_format($list['gst_percentage'],2); ?>%</th>
                	<th class="heading7" align="right">
						<?php if($list['is_out_state']){ ?>
						IGST (<?php echo $list['gst_percentage']; ?>%)
						<?php } else { ?>
						SGST (<?php echo $list['sgst_percentage']; ?>%) <br />
						CGST (<?php echo $list['cgst_percentage']; ?>%)
						<?php } ?>
					</th>
                	<th class="heading8" align="right">&#8377; <?php echo number_format($list['gst_amount'],2); ?></th>
                	<th class="heading9" align="right">&#8377; <?php echo number_format($list['gross_amount'],2); ?></th>
                </tr>
				<?php } ?>
                <tr>
                	<td colspan="7" class="total-ta"><strong>Total</strong></td>
                	<td class="total-txam" align="right"><strong><?php echo number_format($total_tax_amount,2); ?></strong></td>
                	<td class="total-totam"><strong><?php echo number_format($total_gross_amount,2); ?></strong></td>
                </tr>
                <tr>
                	<td colspan="9"><strong>Amount in Words:</strong><br  /><strong><?php echo $this->User->convert_number_to_text($total_gross_amount); ?> only</strong></td>
                </tr>
                <tr>
                	<td colspan="9" style="text-align:right;"><strong>For <?php echo $companyData['company_name']; ?>:</strong><br  /><strong><img src="{site_url}skin/front/invoice/sign.png" class="sigh"  /><br /> <strong>Authorized Signalery</strong></td>
                </tr>
				<?php } ?>
            </table>
        </div>

	</div>

    <div class="row" style="margin-bottom: 30px;">
    <button class="btn btn-primary" id="printBtn" style="padding: 10px 20px 10px 20px; border: none; background: rgb(68, 182, 73);color: white;" type="button" onclick="window.print()">Print</button>    
    </div>



    
</div>
</body>
</html>
