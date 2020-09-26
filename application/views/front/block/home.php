     
    <!-- Secondary Navigation end -->
    <?php if($largeBannerList){ ?>
    <section class="container">
      <div class="bg-light shadow-md rounded p-4">
        <div class="row"> 
          <?php foreach($largeBannerList as $bList){ ?>
          <!-- Mobile Recharge
          ============================================= -->
          <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="owl-carousel owl-theme single-slider" data-animateout="fadeOut" data-animatein="fadeIn" data-autoplay="true" data-loop="true" data-autoheight="true" data-nav="true" data-items="1">
              <div class="item"><a href="<?php echo ($bList['redirect_url']) ? $bList['redirect_url'] : '#'; ?>"><img class="img-fluid" src="{site_url}<?php echo $bList['image_path']; ?>" alt="banner 1" /></a></div>
            </div>
          </div>
          <!-- Mobile Recharge end --> 
		  <?php } ?>
          
        </div>
      </div>
    </section>
    <?php } ?>
<?php if($sectionList){ ?>
		<?php foreach($sectionList as $bKey=>$bList){ ?>
		
<?php if($bList['section_type_id'] == 2){ ?>
<div class="container">
        <h2 class="heading"><?php echo $bList['section_name']; ?></h2>
	<div class="row home-banner-block">
		<div class="col-md-6">
			
			<a href="<?php echo ($bList['banner_1_redirect_url']) ? $bList['banner_1_redirect_url'] : '#'; ?>" <?php if($bList['banner_1_is_new_tab']){ ?> target="_blank" <?php } ?>>
				<img src="{site_url}<?php echo $bList['banner_1_image']; ?>" alt="img" width="100%" />
			</a>
			
		</div>
		<div class="col-md-6">
			
			<a href="<?php echo ($bList['banner_2_redirect_url']) ? $bList['banner_2_redirect_url'] : '#'; ?>" <?php if($bList['banner_2_is_new_tab']){ ?> target="_blank" <?php } ?>>
				<img src="{site_url}<?php echo $bList['banner_2_image']; ?>" alt="img" width="100%" />
			</a>
			
		</div>
	</div>
</div>

<?php } elseif($bList['section_type_id'] == 3){ ?>

<div class="container">
        <h2 class="heading"><?php echo $bList['section_name']; ?></h2>
	<div class="row home-banner-block">
		<div class="col-md-4">
			
			<a href="<?php echo ($bList['banner_1_redirect_url']) ? $bList['banner_1_redirect_url'] : '#'; ?>" <?php if($bList['banner_1_is_new_tab']){ ?> target="_blank" <?php } ?>>
				<img src="{site_url}<?php echo $bList['banner_1_image']; ?>" alt="img" width="100%" />
			</a>
			
		</div>
		<div class="col-md-4">
			
			<a href="<?php echo ($bList['banner_2_redirect_url']) ? $bList['banner_2_redirect_url'] : '#'; ?>" <?php if($bList['banner_2_is_new_tab']){ ?> target="_blank" <?php } ?>>
				<img src="{site_url}<?php echo $bList['banner_2_image']; ?>" alt="img" width="100%" />
			</a>
			
		</div>
		<div class="col-md-4">
			
			<a href="<?php echo ($bList['banner_3_redirect_url']) ? $bList['banner_3_redirect_url'] : '#'; ?>" <?php if($bList['banner_3_is_new_tab']){ ?> target="_blank" <?php } ?>>
				<img src="{site_url}<?php echo $bList['banner_3_image']; ?>" alt="img" width="100%" />
			</a>
			
		</div>
	</div>
</div>


    <!-- Refer & Earn end --> 
    
    <!-- Refer & Earn
    ============================================= -->
<?php } elseif($bList['section_type_id'] == 1){ 
	$sectionProductList = $this->User->get_section_product_list($bList['product_id']);
	$totalProduct = count($sectionProductList);
?>
<div class="container slider">
        <h2 class="heading"><?php echo $bList['section_name']; ?></h2>
	<div class="row">
		<div class="col-md-12">
		<?php if($sectionProductList){ ?>
			<div id="mykidCarouse<?php echo $bList['id']; ?>" class="carousel slide" data-ride="carousel" data-interval="0">
			<!-- Wrapper for carousel items -->
			<div class="carousel-inner">
			   
				<div class="item carousel-item active">
					<div class="row slider-row">
						<?php  foreach($sectionProductList as $pKey=>$pList){ ?>
						<?php if($pKey < 4){ ?>
                    	
                            <div class="col-sm-3 slider-iten-back">
                                <div class="thumb-wrapper">
                                    <div class="img-box">
                                        <a href="{site_url}product/detail/<?php echo $pList['slug']; ?>" title="<?php echo $pList['product_name']; ?>"><img src="<?php echo base_url($pList['product_img']); ?>" class="img-responsive img-fluid" alt="img"></a>
                                    </div>
                                    <div class="thumb-content">
                                        <h4><a href="{site_url}product/detail/<?php echo $pList['slug']; ?>" title="<?php echo $pList['product_name']; ?>"><?php echo substr($pList['product_name'],0,20); ?></a></h4>
										<?php if($pList['special_price_status']){ ?>
										<p class="item-price"><strike>Rs <?php echo $pList['price']; ?></strike> <span>Rs <?php echo $pList['special_price']; ?></span></p>
										<?php } else { ?>
										<p class="item-price"><span>Rs <?php echo $pList['price']; ?></span></p>
										<?php } ?>
                                        
                                        <button type="button" class="btn btn-primary" onclick="addtocart(<?php echo $pList['id']; ?>)">Add to Cart</button>
										
                                    </div>
									<div class="pro-small-loader" id="pro-small-loader-<?php echo $pList['id']; ?>"></div>									
                                </div>
                            </div>
                        
						<?php } ?>
						<?php } ?>
                    	
					</div>
				</div>
				<?php if($totalProduct > 4){ ?>
				<div class="item carousel-item">
					<div class="row slider-row">
						<?php  foreach($sectionProductList as $pKey=>$pList){ ?>
						<?php if($pKey > 3 && $pKey < 8){ ?>
                    	
                            <div class="col-sm-3 slider-iten-back">
                                <div class="thumb-wrapper">
                                    <div class="img-box">
                                        <img src="<?php echo base_url($pList['product_img']); ?>" class="img-responsive img-fluid" alt="img">
                                    </div>
                                    <div class="thumb-content">
                                        <h4><?php echo substr($pList['product_name'],0,22); ?></h4>
										<?php if($pList['special_price_status']){ ?>
										<p class="item-price"><strike>Rs <?php echo $pList['price']; ?></strike> <span>Rs <?php echo $pList['special_price']; ?></span></p>
										<?php } else { ?>
										<p class="item-price"><span>Rs <?php echo $pList['price']; ?></span></p>
										<?php } ?>
                                        
                                        
                                        <button type="button" class="btn btn-primary" onclick="addtocart(<?php echo $pList['id']; ?>)">Add to Cart</button>
                                    </div>
									<div class="pro-small-loader" id="pro-small-loader-<?php echo $pList['id']; ?>"></div>									
                                </div>
                            </div>
                        
						<?php } ?>
						<?php } ?>
                    	
					</div>
				</div>
				<?php } ?>
			   
			</div>
			<!-- Carousel controls -->
			<a class="carousel-control left carousel-control-prev" href="#mykidCarouse<?php echo $bList['id']; ?>" data-slide="prev">
				<i class="fa fa-angle-left"></i>
			</a>
			<a class="carousel-control right carousel-control-next" href="#mykidCarouse<?php echo $bList['id']; ?>" data-slide="next">
				<i class="fa fa-angle-right"></i>
			</a>
		</div>
		<?php } ?>
		</div>
	</div>
</div>
<?php 
}
	}
} ?>
