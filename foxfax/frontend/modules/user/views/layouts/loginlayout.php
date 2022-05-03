<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* @var $content string */

use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */

\frontend\assets\LoginAsset::register($this);

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\ActiveForm;
use frontend\modules\user\models\LoginForm;


/* @var $this \yii\web\View */
/* @var $content string */

?>


<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php echo Html::csrfMetaTags() ?>
</head>
<body>
<?php $this->beginBody() ?>

		<!-- INCLUDE THE HEADER FILE HERE -->
        <header id="header" role="header" tolerance="5" offset="700" class="navbar navbar-default navbar--white">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="header-nav__logo"> 
                        	<h1>
	                        	<a href="/" title="Vendor documents management application">
	                        		Fox Fax app &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                        		<img src="/images/logo-fox-fax.png" class="img-responsive" alt="logo">
	                        	</a> 
                        	</h1>	
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="user-signup">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-2">
                        <div class="widget">
                            <div class="widget-header">
                                <h3><i class="fa fa-user"></i> Sign in</h3>
                                <em>- Online reminder</em> 
                            </div>
                            <div class="widget-content" style="padding: 1.2em;">
                            		


                            		<?php 
										echo $content; 
									?>



                            </div>
                            <!--/.widget-content-->
                        </div>
                        <!--/.widget-->
                        <!--/.signupform-free--> 
                    </div>
                </div>
            </div>
            <!--container-->   
        </div>



        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="footerleft_content">
                            <p>Powered by: <a href="https://relaxat.ca" target="_blank">relaxat.ca</a></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="social_media">
                            <li class="twitter">
                                <a title="Twitter" href="#" target="_blank" class="icon-twitter">
                                    <i class="fa fa-twitter"></i>
                                    <span>Follow Us On Twitter</span>
                                </a>
                            </li>
                            <li class="facebook">
                                <a title="Facebook" href="#" target="_blank" class="icon-facebook">
                                    <i class="fa fa-facebook"></i>
                                    <span>Follow Us On FaceBook</span>
                                </a>
                            </li>
                            <li class="linkedin">
                                <a title="Linkedin" href="#" target="_blank" class="icon-flickr">
                                    <i class="fa fa-linkedin"></i>
                                    <span>Follow Us On Linked In</span>
                                </a>
                            </li>
                            <li class="gplus">
                                <a title="Google +" href=" #" rel="publisher" target="_blank" class="icon-gplus">
                                    <i class="fa fa-google-plus"></i>
                                    <span>Follow Us On Google+</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/.container-->
        </footer>

        





<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
