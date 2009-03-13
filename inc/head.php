<?php
if ($_SERVER['REQUEST_URI'] != "/pdx/" && $_SERVER['REQUEST_URI'] != "/aus/"){
	if (!isset($_SESSION)) {
		session_start();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Shizzeeps: Where Are They?</title>
	
	<link rel="shortcut icon" href="favicon.ico" /> 

   <link href="/css/reset.css" rel="stylesheet" type="text/css" />
   <link href="/css/styles.css" rel="stylesheet" type="text/css" />

   <style type='text/css'>@import url('http://s3.amazonaws.com/getsatisfaction.com/feedback/feedback.css');</style>

   
	<script type="text/javascript" src="/js/jquery-1.3.1.min.js"></script>
	
	
	
	<?php if ($_SERVER['REQUEST_URI'] == "/") { ?>
   	<script type="text/javascript" src="/js/core.js"></script>
   <?php } ?>
   
   <script type="text/javascript" src="/js/aux.js"></script>
   <script type="text/javascript" src="/js/timer.js"></script>
   <script type="text/javascript" src="/js/cookie.js"></script>
</head>


<body class="oneColFixCtr">

<a href="/"><div id="home-link"></div></a>

<div id="header">
	<h1>Shizzeeps: Where Are They?</h1>
</div>

<div class="corners" id="container">


<!-- ! Secondary Links -->
<div id="secondary-links">
	<a href="/about/">About</a>
	<a href="http://shizzow.com" target="_blank">Shizzow</a>
	<a href="http://twitter.com/shizzeeps" target="_blank">Twitter</a>
	<a href="http://getsatisfaction.com/shizzeeps" target="_blank">Feedback</a>
	<!-- <a href="/blog/">Blog</a> -->
</div>