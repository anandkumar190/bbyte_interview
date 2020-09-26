<section class="page-header page-header-text-light bg-primary">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1>Recharge History</h1>
      </div>
      <div class="col-md-4">
        <ul class="breadcrumb justify-content-start justify-content-md-end mb-0">
          <li><a href="{site_url}home">Home</a></li>
		  <li class="active">Order History</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- Page Header end --> 

<!-- Content
============================================= -->
<div id="content">
  <div class="container">
  <?php $this->load->view('front/layout/wallet-column' , true); ?>
    
		
    <div class="row pt-md-3 mt-md-5">
		
      <?php $this->load->view('front/layout/member-left-bar' , true); ?>
      <div class="col-lg-9">
        <div class="bg-light shadow-md rounded p-4"> 
          <!-- Orders History
          ============================================= -->
          <h4 class="mb-3">Orders History</h4>
          <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            <li class="nav-item"> <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="true">Orders</a> </li>
            
            <li class="nav-item"> <a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="true">Open orders</a> </li>
            
            <li class="nav-item"> <a class="nav-link" id="third-tab" data-toggle="tab" href="#third" role="tab" aria-controls="third" aria-selected="true">Cancelled Orders</a> </li>

            </ul>
          <div class="tab-content my-3" id="myTabContent">
            <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
          
           
          <?php if($orderData){ ?>
          <?php foreach($orderData as $list){ ?>
          

           <div class="col-sm-12" style="border: 1px solid #7b8084; padding: 10px; margin-top: 30px;">

            <div class="row">
            <div class="col-sm-3">
            <b>ORDER PLACED</b> 
            </div>

            <div class="col-sm-3">
            <b>TOTAL</b>
            </div>

            <div class="col-sm-3">
            <b>SHIP TO</b>
            </div>


            <div class="col-sm-3 text-right">
            <b>ORDER # <?php echo $list['order_display_id']; ?></b>
            </div>

          </div>


          <div class="row">

            <div class="col-sm-3">
            <?php echo date('d M, Y',strtotime($list['created'])); ?>
            </div>

            <div class="col-sm-3">
            <i class="fa fa-inr"></i> <?php echo number_format($list['total_price'],2); ?>
            </div>

            <div class="col-sm-3">
            <a href="#" data-html="true"  title="<left><?php echo $list['add_name']; ?> <br />
<?php echo $list['address_1']; ?> <br />
<?php echo $list['address_2']; ?><br />
<?php echo $list['city']; ?>, <?php echo $list['country_name']; ?> <br />
Phone: <?php echo $list['phone_number']; ?></left>"><?php echo $list['add_name']; ?></a>
            </div>


            <div class="col-sm-3 text-right">
            <a href="{site_url}member/orders/detail/<?php echo $list['encoded_order_id']; ?>">Order Details</a> 
            </div>

          </div>

          </div>            
          


          <div class="col-sm-12" style="border: 1px solid #7b8084; padding: 10px;">  
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
          <div class="col-sm-12" style="border: 1px solid #7b8084; padding: 10px;">

           <div class="row"> 
            
          <div class="col-sm-2">
            <a href="{site_url}product/detail/<?php echo $proList['slug']; ?>"><img src="<?php echo base_url($proList['product_img']); ?>" alt="img"></a>
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

          </div>

          <?php } ?>
          <?php } ?>  
           

          <?php } ?>
        <?php } else { ?>

        <div class="col-sm-12">
        <h4>We aren't finding any orders</h4>  
        </div>  
        
        <?php } ?>  


         
            </div>
        



          <div class="tab-pane fade show" id="second" role="tabpanel" aria-labelledby="second-tab">
          
           
          <?php if($openorderData){ ?>
          <?php foreach($openorderData as $list){ ?>
          

           <div class="col-sm-12" style="border: 1px solid #7b8084; padding: 10px; margin-top: 30px;">

            <div class="row">
            <div class="col-sm-3">
            <b>ORDER PLACED</b> 
            </div>

            <div class="col-sm-3">
            <b>TOTAL</b>
            </div>

            <div class="col-sm-3">
            <b>SHIP TO</b>
            </div>


            <div class="col-sm-3 text-right">
            <b>ORDER # <?php echo $list['order_display_id']; ?></b>
            </div>

          </div>


          <div class="row">

            <div class="col-sm-3">
            <?php echo date('d M, Y',strtotime($list['created'])); ?>
            </div>

            <div class="col-sm-3">
            <i class="fa fa-inr"></i> <?php echo number_format($list['total_price'],2); ?>
            </div>

            <div class="col-sm-3">
            <a href="#" data-html="true"  title="<left><?php echo $list['add_name']; ?> <br />
<?php echo $list['address_1']; ?> <br />
<?php echo $list['address_2']; ?><br />
<?php echo $list['city']; ?>, <?php echo $list['country_name']; ?> <br />
Phone: <?php echo $list['phone_number']; ?></left>"><?php echo $list['add_name']; ?></a>
            </div>


            <div class="col-sm-3 text-right">
            <a href="{site_url}member/orders/detail/<?php echo $list['encoded_order_id']; ?>">Order Details</a> 
            </div>

          </div>

          </div>            
          


          <div class="col-sm-12" style="border: 1px solid #7b8084; padding: 10px;">  
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
          <div class="col-sm-12" style="border: 1px solid #7b8084; padding: 10px;">

           <div class="row"> 
            
          <div class="col-sm-2">
            <a href="{site_url}product/detail/<?php echo $proList['slug']; ?>"><img src="<?php echo base_url($proList['product_img']); ?>" alt="img"></a>
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

          </div>

          <?php } ?>
          <?php } ?>  
           

          <?php } ?>
        <?php } else { ?>

        <div class="col-sm-12">
        <h4>We aren't finding any orders</h4>  
        </div>  
        
        <?php } ?>  


         
            </div>




          <div class="tab-pane fade show" id="third" role="tabpanel" aria-labelledby="third-tab">
          
           
          <?php if($cancellorderData){ ?>
          <?php foreach($cancellorderData as $list){ ?>
          

           <div class="col-sm-12" style="border: 1px solid #7b8084; padding: 10px; margin-top: 30px;">

            <div class="row">
            <div class="col-sm-3">
            <b>ORDER PLACED</b> 
            </div>

            <div class="col-sm-3">
            <b>TOTAL</b>
            </div>

            <div class="col-sm-3">
            <b>SHIP TO</b>
            </div>


            <div class="col-sm-3 text-right">
            <b>ORDER # <?php echo $list['order_display_id']; ?></b>
            </div>

          </div>


          <div class="row">

            <div class="col-sm-3">
            <?php echo date('d M, Y',strtotime($list['created'])); ?>
            </div>

            <div class="col-sm-3">
            <i class="fa fa-inr"></i> <?php echo number_format($list['total_price'],2); ?>
            </div>

            <div class="col-sm-3">
            <a href="#" data-html="true"  title="<left><?php echo $list['add_name']; ?> <br />
<?php echo $list['address_1']; ?> <br />
<?php echo $list['address_2']; ?><br />
<?php echo $list['city']; ?>, <?php echo $list['country_name']; ?> <br />
Phone: <?php echo $list['phone_number']; ?></left>"><?php echo $list['add_name']; ?></a>
            </div>


            <div class="col-sm-3 text-right">
            <a href="{site_url}member/orders/detail/<?php echo $list['encoded_order_id']; ?>">Order Details</a> 
            </div>

          </div>

          </div>            
          


          <div class="col-sm-12" style="border: 1px solid #7b8084; padding: 10px;">  
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
          <div class="col-sm-12" style="border: 1px solid #7b8084; padding: 10px;">

           <div class="row"> 
            
          <div class="col-sm-2">
            <a href="{site_url}product/detail/<?php echo $proList['slug']; ?>"><img src="<?php echo base_url($proList['product_img']); ?>" alt="img"></a>
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

          </div>

          <?php } ?>
          <?php } ?>  
           

          <?php } ?>
        <?php } else { ?>

        <div class="col-sm-12">
        <h4>We aren't finding any orders</h4>  
        </div>  
        
        <?php } ?>  


         
            </div>  





            </div>    

          <!-- Orders History end --> 
        </div>
      </div>
    </div>
  </div>
  <!-- Content end --> 
