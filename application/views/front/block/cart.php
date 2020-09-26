<section class="section pb-0 card">
<div class="container">
	<table id="cart-table" class="table table-hover table-condensed cart-block">
    				<thead>
						<tr>
							<th style="width:50%">Product</th>
							<th style="width:10%">Price</th>
							<th style="width:8%">Quantity</th>
							<th style="width:22%" class="text-center">Subtotal</th>
							<th style="width:10%"></th>
						</tr>
					</thead>
					<?php if($cartProductList){ ?>
					<tbody>
						
						<?php $total = 0; foreach($cartProductList as $cList){ 
							$total+=$cList['price'] * $cList['qty'];
						?>
						<tr id="cart-row-<?php echo $cList['id']; ?>">
							<td data-th="Product">
								<div class="row">
									<div class="col-sm-2 hidden-xs"><img src="<?php echo base_url($cList['product_img']); ?>" class="img-responsive"/></div>
									<div class="col-sm-10" style="padding-left:35px;">
										<h4 class="nomargin"><?php echo $cList['product_name']; ?></h4>
										
									</div>
								</div>
							</td>
							<td data-th="Price">&#8377; <?php echo number_format($cList['price'],2); ?></td>
							<td data-th="Quantity">
								<input type="number" class="form-control text-center" onchange="updateProCart(<?php echo $cList['id']; ?>,<?php echo $cList['temp_id']; ?>)" id="cart-qty-number-<?php echo $cList['id']; ?>" min="1" max="10" value="<?php echo $cList['qty']; ?>">
							</td>
							<td data-th="Subtotal" class="text-center" id="pro-qty-price<?php echo $cList['id']; ?>">&#8377; <?php echo number_format($cList['price'] * $cList['qty'],2); ?></td>
							<td class="actions" data-th="">
								<button class="btn btn-danger btn-sm" onclick="deleteProCart(<?php echo $cList['id']; ?>,<?php echo $cList['temp_id']; ?>)"><i class="fa fa-trash-o"></i></button>								
							</td>
						</tr>
						<?php } ?>
						
						<tr>
							<td data-th="Product" colspan="10" style="border:0px;">
														
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td><a href="{site_url}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
							<td colspan="2" class="hidden-xs"></td>
							<td class="hidden-xs text-center" id="cart-total-price"><strong>Total &#8377; <?php echo number_format($total,2); ?></strong></td>
							<td>
								<?php if($this->session->userdata('cranesmart_member_session') || $this->session->userdata('cranesmart_vendor_session')){ ?>
								<!--<a href="{site_url}checkout" class="btn btn-success btn-block checkout-btn">Checkout&nbsp;&nbsp;></a>-->
								<?php } else { ?>
								<a href="{site_url}login?redirect=checkout" class="btn btn-success btn-block checkout-btn">Checkout&nbsp;&nbsp;><!--<i class="fa fa-angle-right"></i>--></a>
								<?php } ?>
							</td>
						</tr>
					</tfoot>
					<?php } else { ?>
					<tbody>
						<tr>
							<td colspan="6">
							<center>
							Sorry ! There is no product in cart. <br /><br />
							<a href="{site_url}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
							</center>
							</td>
						</tr>
					</tbody>
					<?php } ?>
				</table>
</div>
  </section>