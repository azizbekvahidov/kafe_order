<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" >
	<meta name="language" content="en"/><meta name="viewport" content="width=device-width, initial-scale=no">

	<!-- blueprint CSS framework -->
	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print"/>
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>-->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/chosen.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/keyboard.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/helping.css " />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/vKey.css " />
    <!-- Font Awesome -->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/gentella/font-awesome/css/font-awesome.min.css" rel="stylesheet">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap3.css"/>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/gentella/custom.css" rel="stylesheet">
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/gentella/jquery.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/gentella/jquery.printPage.js"></script>

  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/chosen.jquery.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/keyboard.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/mainKeyboard.js" type="text/javascript"></script>

</head>

<body class="wood">
    <div id="page">

        	<?php echo $content; ?>



        	<!--<div id="footer">
        		Copyright &copy; <?php echo date('Y'); ?> by Azizbek.<br/>
        		Все права защищены.<br/>
        		<?php echo Yii::powered(); ?>
        	</div><!-- footer -->
        </div>
</div><!-- page -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.js"></script>
<!--    <script src="--><?php //echo Yii::app()->request->baseUrl; ?><!--/js/metisMenu.min.js"></script>-->
<!--    <script src="--><?php //echo Yii::app()->request->baseUrl; ?><!--/js/sb-admin-2.js"></script>-->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jQuerySession.js"></script>

</body>
</html>
