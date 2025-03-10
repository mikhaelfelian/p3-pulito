<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta http-equiv="refresh" content="900">
        <meta name="author" content="">
        <link href='<?php echo 'http://'.$_SERVER['HTTP_HOST'] ?>/favicon.ico' rel='icon' type='image/x-icon'/>
        
        <?php $setting = $this->db->query("SELECT * FROM tbl_pengaturan")->row() ?>
        
        <title><?php echo $setting->judul ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo base_url('assets/theme/sb-admin') ?>/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="<?php echo base_url('assets/theme/sb-admin') ?>/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="<?php echo base_url('assets/theme/sb-admin') ?>/dist/css/timeline.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?php echo base_url('assets/theme/sb-admin') ?>/dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="<?php echo base_url('assets/theme/sb-admin') ?>/morrisjs/morris.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?php echo base_url('assets/theme/sb-admin') ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="wrapper">