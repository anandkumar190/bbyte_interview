<!doctype html>
<html>

<head>
	<title> Managment | <?= $title; ?> </title>
	<?php include 'layout/link.php'?>
	<style>
		.label_danger{color: red !important;}
        .validate-field{border-color: red !important;}
	</style>
</head>
<body class="leftbar-view">

<?php include 'layout/header.php'?>

<?php include 'layout/sidebar.php'?>

<section class="main-container">
	<div class="container-fluid">
<!--		<div class="page-header filled full-block light">-->
<!--			<div class="row">-->
<!--				<div class="col-md-4 col-sm-4">-->
<!--					<h2>--><?//= $title; ?><!--</h2>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
		<?php if(!empty($this->session->flashdata('message'))){ ?>
		<div class="row">
			<div class="col-sm-12" id="session-msg">
				<?php echo $this->session->flashdata('message'); ?>
			</div>
		</div>
		<?php } ?>
		<?php include $page.'.php' ?>
	</div>
	<?php include 'layout/footer.php' ?>
</section>

</body>
<?php include 'layout/script.php'?>
<?php include 'layout/modal.php'; ?>
</html>
