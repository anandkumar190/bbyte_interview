{system_message}    
{system_info}
<?php echo form_open_multipart('seller-panel/catalog/updateProduct', array('id' => 'admin_profile'),array('method'=>'post')); ?>
<?php $insList = array_filter(explode('|',$productData['instruction'])); ?>
	<!-- Content Header (Page header) -->
	<input type="hidden" name="token" value="{token}" id="token" />
	<input type="hidden" name="product_id" value="{product_id}" id="product_id" />
	<input type="hidden" value="<?php echo count($insList); ?>" id="total_instruction" />
<div class="card shadow ">
            <div class="card-header py-3">
              <div class="row">
                <div class="col-sm-6">
                <h4><b>Update Product</b></h4>
                </div>
                
                <div class="col-sm-6 text-right">
                <button onclick="window.history.back()" class="btn btn-primary"><i class="fa fa-arrow-left"> Back</i></button>
                </div>                  
              </div>  
              
            </div>
            <div class="card-body">
            
				<input type="hidden" value="<?php echo $site_url;?>" id="siteUrl">
				
              <div class="row">
              <div class="col-sm-12">
             <nav>
					<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
						<a class="nav-item nav-link active" id="nav-tab-1" data-toggle="tab" href="#tab-1" role="tab" aria-controls="nav-home" aria-selected="true">Vital Info</a>
						<a class="nav-item nav-link" id="nav-tab-2" data-toggle="tab" href="#tab-2" role="tab" aria-controls="nav-profile" aria-selected="false">Inventory</a>
						<a class="nav-item nav-link" id="nav-tab-3" data-toggle="tab" href="#tab-3" role="tab" aria-controls="nav-contact" aria-selected="false">Images</a>
						<a class="nav-item nav-link" id="nav-tab-4" data-toggle="tab" href="#tab-4" role="tab" aria-controls="nav-about" aria-selected="false">Description</a>
						<a class="nav-item nav-link" id="nav-tab-5" data-toggle="tab" href="#tab-5" role="tab" aria-controls="nav-about" aria-selected="false">Categories</a>
						<a class="nav-item nav-link" id="nav-tab-6" data-toggle="tab" href="#tab-6" role="tab" aria-controls="nav-about" aria-selected="false">Offer</a>
						<a class="nav-item nav-link" id="nav-tab-7" data-toggle="tab" href="#tab-7" role="tab" aria-controls="nav-about" aria-selected="false">Keywords</a>
						
					</div>
				</nav>
				
				<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
					<div class="tab-pane fade active in show" id="tab-1" role="tabpanel" aria-labelledby="nav-home-tab">

						<div class="row">
							<div class="col-sm-3">
							  <div class="form-group">
										<label>Status</label>                                    
										<select id="select01" class="form-control" name="status">
										<option value="1" <?php if($productData['status'] == 1){ ?> selected="selected" <?php } ?>>Enable</option>
										<option value="0" <?php if($productData['status'] == 0){ ?> selected="selected" <?php } ?>>Disable</option>
										</select>
										</div>
							  </div>
							  <div class="col-sm-3">
							  <div class="form-group">
										<label>Attribute Set</label>                                    
										<select id="selAttributeSet" class="form-control" name="attribute_set_id">
										<option value="0">Select One</option>
										<?php if($attributeSetList){ ?>
										<?php foreach($attributeSetList as $list){ ?>
										<option value="<?php echo $list['id']; ?>"<?php if($productData['attribute_set_id'] == $list['id']){ ?> selected="selected" <?php } ?>><?php echo $list['title']; ?></option>
										<?php } ?>
										<?php } ?>
										</select>
										<?php echo form_error('attribute_set_id', '<div class="error">', '</div>'); ?>
										</div>
							  </div>
							  <div class="col-sm-3">
							 <div class="form-group">
										<label>Product Name*</label>                                    
										<input type="text" class="form-control" value="<?php echo $productData['product_name']; ?>" name="product_name" placeholder="Product Name" />
										<?php echo form_error('product_name', '<div class="error">', '</div>'); ?>
										</div>
							  </div>
							  <div class="col-sm-3">
							 <div class="form-group label-instruction">
										<label>SKU*</label>                                    
										<input type="text" value="<?php echo $productData['sku']; ?>" class="form-control" name="sku" placeholder="SKU" />
										<?php echo form_error('sku', '<div class="error">', '</div>'); ?>
										
										</div>
							  </div>
						</div>
						<div class="row">
							<div class="col-sm-3">
							  <div class="form-group">
										<label>Price*</label>    
										<br />
										<div class="row">
										<div class="col-md-12">
										<input type="text" class="form-control" value="<?php echo $productData['price']; ?>" name="price" placeholder="Price" />
										</div>
										</div>
										<?php echo form_error('price', '<div class="error">', '</div>'); ?>
										</div>
							  </div>
							  <div class="col-sm-3">
							  <div class="form-group">
										<label>Special Price</label>    
										<br />
										<div class="row">
										<div class="col-md-12">
										<input type="text" class="form-control" value="<?php echo $productData['special_price']; ?>" name="special_price" placeholder="Special Price" />
										</div>
										</div>
										<?php echo form_error('special_price', '<div class="error">', '</div>'); ?>
										</div>
							  </div>
							  <div class="col-sm-3">
							 <div class="form-group">
										<label>Special Price From</label>
										<input type="text" class="form-control" value="<?php echo ($productData['special_price_from']) ? date('d-m-Y',strtotime($productData['special_price_from'])) : ''; ?>" name="special_price_from" id="special_price_from" placeholder="From Date" />
										</div>
							  </div>
							  <div class="col-sm-3">
							 <div class="form-group">
										<label>Special Price To</label>
										<input type="text" class="form-control" value="<?php echo ($productData['special_price_to']) ? date('d-m-Y',strtotime($productData['special_price_to'])) : ''; ?>" name="special_price_to" id="special_price_to" placeholder="To Date" />
										
										</div>
							  </div>
						</div>
						<div class="row">
							<div class="col-sm-3">
							 <div class="form-group">
										<label>Visibility</label>                                    
										<select id="select01" class="form-control" name="product_visibility">
										<?php if($visibilityList){ ?>
										<?php foreach($visibilityList as $list){ ?>
										<option value="<?php echo $list['id']; ?>" <?php if($productData['visibility'] == $list['id']){ ?> selected="selected" <?php } ?>><?php echo $list['title']; ?></option>
										<?php } ?>
										<?php } ?>
										</select>
										</div>
							  </div>
							 
						</div>
						<div class="row">
							<div class="col-sm-3">
							 <div id="attribute-set-form-loader"></div>
							  </div>
							 
						</div>
							  
					</div> <!-- END VITAL INFO TAB -->
					<div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="nav-profile-tab">
					<div class="row">
						<div class="col-sm-3">
						 <div class="form-group">
									<label>Quantity*</label>                                    
									<input type="text" class="form-control" value="<?php echo $productData['quantity']; ?>" name="quantity" placeholder="Quantity" />
									<?php echo form_error('quantity', '<div class="error">', '</div>'); ?>
								   </div>
						  </div>
						  <div class="col-sm-3">
						 <div class="form-group">
									<label>Stock Staus</label>                                    
									<select id="select01" class="form-control" name="stock_status">
										<option value="1" <?php if($productData['stock_status'] == 1){ ?> selected="selected" <?php } ?>>In Stock</option>
										<option value="0" <?php if($productData['stock_status'] == 0){ ?> selected="selected" <?php } ?>>Out of Stock</option>
									  </select>
								   </div>
						  </div>
						 
					</div>
					
					</div><!-- END INVENTORY TAB -->
					<div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="nav-contact-tab">
						<div class="row">
						
						<div class="col-md-12">
							<div class="box box-success">                    
								<div class="box-body">
									<div class="image-loader">
										
									</div>
									<h4>Main</h4>
									
									<div class="image-upload-block" id="image-upload-block">
										<?php if($product_base_image){ ?>
										<img src="<?php echo base_url($product_base_image); ?>" width="100%" height="100%" />
										<?php } else { ?>
										<i class="fa fa-camera" aria-hidden="true"></i>
										<?php } ?>
									</div>
									<input type="file" style="display:none;" class="images" id="main_images" name="main_images">
									<button type="button" class="btn btn-primary main-upload-btn" id="main-upload-btn">Upload</button>
									<div class="main-image-delete-block" id="main-image-delete-block">
									<?php if($product_base_image){ ?>
										<i class="fa fa-trash" onClick="deleteProductImage(<?php echo $product_base_id; ?>,1)" aria-hidden="true"></i>
									<?php } ?>
									</div>
									<br />
									<br />
									<div class="row">
										<div class="col-md-2 other-img">
											<div class="image-upload-block2" id="image-upload-block2">
												<?php if(isset($product_large_image[0]['image_path'])){ ?>
												<img src="<?php echo base_url($product_large_image[0]['image_path']); ?>" width="100%" height="100%" />
												<?php } else { ?>
												<i class="fa fa-camera" aria-hidden="true"></i>
												<?php } ?>
											</div>
											<input type="file" style="display:none;" class="images" id="main_images2" name="main_images2">
											<button type="button" class="btn btn-primary main-upload-btn2" id="main-upload-btn2">Upload</button>
											<div class="main-image-delete-block2" id="main-image-delete-block2">
											<?php if(isset($product_large_image[0]['image_path'])){ ?>
												<i class="fa fa-trash" onClick="deleteProductImage(<?php echo $product_large_image[0]['id']; ?>,2)" aria-hidden="true"></i>
											<?php } ?>
											</div>
										</div>
										<div class="col-md-2 other-img">
											<div class="image-upload-block2" id="image-upload-block3">
												<?php if(isset($product_large_image[1]['image_path'])){ ?>
											<img src="<?php echo base_url($product_large_image[1]['image_path']); ?>" width="100%" height="100%" />
											<?php } else { ?>
											<i class="fa fa-camera" aria-hidden="true"></i>
											<?php } ?>
											</div>
											<input type="file" style="display:none;" class="images" id="main_images3" name="main_images3">
											<button type="button" class="btn btn-primary main-upload-btn2" id="main-upload-btn3">Upload</button>
											<div class="main-image-delete-block2" id="main-image-delete-block3">
											<?php if(isset($product_large_image[1]['image_path'])){ ?>
												<i class="fa fa-trash" onClick="deleteProductImage(<?php echo $product_large_image[1]['id']; ?>,3)" aria-hidden="true"></i>
											<?php } ?>
											</div>
										</div>
										<div class="col-md-2 other-img">
											<div class="image-upload-block2" id="image-upload-block4">
												<?php if(isset($product_large_image[2]['image_path'])){ ?>
											<img src="<?php echo base_url($product_large_image[2]['image_path']); ?>" width="100%" height="100%" />
											<?php } else { ?>
											<i class="fa fa-camera" aria-hidden="true"></i>
											<?php } ?>
											</div>
											<input type="file" style="display:none;" class="images" id="main_images4" name="main_images4">
											<button type="button" class="btn btn-primary main-upload-btn2" id="main-upload-btn4">Upload</button>
											<div class="main-image-delete-block2" id="main-image-delete-block4">
											<?php if(isset($product_large_image[2]['image_path'])){ ?>
												<i class="fa fa-trash" onClick="deleteProductImage(<?php echo $product_large_image[2]['id']; ?>,4)" aria-hidden="true"></i>
											<?php } ?>
											</div>
										</div>
										<div class="col-md-2 other-img">
											<div class="image-upload-block2" id="image-upload-block5">
												<?php if(isset($product_large_image[3]['image_path'])){ ?>
											<img src="<?php echo base_url($product_large_image[3]['image_path']); ?>" width="100%" height="100%" />
											<?php } else { ?>
											<i class="fa fa-camera" aria-hidden="true"></i>
											<?php } ?>
											</div>
											<input type="file" style="display:none;" class="images" id="main_images5" name="main_images5">
											<button type="button" class="btn btn-primary main-upload-btn2" id="main-upload-btn5">Upload</button>
											<div class="main-image-delete-block2" id="main-image-delete-block5">
											<?php if(isset($product_large_image[3]['image_path'])){ ?>
												<i class="fa fa-trash" onClick="deleteProductImage(<?php echo $product_large_image[3]['id']; ?>,5)" aria-hidden="true"></i>
											<?php } ?>
											</div>
										</div>
										<div class="col-md-2 other-img">
											<div class="image-upload-block2" id="image-upload-block6">
												<?php if(isset($product_large_image[4]['image_path'])){ ?>
											<img src="<?php echo base_url($product_large_image[4]['image_path']); ?>" width="100%" height="100%" />
											<?php } else { ?>
											<i class="fa fa-camera" aria-hidden="true"></i>
											<?php } ?>
											</div>
											<input type="file" style="display:none;" class="images" id="main_images6" name="main_images6">
											<button type="button" class="btn btn-primary main-upload-btn2" id="main-upload-btn6">Upload</button>
											<div class="main-image-delete-block2" id="main-image-delete-block6">
											<?php if(isset($product_large_image[4]['image_path'])){ ?>
												<i class="fa fa-trash" onClick="deleteProductImage(<?php echo $product_large_image[4]['id']; ?>,6)" aria-hidden="true"></i>
											<?php } ?>
											</div>
										</div>
										<div class="col-md-2 other-img">
											<div class="image-upload-block2" id="image-upload-block7">
												<?php if(isset($product_large_image[5]['image_path'])){ ?>
											<img src="<?php echo base_url($product_large_image[5]['image_path']); ?>" width="100%" height="100%" />
											<?php } else { ?>
											<i class="fa fa-camera" aria-hidden="true"></i>
											<?php } ?>
											</div>
											<input type="file" style="display:none;" class="images" id="main_images7" name="main_images7">
											<button type="button" class="btn btn-primary main-upload-btn2" id="main-upload-btn7">Upload</button>
											<div class="main-image-delete-block2" id="main-image-delete-block7">
											<?php if(isset($product_large_image[5]['image_path'])){ ?>
												<i class="fa fa-trash" onClick="deleteProductImage(<?php echo $product_large_image[5]['id']; ?>,7)" aria-hidden="true"></i>
											<?php } ?>
											</div>
										</div>
									</div>
									
								</div>
							</div>
						</div>
						</div>
					</div><!-- END IMAGES TAB -->
					<div class="tab-pane fade" id="tab-4" role="tabpanel" aria-labelledby="nav-about-tab">
						<div class="row">
						<div class="col-md-6">
							<div class="box box-success">                    
								<div class="box-body">
									<div class="form-group">
									<label>Short Description *</label>                                    
									<textarea name="short_description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $productData['short_description']; ?></textarea>
									<?php echo form_error('short_description', '<div class="error">', '</div>'); ?>
								   </div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="box box-success">                    
								<div class="box-body">
									<div class="form-group">
									<label>Description *</label>                                    
									<textarea name="description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $productData['description']; ?></textarea>
									<?php echo form_error('description', '<div class="error">', '</div>'); ?>
								   </div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="box box-success">                    
								<div class="box-body">
									<h3>Bullet Points</h3>
									<table class="table" id="instructionTbl">
										<tr>
											<td>#</td>
											<td>Description</td>
											<td></td>
										</tr>
										<?php 
										$insList = array_filter(explode('|',$productData['instruction']));
										for($i = 1; $i<=count($insList); $i++){ ?>
										<tr id="instruction_tr_<?php echo $i; ?>">
											<td><?php echo $i; ?></td>
											<td><input type="text" class="form-control" value="<?php echo $insList[$i-1]; ?>" name="instruction[]" /></td>
											<td></td>
										</tr>
										<?php } ?>
									</table>
									<button type="button" class="btn btn-primary" id="addMoreBtn">Add More</button>
								</div>
							</div>
						</div>
						</div>
					</div><!-- END DESCRIPTION TAB -->
					<div class="tab-pane fade" id="tab-5" role="tabpanel" aria-labelledby="nav-contact-tab">
						<div class="row">
							<div class="col-md-6">
							<div class="box box-success">                    
								<div class="box-body">
									
									<?php if($parent_category_list){ ?>
										<?php foreach($parent_category_list as $list){ ?>
											<div class="parent-cat">
												<input type="checkbox" name="category_id[]" <?php if(in_array($list['id'],$product_category_id)){ ?> checked="checked" <?php } ?> value="<?php echo $list['id']; ?>" id="cat_<?php echo $list['id']; ?>" />
												<label for="cat_<?php echo $list['id']; ?>"> <?php echo $list['title']; ?></label>
												<?php if(isset($list['subCat']) && $list['subCat']){ ?>
												<a data-toggle="collapse" href="#catCollapse<?php echo $list['id']; ?>" aria-expanded="false" aria-controls="catCollapse<?php echo $list['id']; ?>">
												<i class="fa fa-angle-down" aria-hidden="true"></i>
												</a>
												<?php } ?>
												
											</div>
											<?php if(isset($list['subCat']) && $list['subCat']){ ?>
												<div class="collapse" id="catCollapse<?php echo $list['id']; ?>">
												<?php foreach($list['subCat'] as $subList){ ?>
												<div class="sub-parent-cat">
													<input type="checkbox" name="category_id[]" <?php if(in_array($subList['id'],$product_category_id)){ ?> checked="checked" <?php } ?> value="<?php echo $subList['id']; ?>" id="cat_<?php echo $subList['id']; ?>" />
													<label for="cat_<?php echo $subList['id']; ?>"> <?php echo $subList['title']; ?></label>
													<?php if(isset($subList['subCat']) && $subList['subCat']){ ?>
													<a data-toggle="collapse" href="#catCollapse<?php echo $subList['id']; ?>" aria-expanded="false" aria-controls="catCollapse<?php echo $subList['id']; ?>">
													<i class="fa fa-angle-down" aria-hidden="true"></i>
													</a>
													<?php } ?>
												</div>
												<?php if(isset($subList['subCat']) && $subList['subCat']){ ?>
												<div class="collapse" id="catCollapse<?php echo $subList['id']; ?>">
													<?php foreach($subList['subCat'] as $subSubList){ ?>
													<div class="sub-sub-parent-cat">
														<input type="checkbox" name="category_id[]" <?php if(in_array($subSubList['id'],$product_category_id)){ ?> checked="checked" <?php } ?> value="<?php echo $subSubList['id']; ?>" id="cat_<?php echo $subSubList['id']; ?>" />
														<label for="cat_<?php echo $subSubList['id']; ?>"> <?php echo $subSubList['title']; ?></label>
														<?php if(isset($subSubList['subCat']) && $subSubList['subCat']){ ?>
														<a data-toggle="collapse" href="#catCollapse<?php echo $subSubList['id']; ?>" aria-expanded="false" aria-controls="catCollapse<?php echo $subSubList['id']; ?>">
														<i class="fa fa-angle-down" aria-hidden="true"></i>
														</a>
														<?php } ?>
													</div>
													<?php if(isset($subSubList['subCat']) && $subSubList['subCat']){ ?>
													<div class="collapse" id="catCollapse<?php echo $subSubList['id']; ?>">
														<?php foreach($subSubList['subCat'] as $subSubSubList){ ?>
														<div class="sub-sub-sub-parent-cat">
															<input type="checkbox" name="category_id[]" <?php if(in_array($subSubSubList['id'],$product_category_id)){ ?> checked="checked" <?php } ?> value="<?php echo $subSubSubList['id']; ?>" id="cat_<?php echo $subSubSubList['id']; ?>" />
															<label for="cat_<?php echo $subSubSubList['id']; ?>"> <?php echo $subSubSubList['title']; ?></label>
															
														</div>
														<?php } ?>
													</div>
													<?php } ?>
													<?php } ?>
												</div>
												<?php } ?>
												<?php } ?>
												</div>
											<?php } ?>
										<?php } ?>
									<?php } else { ?>
									No Category Found.
									<?php } ?>
								</div>
							</div>
						</div>
						</div>
					</div><!-- END CATEGORY TAB -->
					<div class="tab-pane fade" id="tab-6" role="tabpanel" aria-labelledby="nav-contact-tab">
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label>Start Date</label>                                    
									<input type="text" id="start_date" value="<?php echo ($productOfferData['offer_start_date'] != '' && $productOfferData['offer_start_date'] != '0000-00-00') ? date('d-m-Y',strtotime($productOfferData['offer_start_date'])) : ''; ?>" class="form-control" name="offer_start_date" placeholder="Start Date" />
									<?php echo form_error('offer_start_date', '<div class="error">', '</div>'); ?>
								   </div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>End Date</label>                                    
									<input type="text" id="end_date" class="form-control" value="<?php echo ($productOfferData['offer_end_date'] != '' && $productOfferData['offer_end_date'] != '0000-00-00') ? date('d-m-Y',strtotime($productOfferData['offer_end_date'])) : ''; ?>" name="offer_end_date" placeholder="End Date" />
									<?php echo form_error('offer_end_date', '<div class="error">', '</div>'); ?>
								   </div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Offer Code</label>                                    
									<input type="text" id="end_date" class="form-control" value="<?php echo $productOfferData['offer_code']; ?>" name="offer_code" placeholder="Offer Code" />
									<?php echo form_error('offer_code', '<div class="error">', '</div>'); ?>
								   </div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Type</label>                                    
									<select class="form-control" name="offer_type">
										<option value="1" <?php if($productOfferData['offer_type'] == 1){ ?> selected="selected" <?php } ?>>Flat</option>
										<option value="2" <?php if($productOfferData['offer_type'] == 2){ ?> selected="selected" <?php } ?>>Percentage</option>
									</select>
								   </div>
							</div>
							<div class="col-sm-3">
								 <div class="form-group">
									<label>Amount/Percentage</label>                                    
									<input type="text" class="form-control" value="<?php echo $productOfferData['offer_type_value']; ?>" name="offer_type_value" placeholder="Amount/Percentage" />
								   </div>
							</div>
							
						</div>
					</div><!-- END OFFER TAB -->
					<div class="tab-pane fade" id="tab-7" role="tabpanel" aria-labelledby="nav-contact-tab">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Meta Title</label>                                    
									<input type="text" class="form-control" value="<?php echo $productMetaData['meta_title']; ?>" name="meta_title" placeholder="Meta Title" />
									<?php echo form_error('meta_title', '<div class="error">', '</div>'); ?>
								   </div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Meta Description</label>                                    
									<textarea class="form-control" name="meta_description" rows="3"><?php echo $productMetaData['meta_description']; ?></textarea>
								   </div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Keyword</label>                                    
									<textarea class="form-control" name="meta_keyword" rows="3"><?php echo $productMetaData['meta_keyword']; ?></textarea>
								   </div>
							</div>
							
						</div>
					</div><!-- END META TAB -->
				</div> <!-- END TAB DIV -->
				
              </div>
			  </div>
			  
			  

              
          </div>
        </div>
        <div class="card shadow">
        <div class="card-header py-3 text-right">
        <button type="submit" class="btn btn-success">Submit</button>
        <button onclick="window.history.back()" type="button" class="btn btn-secondary">Cancel</button>
        </div>    
        </div>    
 <?php echo form_close(); ?>     
    </div>