<!DOCTYPE html>
<html lang="en">
<head> 
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<meta name="description" content="Creative One Page Parallax Template">
	<meta name="keywords" content="Creative, Onepage, Parallax, HTML5, Bootstrap, Popular, custom, personal, portfolio" /> 
	<meta name="author" content=""> 
	<title>Auto Makler</title> 
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/prettyPhoto.css" rel="stylesheet"> 
	<link href="/css/font-awesome.min.css" rel="stylesheet"> 
	<link href="/css/animate.css" rel="stylesheet"> 
	<link href="/css/main.css" rel="stylesheet">
	<link href="/css/responsive.css" rel="stylesheet"> 
	<!--[if lt IE 9]> <script src="/js/html5shiv.js"></script> 
	<script src="/js/respond.min.js"></script> <![endif]--> 
	<link rel="shortcut icon" href="/images/ico/favicon.png"> 
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/images/ico/apple-touch-icon-144-precomposed.png"> 
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/images/ico/apple-touch-icon-114-precomposed.png"> 
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/images/ico/apple-touch-icon-72-precomposed.png"> 
	<link rel="apple-touch-icon-precomposed" href="/images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->
<body>
	<div class="preloader">
		<div class="preloder-wrap">
			<div class="preloder-inner"> 
				<div class="ball"></div> 
				<div class="ball"></div> 
				<div class="ball"></div> 
				<div class="ball"></div> 
				<div class="ball"></div> 
				<div class="ball"></div> 
				<div class="ball"></div>
			</div>
		</div>
	</div><!--/.preloader-->
	<header id="before_menu">
		<div class="fixed_top navbar-fixed-top">
			<div>
				<div class="container">
					<div class="row">
						<div class="col-sm-1">
							Lang
						</div>
						<div class="col-sm-3 col-sm-offset-8 text-right">
							logare
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container logo_blok">
			<div class="row">
				<div class="col-sm-4 col-xs-6">
					<a href="/">
						<img src="/images/logo_big.png">
					</a>
				</div>
				<div class="banner-top col-sm-8 col-xs-6">
					<a href="#">
						<img src="/images/banner_top.png">
					</a>
				</div>
			</div>
		</div>
	</header>
	<header id="navigation"> 
		<div class="navbar" role="banner"> 
			<div class="container"> 
				<div class="navbar-header"> 
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> 
						<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> 
					</button> 
					<a class="navbar-brand" href="index.html"><h1><img src="images/logo.png" alt="logo"></h1></a> 
				</div> 
				<div class="collapse navbar-collapse"> 
					<ul class="nav navbar-nav"> 
						<li class="active"><a href="#">Home</a></li> 
						<li class=""><a href="#-us">Anunțuri</a></li> 
						<li class=""><a href="#">Noutați</a></li> 
						<li class=""><a href="#">Promoții</a></li> 
						<li class=""><a href="#">Despre noi</a></li> 
						<li class="pull-right">
							<form method="GET" id="search-form">
								<div class="search_sup">
									<input type="text" name="q" placeholder="Cautare">
								</div>
							</form>
						</li> 
					</ul> 
				</div> 
			</div> 
		</div><!--/navbar--> 
	</header> <!--/#navigation--> 

	

	<section id="car-brends">
		<div class="container">
			<div id="brands-carousel" class="carousel slide" data-interval="false">
				<a class="member-left" href="#brands-carousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
				<a class="member-right" href="#brands-carousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
				<div class="carousel-inner team-members">
					<div class="row item active">
						<?php for ($i=0; $i < 12; $i++) { ?>
						<div class="col-sm-1 col-md-1">
							<div class="single-brand">
								<a href="#">
									<img src="/images/tesla-logo.png">
								</a>
							</div>
						</div>
						<?php } ?>
					</div>
					<div class="row item">
						<?php for ($i=0; $i < 12; $i++) { ?>
						<div class="col-sm-1 col-md-1">
							<div class="single-brand">
								<a href="#">
									<img src="/images/tesla-logo.png">
								</a>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#CARS BRENDS-->

	<section id="search-big">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 col-xs-6">
					<ul class="main-category-sup ul">
						<?php for ($i=0; $i < 6; $i++) { ?>
							<li>
								<a href="#">
									<i class="fa fa-car"></i>
									Autoturisme
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
				<div class="oferta-zilei col-sm-4 col-xs-6">
					<span class="oferta_title">
						Oferta zilei
					</span>
					<div class="oferta-img-sup">
						<div class="oferta-img-bg" style="background-image:url('/images/produs_poza.png');">
							<img src="/images/produs_poza.png" class="img-oferta">
						</div>
						<div class="promo-desc">
							<span class="p-title">
								<a href="#" class="table-cell">Porche Cayenne</a>
							</span>
							<span class="p-price">
								<span class="p-price-01 text-center">
									38 000 <span class="p-curency">EUR</span>
								</span>
							</span>
							<div class="clear"></div>
						</div>
					</div>
				</div>
				<div class="banner-top col-sm-5 col-xs-12">
					<a href="#">
						<img src="/images/banner_top.png">
					</a>
				</div>
			</div>
		</div>
	</section>







	<?php for ($i=0; $i < 25; $i++) { echo '<br>'; } ?>


	<footer id="footer"> 
		<div class="container"> 
			<div class="text-center"> 
				<p>Copyright &copy;  - <a href="http://ProWebDesign.MD">ProWebDesign.MD</a> | All Rights Reserved</p> 
			</div> 
		</div> 
	</footer> <!--/#footer--> 

	<script type="text/javascript" src="/js/jquery.js"></script> 
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/smoothscroll.js"></script> 
	<script type="text/javascript" src="/js/jquery.isotope.min.js"></script>
	<script type="text/javascript" src="/js/jquery.prettyPhoto.js"></script> 
	<script type="text/javascript" src="/js/jquery.parallax.js"></script> 
	<script type="text/javascript" src="/js/main.js"></script> 
</body>
</html>