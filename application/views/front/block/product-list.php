<div class="shop_section">
      	<div class="container">
<div class="wrapper bg-wrapper">
       
        
            
            <section class="products bg-light padding-sm mt-2 ">
                <header class="section-heading padding-sm mb-1">
                    <h2> {category_name} </h2>
                </header>
                <div class="container">
					<div class="row">
					<?php if($productList){ ?>
					<?php foreach($productList as $list) { ?>
					<div class="col-sm-3 res-div">
                    
                        <div class="product-img-container">
							<a href="{site_url}product/detail/<?php echo $list['slug']; ?>"><img src="<?php echo base_url($list['product_img']); ?>" alt="img"></a>
						</div>
                        <div class="product-desc-container pro-name">
                            <div class="product-desc mr-auto"><a href="{site_url}product/detail/<?php echo $list['slug']; ?>" title="<?php echo $list['product_name']; ?>"><?php echo substr($list['product_name'],0,60); ?></a></div>
                        </div>
                        <div class="product-desc-container pro-price">
							<?php if($list['special_price_status']){ ?>
                            <div class="product-price"><p class="item-price"><strike>&#8377; <?php echo $list['price']; ?></strike> <span class="price">&#8377; <?php echo $list['special_price']; ?></span></p></div>
							<?php } else { ?>
                            <div class="product-price"> <span class="price">&#8377; <?php echo $list['price']; ?></span></div>
							<?php } ?>
                        </div>
                        <div class="product-desc-container flex-row">
                            <div class="product-desc mr-auto"> <span class="desc"> 
							<?php if($list['stock_status']){ ?>
								<font color="green">In Stock</font>
							<?php } else { ?>
							<font color="red">Out of Stock</font>
							<?php } ?>
							</span>
							</div>
                           
                        </div>
                        <div class="product-desc-container pro-price">
                            <div class="product-price">
								<?php if($list['stock_status']){ ?>
								<button type="button" class="product-list-add-to-cart-btn" onclick="addtocart(<?php echo $list['id']; ?>)"><i class="fa fa-cart-plus"></i></button>
								<?php } ?>
								
							</div>
                        </div>
                    
					</div>
					<?php } ?>
					<?php }else { ?>
					<div class="col-sm-12">
					<center>Sorry ! There is no product available for this category.</center>
					</div>
					<?php } ?>
					</div>
                    
                </div>
            </section>

        
    </div>
	</div>
</div>