<section class="section pb-0 card">
	<div class="container">
		<div class="card1">
			<div class="container-fliud">
				<div class="wrapper row">
					<div class="preview col-md-6">
						
						<?php if($productList['base_img']){ ?>
					  <div class="show" href="<?php echo base_url($productList['base_img']); ?>" style="text-align:center;">
						<img src="<?php echo base_url($productList['base_img']); ?>" id="show-img">
					  </div>
					  <div class="small-img">
						<img src="{site_url}skin/front/images/online_icon_right@2x.png" class="icon-left" alt="" id="prev-img">
						<div class="small-container">
						  <div id="small-img-roll">
							
							<?php if($productList['base_img_name']){ ?>
							
							<img src="<?php echo base_url('media/product_images/thumbnail-70x70/'.$productList['base_img_name']); ?>" class="show-small-img" alt="">
							
							<?php } ?>
							<?php foreach($productList['all_img'] as $imgList){ ?>
								
								<img src="<?php echo base_url('media/product_images/thumbnail-70x70/'.$imgList['file_name']); ?>" class="show-small-img" alt="">
								
							<?php } ?>
						  </div>
						</div>
						<img src="{site_url}skin/front/images/online_icon_right@2x.png" class="icon-right" alt="" id="next-img">
					  </div>
					  <?php } ?>
						
					</div>
					<div class="details col-md-6">
						<h3 class="product-title"><?php echo ucwords($productList['product_name']); ?></h3>
						<div class="pro-detail-price">
						
						<?php if($productList['special_price_status']){ ?>
						<span class="large-price">₹ <?php echo number_format($productList['special_price']); ?></span>
						<span class="small-price">₹ <?php echo number_format($productList['price']); ?></span>
						<?php } else { ?>
						<span class="large-price">₹ <?php echo number_format($productList['price']); ?></span>
						<?php } ?>
						</div>
						<p class="vote">
							<?php if($productList['stock_status']){ ?>
							<span class="checked">In Stock</span>
							<?php } else { ?>
							<span class="checked"><font color="red">Out of Stock</font></span>
							<?php } ?>
						</p>
						<?php if($productList['instruction']){ ?>
						<?php $ins_list = explode('|',$productList['instruction']); ?>
						<ul class="discount-col">
						  <?php foreach($ins_list as $val){ ?>
						  <?php if($val){ ?>
							  <li><i class="fa fa-tag" aria-hidden="true"></i><?php echo $val; ?></li>
							  <?php } ?>
						  <?php } ?>
								
						</ul>
						<?php } ?>
						<?php if(isset($productList['attribute_list']) && $productList['attribute_list']){ ?>
						<?php foreach($productList['attribute_list'] as $aList){ ?>
						<h6 class="sizes"><?php echo $aList['label']; ?><h6>
							<?php if($aList['attribute_data']){ ?>
							<div class="br_box">
								<?php if($aList['form_type'] == 2 || $aList['form_type'] == 4){ ?>
								<ul class="select-color">
									<?php foreach($aList['attribute_data'] as $aVal){ ?>
									<li style="background-color:<?php echo $aVal['label']; ?>;" <?php if(isset($aVal['is_active']) && $aVal['is_active'] == 1){ ?> class="active" <?php } ?>>&nbsp;</li>
									<?php } ?>
								</ul>
								<?php } else { ?>
								<ul class="select-size">
									<?php foreach($aList['attribute_data'] as $aVal){ ?>
									<li><a href="#"><?php echo $aVal['label']; ?></a></li>
									<?php } ?>
								</ul>
								<?php } ?>
							</div>
							<?php } ?>
						<?php } ?>
						<?php } ?>
				  
						<?php if($productList['stock_status']){ ?>
						<div class="action">
							<button class="add-to-cart btn btn-default" onclick="addtocart(<?php echo $productList['id']; ?>)" type="button">add to cart</button>
						</div>
						<div class="pro-small-loader" id="pro-small-loader-<?php echo $productList['id']; ?>"></div>
						<?php } ?>
					</div>
					<div class="col-sm-12">
						<div class="pr_content">
							<button class="accordion">Product Details</button>
						<div>
							<p><?php echo $productList['description']; ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
  </section>