<div class="login_section">
		<div class="container" >
        	<div class="row">
			{system_message}
				{system_warning}
           	
        </div>     
      </div>
	  
	  
	
	<div class="container">

	<?php if($orderData){ ?>
	<?php foreach($orderData as $list){ ?>	
	<div class="row">

	<div class="col-sm-12 pt-5" style="padding-left: 0px;">
	<h5>Order Deatils</h5>
	<h6>Ordered on 31 Mar, 2020 &nbsp;&nbsp; &nbsp;   | &nbsp; &nbsp;&nbsp;   Order# JBO00002</h6>	
	</div>	

	</div>


	<div class="row mb-4" style="border: 1px solid #d8d2d2; padding: 20px;">

	<div class="col-sm-9">
	<h6>Shipping Address</h6>
	<p class="deatilsss">
    <?php echo $list['add_name']; ?><br />
    <?php echo $list['address_1']; ?><br />
    <?php echo $list['address_2']; ?><br />
    <?php echo $list['city']; ?>, <?php echo $list['country_name']; ?><br />
    Phone: <?php echo $list['phone_number']; ?><br />
    </p>	
	</div>


	<div class="col-sm-3">
	<h6>Order Summary</h6>
	
	<table class="table">
	<tr>
	<td>
	Item(s) Subtotal:
	</td>
	<td align="right">
	&#8377 <?php echo number_format($list['total_item_price'],2); ?>
	</td>
	</tr>
	<tr>
	<td>
	Shipping:
	</td>
	<td align="right">
	&#8377 <?php echo number_format($list['delivery_price'],2); ?>
	</td>
	</tr>
	<tr>
	<td>
	Total:
	</td>
	<td align="right">
	&#8377 <?php echo number_format($list['total_price'],2); ?>	
	</td>
	</tr>
	<tr>
	<td>
	<b>Grand Total:</b>
	</td>
	<td align="right">
	<b>&#8377 <?php echo number_format($list['total_price'],2); ?></b>
	</td>
	</tr>
	</table>	
	</div>	

	</div>	


	<div class="row mt-4" style="border: 1px solid #d8d2d2; padding: 10px;">  
          <?php if($list['status'] == 4){ ?>
                                    <h5><font color="red"><?php echo $list['status_title']; ?></font> <?php echo date('d M, Y',strtotime($list['updated'])); ?></h5>
                  <?php } elseif($list['status'] == 5){ ?>
                                    <h5><font color="green"><?php echo $list['status_title']; ?></font> <?php echo date('d M, Y',strtotime($list['updated'])); ?></h5>
                  <?php } else { ?>
                  <h5><?php echo $list['status_title']; ?></h5>
                  <?php } ?>  
    </div>


		<?php if($list['productInfo']){ ?>
		<?php foreach($list['productInfo'] as $proKey=>$proList){ ?>
        
          <div class="row" style="border: 1px solid #d8d2d2; padding: 10px;">

            
          <div class="col-sm-2">
            <a href="{site_url}product/detail/<?php echo $proList['slug']; ?>"><img src="<?php echo base_url($proList['product_img']); ?>" width="80" alt="img"></a>
          </div>

          <div class="col-sm-2">
          <p><a href="{site_url}product/detail/<?php echo $proList['slug']; ?>" title="<?php echo $proList['product_name']; ?>"><?php echo $proList['product_name']; ?></a><br>
									   <span>Qty: <?php echo $proList['product_qty']; ?></span><br>
									   &#8377 <?php echo number_format($proList['gross_amount'],2); ?>
									</p>
          </div>

          <div class="col-sm-8 text-right">
                  
          </div>  
          
        
          </div>

          <?php } ?>
          <?php } ?>  



	</div>  
	<?php } ?>
	  <?php } else { ?>
	<div class="container">
     <div class="row">
        <div class="col-sm-12 text-center">
		We aren't finding any any orders
		</div>
	 </div>
	</div>
	  <?php } ?>  
    