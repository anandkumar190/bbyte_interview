<div class="select_section">
<div class="container">
		<div class="row">
			<div class="col-sm-12">
			{system_message}
				{system_warning}
			</div>
		</div>
	</div>
	<div class="shop_section">
      	<div class="container">
        	<div class="row shop_row">
            	<div class="col-sm-12">	
					<div class="row">
					    
                    <div class="col-sm-12 shoppingcart">
                        <h4>Review your order</h4>
                        
                    </div>

                	<div class="col-sm-9">
                        
                        <div class="col-sm-12 shoppingdetails">
							<div class="row">
                            <div class="col-sm-4 address-details">
                                <h5 class="shipping-address">
                                    Shipping address 
                                </h5>
                                <p class="deatilsss">
                                    <?php echo $addressData['name']; ?><br />
                                    <?php echo $addressData['address_1']; ?><br />
                                    <?php echo $addressData['address_2']; ?><br />
									<?php echo $addressData['city']; ?>, <?php echo $addressData['state_name']; ?>, <?php echo $addressData['country_name']; ?> - <?php echo $addressData['zip_code']; ?><br />
                                    Phone: <?php echo $addressData['phone_number']; ?><br />
                                    
                                    
                                </p>
                            </div>
                            <div class="col-sm-4 pay-method">
                                
                            </div>
                            <div class="col-sm-4 offers">
                                
                            </div>
							</div>
                        </div>	
						<?php if($cartProductList){ ?>
						<?php $total = 0; foreach($cartProductList as $cList){ 
							$total+=$cList['price'] * $cList['qty'];
						?>
                        <div class="row" id="cart-row-<?php echo $cList['id']; ?>">
                            
                                <div class="col-sm-2">
                                    <div class="img_div review-img">
                                        <img src="<?php echo base_url($cList['product_img']); ?>" class="img-responsive">
                                    </div>
                                </div>
                            <div class="col-sm-8">
                                <div class="content_div">
                                    <h5><a href="{site_url}product/detail/<?php echo $cList['slug']; ?>" title="<?php echo $cList['product_name']; ?>"><?php echo $cList['product_name']; ?></a></h5> 
                                    <form class="qty">
                                        <label>Qty : <?php echo $cList['qty']; ?></label>
                                    </form>                           
                                </div>
                            </div>
                            
                            <div class="col-sm-2 text-right">
                                <div class="price_div">
                                    <h4 id="pro-qty-price<?php echo $cList['id']; ?>">&#8377; <?php echo number_format($cList['price'] * $cList['qty'],2); ?></h4>
                                </div>
                            </div>
							
                        </div>
						<?php } ?>
						<?php } else { ?>
						<div class="row">
                            <h3>There is no product in cart.</h3>
                        </div> 
						<?php } ?>
                    </div>
					<?php if($cartProductList){ ?>
                	<div class="col-sm-3 side-box">
                    	<div class="col-sm-12 Place Your-Order-and-Pay-btn">
                        	<!--<a href="{site_url}checkout/orderAuth/{address_id}" target="_blank"><button type="button" class="btn btn-success btn-block checkout-btn" value="Place Your Order and Pay">Place Your Order</button></a>-->
                        </div>
                        <div class="col-sm-12">
                        	<h3 class="summery">Order Summary:</h3>
                        </div>
                        <div class="col-sm-12">
                            <table class="total-order">
                            	<tr>
                                	<td>Items:</td>
                                	<td>&#8377;<?php echo number_format($total,2); ?></td>
                                </tr>
                            	<tr>
                                	<td>Delivery:</td>
                                	<td>&#8377;0.00</td>
                                </tr>
                            	<tr>
                                	<td>&nbsp;</td>
                                	<td>&nbsp;</td>
                                </tr>
                            	<tr class="total">
                                	<td>Order Total:</td>
                                	<td>&#8377;<?php echo number_format($total,2); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
					<?php } ?>
					</div>
                	
				</div>                        
			</div>
		</div>
	</div>
</div>