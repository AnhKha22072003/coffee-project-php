<?php
 require "../includes/header.php";
?>
<?php
 if (isset($_GET['id'])) {

	$id      = $_GET['id'];
	$query   = $conn->query("SELECT * FROM products WHERE id=$id");
	$product = $query->fetch(PDO::FETCH_OBJ);

	$relatedProducts = $conn->query("SELECT * FROM products WHERE type='$product->type' AND id != $id LIMIT 4");
	$relatedProducts = $relatedProducts->fetchAll(PDO::FETCH_OBJ);

	// $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart']) : [];
	if(isset($_POST['submit']) && isset($_SESSION['user_id']))
	{
		$product_id = $_POST['id'];
		$size     = $_POST['size'];
		$quantity = $_POST['quantity'];
		
		if(isset($cart[$product_id]))
		{
			$cart[$id]["quantity"] += 1;
		}else {
			$cart[$product_id] = [
				"product_id" => $product_id,
				"size"     => $size,
				"quantity" => $quantity
			];
		}
		
		// header("Location: " . BASE_URL . "cart.php");
		setcookie('cart', json_encode($cart), time() + (86400 * 30), "/");

		header("Location: " . BASE_URL . "products/product-single.php?id=" . $id);
	}
 } else {
 	header("Location: " . BASE_URL . "");
 }
?>

<section class="home-slider owl-carousel">

	<div class="slider-item" style="background-image: url(<?php echo BASE_URL ?>/images/<?php echo $product->image ?>);" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row slider-text justify-content-center align-items-center">

				<div class="col-md-7 col-sm-12 text-center ftco-animate">
					<h1 class="mb-3 mt-5 bread">Product Detail</h1>
					<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Product Detail</span></p>
				</div>

			</div>
		</div>
	</div>
</section>

<section class="ftco-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 mb-5 ftco-animate">
				<a href="<?php echo BASE_URL ?>/images/<?php echo $product->image ?>" class="image-popup"><img src="<?php echo BASE_URL ?>/images/<?php echo $product->image ?>" class="img-fluid" alt="Colorlib Template"></a>
			</div>
			<div class="col-lg-6 product-details pl-md-5 ftco-animate">
				<h3><?php echo $product->name ?></h3>
				<p class="price"><span>$<?php echo $product->price ?></span></p>
				<p><?php echo $product->description ?></p>
				<form method="post" action="<?php echo BASE_URL ."products/product-single.php?id=" . $id?>">
					<input type="text" name="id" value="<?php echo $id ?>" hidden>
					<div class="row mt-4">
						<div class="col-md-6">
							<div class="form-group d-flex">
								<div class="select-wrap">
									<div class="icon"><span class="ion-ios-arrow-down"></span></div>
									<select name="size"  class="form-control">
										<option value="m">Small</option>
										<option value="s">Medium</option>
										<option value="xs">Large</option>
										<option value="l">Extra Large</option>
									</select>
								</div>
							</div>
						</div>
						<div class="w-100"></div>
						<div class="input-group col-md-6 d-flex mb-3">
							<span class="input-group-btn mr-2">
								<button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
									<i class="icon-minus"></i>
								</button>
							</span>
							<input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">
							<span class="input-group-btn ml-2">
								<button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
									<i class="icon-plus"></i>
								</button>
							</span>
						</div>
					</div>
					<button type="submit" name="submit" class="btn btn-primary py-3 px-5">Add to Cart</button>
				</form>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center mb-5 pb-3">
			<div class="col-md-7 heading-section ftco-animate text-center">
				<span class="subheading">Discover</span>
				<h2 class="mb-4">Related products</h2>
				<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
			</div>
		</div>
		<div class="row">
		<?php foreach($relatedProducts as $product): ?>
			<div class="col-md-3">
				<div class="menu-entry">
					<a href="<?php echo BASE_URL ?>/products/<?php echo $product->id ?>" class="img" style="background-image: url(<?php echo BASE_URL ?>/images/<?php echo $product->image ?>);"></a>
					<div class="text text-center pt-4">
						<h3><a href="<?php echo BASE_URL ?>/products/<?php echo $product->id ?>"><?php echo $product->name ?>"</a></h3>
						<p><?php echo $product->description ?>"</p>
						<p class="price"><span>$<?php echo $product->price ?></span></p>
						<p><a href="<?php echo BASE_URL ?>/products/<?php echo $product->id ?>" class="btn btn-primary btn-outline-primary">Show</a></p>
					</div>
				</div>
			</div>
		<?php endforeach ?>
		</div>
	</div>
</section>

<?php
require "../includes/footer.php";
?>
