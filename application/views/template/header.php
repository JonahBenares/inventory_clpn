<?php 
if (isset($this->session->userdata['logged_in'])) {
	$username = ($this->session->userdata['logged_in']['username']);
	$password = ($this->session->userdata['logged_in']['password']);
} else {
	echo "<script>alert('You are not logged in. Please login to continue.'); 
		window.location ='".base_url()."index.php/masterfile/index'; </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Inventory System - Warehouse
	</title>
	<link href="<?php echo base_url(); ?>assets/default/wislogo.png" rel="icon">
	<link href="<?php echo base_url(); ?>assets/Styles/bootstrap.min.css" rel="stylesheet">	
	<link href="<?php echo base_url(); ?>assets/Styles/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/Styles/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/Styles/datepicker3.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/Styles/styles.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/Styles/custom.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/Styles/jquery.dataTables.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/Styles/animation.css" rel="stylesheet">
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<style type="text/css">	

	
	/*---------SCROLL-----------*/
		/* width */
	::-webkit-scrollbar {
	    width: 7px;
	}
	::-moz-scrollbar {
	    width: 7px;
	}

	/* Track */
	::-webkit-scrollbar-track {
	    background: #fff0; 
	}
	::-moz-scrollbar-track {
	    background: #fff0; 
	}
	 
	/* Handle */
	::-webkit-scrollbar-thumb {
	    border-radius: 50px 50px 50px 50px;
	    background: #888;
	}

	/* Handle on hover */
	::-webkit-scrollbar-thumb:hover {
	    background: #ff7c3e; 
	}

	.btn-gold{
		background: rgba(246,41,12,1);
		background: -webkit-linear-gradient(bottom left, rgba(246,41,12,1) 0%, rgba(240,47,23,1) 11%, rgba(231,56,39,1) 25%, rgba(248,80,50,1) 45%, rgba(241,111,92,1) 100%);
		background: -o-linear-gradient(bottom left, rgba(246,41,12,1) 0%, rgba(240,47,23,1) 11%, rgba(231,56,39,1) 25%, rgba(248,80,50,1) 45%, rgba(241,111,92,1) 100%);
		background: linear-gradient(to top right, rgba(246,41,12,1) 0%, rgba(240,47,23,1) 11%, rgba(231,56,39,1) 25%, rgba(248,80,50,1) 45%, rgba(241,111,92,1) 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f6290c', endColorstr='#f16f5c', GradientType=1 );
		border:1px solid white; 
		color: #fff;
	}

	.btn-gold:hover{
		border:1px solid white; 
		color: #fff;
	}
	/* width */
	.alert-warning{
		border:1px solid #bd9f62
	}

	/*.sidebar ul {
  	margin: 0px 0px!important; }*/

  	.banner{
  		background: linear-gradient(to right,  #fda085 0%, #f9e8b4 51%, #fda085 100%);
  		background-size: 1000% 1000%;
  		box-shadow: 0px 0px 0px 3px #858484;
  		height:100px; 
  		margin-bottom: 0px;
		-webkit-animation: AnimationName 4s ease infinite;
		-moz-animation: AnimationName 4s ease infinite;
		animation: AnimationName 4s ease infinite;
	}

	@-webkit-keyframes AnimationName {
	    0%{background-position:0% 50%}
	    50%{background-position:100% 51%}
	    100%{background-position:0% 50%}
	}	
	@-moz-keyframes AnimationName {
	    0%{background-position:0% 50%}
	    50%{background-position:100% 51%}
	    100%{background-position:0% 50%}
	}
	@keyframes AnimationName { 
	    0%{background-position:0% 50%}
	    50%{background-position:100% 51%}
	    100%{background-position:0% 50%}
	}
  	
  	div.moving-obj{
  		font-size: 15px;  		
  		position: relative;
  		padding: 7px 0px 1px;
    	animation: mymove 10s infinite;
  	}

	@keyframes mymove {
	    from {left: 100%;}
	    to {left: 230px;}
	}
  	.font-truck{
  		font-size: 25px; 
  		transform: scaleX(-1);
  	}

	/*---------SCROLL-----------*/

	.search-btn{
		background-image: linear-gradient(to right, #e86b46 0%, #ffc100 51%, #f7501f 100%);
	    border-bottom: 1px solid #e9ecf2;
	    transition: 0.5s;
		background-size: 200% auto;
		color: #fff;
		font-weight: 600;
		width: 100%;
	}

	.search-btn:hover{
		background-position: right center; /* change the direction of the change here */
	}

	.panel-login{
		color: white;
	    background: #ff9d0069;
	    border: 10px solid #ff9d0000;
	    box-shadow: -7px 10px 19px 0px #29292982;
	    border-radius: 1px 50px 1px 50px;
	    transition: 0.5s;
	}

	.panel-login:hover{
	    border: 0;
	    color: white;
	    background: #ff9d00;
	    border: 10px solid #ffbe48;
	    box-shadow: 0px 0px 50px 5px #ffb53e9e;
	   	border-radius: 50px 1px 50px 1px;
	   	transition: 0.5s;
	}

	.h3-login{
		color: white;
	}

	.modbod{
		border: 5px solid orange ;
		
	}

	.modal-content, .modbod {
		border-radius:15px;
	}

	.td-sclass{
		padding-bottom: 5px;
	}

	input.form-control {
	    border: 1px solid #ddd;
	    box-shadow: none;
	    height: 35px;
	}

	input.form-control-login {
	    border: 1px solid #ddd;
	    box-shadow: none;
	    height: 50px;
	    font-size: 20px;
	}

	.arrow-bottom{
		content: "";
	    position: absolute;
	    top: -5%;
	    left: 93%;
	    transform: rotate(180deg);
	    margin-left: -5px;
	    border-width: 5px;
	    border-style: solid;
	    border-color: #fff transparent transparent transparent;
	}

	.sidebar ul.nav a:hover, .sidebar ul.nav li.parent ul li a:hover {
	    text-decoration: none;
	    background-color: #dc6b37;
	    color: #fff;
	    box-shadow: inset 1px 1px 15px 1px #9e451e;
	}

	.shadow{
		box-shadow: 0px 1px 20px 0px #bcbcbc99;
	}
	.shadow-two{
		box-shadow: 0px 4px 9px 0px #00000099;
	}
	.shadow-white{
		box-shadow: 0px 4px 9px 0px #fff;
	}

	.navbar-header .navbar-brand span {
    color: #ff7c3e;
	}

	.tooltiptext {
	    visibility: hidden;
	    position: absolute;
	    width: 120px;
	    background-color: #555;
	    color: #fff;
	    text-align: center;
	    padding: 5px 0;
	    border-radius: 6px;
	    z-index: 1;
	    opacity: 0;
	    transition: opacity 0.3s;
	    top: 140%;
	    right: 10%;
	}
	.tooltiptext::after {
	    content: "";
	    position: absolute;
	    bottom: 100%;
	    left: 85%;
	    transform: rotate(-180deg);
	    margin-left: -5px;
	    border-width: 5px;
	    border-style: solid;
	    border-color: #555 transparent transparent transparent;
	}

	
	/*----------------Rack BUTTON--------------------*/
	.category{
		background-color: rgba(223, 255, 84, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	}
	.category a{
		color: white;
	}
	.category:hover{
		background-color: rgb(223, 255, 84);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    box-shadow: 0px 1px 20px 0px #fbff87;

	}
	.category:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	    
	}	
	/*----------------Rack BUTTON--------------------*/

	/*----------------UOM BUTTON--------------------*/
	.supplier{
		background-color: rgba(255, 236, 44, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	}
	.supplier a{
		color: white;
	}
	.supplier:hover{
		background-color: rgb(255, 236, 44);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    box-shadow: 0px 1px 20px 0px #fbff87;

	}
	.supplier:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	    
	}	
	/*----------------UOM BUTTON--------------------*/

	/*----------------SUPPLIER BUTTON--------------------*/
	.employees{
		background-color: rgb(249, 36, 63, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	}
	.employees a{
		color: white;
	}
	.employees:hover{
		background-color: rgb(249, 36, 63);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    box-shadow: 0px 1px 20px 0px #ff8787;

	}
	.employees:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	    
	}	
	/*----------------SUPPLIER BUTTON--------------------*/

	/*----------------category BUTTON--------------------*/
	.subcategory{
		background-color: rgb(249, 130, 36, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    
	}
	.subcategory a{
		color: white;
	}
	.subcategory:hover{
		background-color: rgb(249, 130, 36);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
		box-shadow: 0px 1px 20px 0px #c19246;
	}
	.subcategory:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	/*----------------category BUTTON--------------------*/

	/*----------------SUB category BUTTON--------------------*/
	
	.uom{
		background-color: rgb(255, 181, 62, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    
	}
	.uom a{
		color: white;
	}
	.uom:hover{
		background-color: rgb(255, 181, 62);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
		box-shadow: 0px 1px 20px 0px #c19246;
	}
	.uom:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	/*----------------SUB category BUTTON--------------------*/
	
	/*----------------End_use BUTTON--------------------*/
	
	.purpose{
		background-color:rgba(249, 36, 208, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	}
	.purpose a{
		color: white;
	}
	.purpose:hover{
		background-color:rgba(249, 36, 208);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
		box-shadow: 0px 1px 20px 0px #fd65ff;
	}
	.purpose:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	/*----------------End_use BUTTON--------------------*/





	/*----------------End_use BUTTON--------------------*/
	
	.enduse{
		background-color:rgba(153, 36, 249, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    
	}
	.enduse a{
		color: white;
	}
	.enduse:hover{
		background-color:rgba(153, 36, 249);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
		box-shadow: 0px 1px 20px 0px #ba65ff;
	}
	.enduse:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	/*----------------End_use BUTTON--------------------*/

	/*----------------Purpose BUTTON--------------------*/
	
	.warehouse{
		background-color:rgba(36, 37, 249, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    
	}
	.warehouse a{
		color: white;
	}
	.warehouse:hover{
		background-color:rgba(36, 37, 249);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
		box-shadow: 0px 1px 20px 0px #6e65ff;
	}
	.warehouse:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	/*----------------Purpose BUTTON--------------------*/

	/*----------------Warehouse BUTTON--------------------*/
	
	.location{
		background-color:rgba(36, 155, 249, .45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    
	}
	.location a{
		color: white;
	}
	.location:hover{
		background-color:rgba(36, 155, 249);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
		box-shadow: 0px 1px 20px 0px #249bf9;
	}
	.location:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	/*----------------Warehouse BUTTON--------------------*/

	/*----------------Location BUTTON--------------------*/
	
	.rack{
		background-color:rgba(50, 212, 255, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    
	}
	.rack a{
		color: white;
	}
	.rack:hover{
		background-color:rgba(50, 212, 255);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
		box-shadow: 0px 1px 20px 0px #249bf9;
	}
	.rack:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	/*----------------Location BUTTON--------------------*/

	/*----------------Department BUTTON--------------------*/
	
	.department{
		background-color :rgb(37, 197, 157, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    
	}
	.department a{
		color: white;
	}
	.department:hover{
		background-color:rgba(37, 197, 157);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
		box-shadow: 0px 1px 20px 0px #25c59d;
	}
	.department:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	/*----------------Department BUTTON--------------------*/
	/*----------------Department BUTTON--------------------*/
	
	.signatories{
		background-color :rgba(37, 197, 99, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;	    
	}
	.signatories a{
		color: white;
	}
	.signatories:hover{
		background-color:rgba(37, 197, 99);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    box-shadow: 0px 1px 20px 0px #25c560;
	}
	.signatories:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	/*----------------Department BUTTON--------------------*/

	/*----------------Brand BUTTON--------------------*/
	
	.brand{
		background-color:rgba(73, 197, 37, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;	    		
	}
	.brand a{
		color: white;
	}
	.brand:hover{
		background-color:rgba(73, 197, 37);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    box-shadow: 0px 1px 20px 0px #49c525;
	}
	.brand:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	/*----------------Brand BUTTON--------------------*/


	/*----------------Users BUTTON--------------------*/
	
	.user{
		background-color:rgba(165, 255, 15, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;	    		
	}
	.user a{
		color: white;
	}
	.user:hover{
		background-color:rgba(165, 255, 15);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    box-shadow: 0px 1px 20px 0px #49c525;
	}
	.user:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	/*----------------Users BUTTON--------------------*/

	/*----------------settings BUTTON--------------------*/
	
	.setting{
		background-image: linear-gradient(to right, #ff3900 10%, #ffc100 50%, #ff3900 100%);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;	    
	    border-radius: 50%;	    
	    transition: 0.5s;	
	    background-size: 200% auto;
	}
	.setting a{
		color: white;
	}
	.setting-name{
		color: #555!important;
		padding: 0px 20px 0px 20px;
		transition: 1s;
	}
	.setting-name:hover{
		text-decoration: none;
		padding: 0px 50px 0px 50px;
	}

	.set:hover{
	    background-position: right center;	    
	    box-shadow: 0px 1px 20px 0px #ff8900;
	}
	.setting:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	.divider-side{
		border-left:1px solid #606060;
		float: left;
		margin: 10px 8px;
		padding: 0px;
		height: 40px;
	}

	/*.setting-hover{
		padding: 5px 10px!important;
		transition: 1s;
	}
	.setting-hover:hover{
		padding: 10px 15px!important;
	}*/
	/*----------------settings BUTTON--------------------*/

	.panel-settings, .panel-toggle {
	    display: inline-block;
	    margin: -1px -5px 0 15px !important;
	    border-radius: 4px;
	    text-align: center;
	    border: 0px solid #e9ecf2;
	    color: #ffffff;
	    background: rgb(49, 49, 49);
	    width: 42px;
	    transition: 0.5s;
	    font-weight: bold;
	}
	.panel-settings, .panel-toggle:hover {
		box-shadow: 0px 4px 9px 0px #00000099;
	}

	.panel-default .panel-heading {
	    background-image: linear-gradient(to right, #fda085 0%, #f9e8b4 51%, #fda085 100%);
	    border-bottom: 1px solid #e9ecf2;
	    transition: 0.5s;
		background-size: 200% auto;
		color: #555;
		font-weight: 600;
	}

	.panel-default .panel-heading-danger {
	    background-image: linear-gradient(to right, #f55a5a 0%, #de2c2c 51%, #fd6d6d 100%);;
	    border-bottom: 1px solid #e9ecf2;
	    transition: 0.5s;
	    background-size: 200% auto;
	    color: #fff;
	    font-weight: 600;
	}

	.panel-default .panel-heading:hover {
	  	background-position: right center; /* change the direction of the change here */
	}

	.panel-default .panel-heading-update {
	    background-image: linear-gradient(to right, #a1c4fd 0%, #c2e9fb 51%, #a1c4fd 100%);
	    border-bottom: 1px solid #e9ecf2;
	    transition: 0.5s;
		background-size: 200% auto;
		color: #555;
		font-weight: 600;
	}

	.panel-default .panel-heading-update:hover {
	  	background-position: right center; /* change the direction of the change here */
	}

	.panel-default .panel-heading-view {
	    background-image: linear-gradient(to right, #84fab0 0%, #8fd3f4 51%, #84fab0 100%);
	    border-bottom: 1px solid #e9ecf2;
	    transition: 0.5s;
		background-size: 200% auto;
		color: #555;
		font-weight: 600;
	}

	.panel-default .panel-heading-view:hover {
	  	background-position: right center; /* change the direction of the change here */
	}

	/*-------------------------------------------------------------------*/
	/*Dtatables*/

	div.dataTables_wrapper div.dataTables_filter input {
	    margin-left: 0.5em;
	    display: inline-block;
	    width: auto;
	    border: 1px solid #ddd;
	    box-shadow: none;
	    height: 30px;
	    border-radius: 5px;
	}
	div.dataTables_wrapper div.dataTables_length select {
	    border: 1px solid #ddd;
	    box-shadow: none;
	    height: 30px;
	    border-radius: 5px;
	}
	thead{
		background: #eaeaea;
	}

	/*-----------------------------------------------------*/
	/*Modal-Background*/

	.modal-headback{
		background-image: linear-gradient(to right, #fda085 0%, #f9e8b4 51%, #fda085 100%);
		border-bottom: 1px solid #e9ecf2;
	    transition: 0.5s;
		background-size: 200% auto;
		color: #555;
		font-weight: 600;
	}
	.modal-headback:hover{
		background-position: right center;
	}


	/*--------------------------------------------------------*/

	/*----------------------------UPLOAD IMAGE-------------------------------*/
	.border-class{
		margin-top: 10px;
		padding: 15px 0px 10px 0px;
		border: 3px solid #ffe3af;
		border-radius:10px;
	}
	
	.pborder-top{
		padding-top: 3px; 
		border-top: 1px solid #888; 
	}
	.pborder-bottom{
		padding-top: 3px; 
		border-bottom: 1px solid #888; 
	}
	.pname{
		font: bold 20px Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; 		
		color:orange;
	}
	.main_cat{
		color: #a94f0d;
		font-weight: 700;
	}
	.pictures{
		max-width:100%;
	}


	.pname2{
		font: bold Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; 		
		color:orange;
	}
	/*-----------------------------------------------------------------------------*/

	/*0-----------------------------------SEARCH BOX--------------------------------*/
	#name-type{
		float:left;
		list-style:none;
		margin-top:-3px;
		padding:0;
		width:93%;
		position: absolute;
		z-index:100;
	}
	#name-type li:hover {
	    cursor: pointer;
	    font-weight: bold;
	    color: black;
	    text-transform: uppercase;
	    background-position: right center;	    
	    box-shadow: 0px 1px 20px 0px #ff8900;
	}
	#name-type li {
	    padding:5px 10px 5px 10px;
	    background-image: linear-gradient(to right, #fbb39e 10%, #fff1c4 50%, #fbb39e 100%);
	    border-bottom: #a88748 2px solid;
	    border-radius: 5px;
	    transition: 0.5s;	
	    background-size: 200% auto;
	}
	#search-type{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}

	/*0-----------------------------------SEARCH BOX--------------------------------*/

	/*--------------------------LOGIN PAGE-----------------------------------*/
	.body-login{
		background: radial-gradient(#696969, #444444, #2d2d2d);
		background-repeat: no-repeat;
		height: 100vmin;
		
	}
	.alert-shake{
		-webkit-animation-name: spaceboots;
		-webkit-animation-duration: 0.8s;
		-webkit-transform-origin:50% 50%;
		-webkit-animation-iteration-count: 1;
		-webkit-animation-timing-function: linear;
	}
	@-webkit-keyframes spaceboots {
		10%, 90% {
	    transform: translate3d(-1px, 0, 0);
	  }
	  
	  20%, 80% {
	    transform: translate3d(2px, 0, 0);
	  }

	  30%, 50%, 70% {
	    transform: translate3d(-4px, 0, 0);
	  }

	  40%, 60% {
	    transform: translate3d(4px, 0, 0);
	  }
	}

	.infinite-shake{
		-webkit-animation-name: infishake;
		-webkit-animation-duration: 0.8s;
		-webkit-transform-origin:50% 50%;
		-webkit-animation-iteration-count: infinite;
		-webkit-animation-timing-function: linear;
	}
	@-webkit-keyframes infishake {
		10%, 90% {
	    transform: translate3d(-1px, 0, 0);
	  }
	  
	  20%, 80% {
	    transform: translate3d(2px, 0, 0);
	  }

	  30%, 50%, 70% {
	    transform: translate3d(-4px, 0, 0);
	  }

	  40%, 60% {
	    transform: translate3d(4px, 0, 0);
	  }
	}

	
	/*--------------------------LOGIN PAGE-----------------------------------*/

	/*----------------------------LOADER------------------------------*/
	.modal-background{
		background: radial-gradient(#696969, #444444, #2d2d2d);
		background-repeat: no-repeat;
		height: 100vmin;
	}
	/*----------------------------LOADER------------------------------*/


	#loader {
	  display: block;
	  width: 150px;
	  height: 150px;
	  position: fixed;
	  top: 50%;
	  left: 55%;
	  margin-top: -75px;
	  margin-left: -75px;
	  text-align: center;
	  color: white;
	  font: 24px/150px Tahoma;
	  text-shadow: 0px 1px 2px rgba(0,0,0,0.5);
	  -webkit-transform-style: preserve-3d;
	  transform-style: preserve-3d;
	  
	}

	#loader figure {
	  display: block;
	  position: absolute;
	  top: 0px;
	  left: 0px;
	  width: 100%;
	  height: 100%;
	  -webkit-backface-visibility: hidden;
	  backface-visibility: hidden;
	}

	#loading {
	  display: block;
	  width: 150px;
	  height: 150px;
	  position: fixed;
	  top: 50%;
	  left: 55%;
	  margin-top: -75px;
	  margin-left: -75px;
	  text-align: center;
	  color: white;
	  font: 24px/150px Tahoma;
	  text-shadow: 0px 1px 2px rgba(0,0,0,0.5);
	  -webkit-transform-style: preserve-3d;
	  transform-style: preserve-3d;
	  
	}

	#loading figure {
	  display: block;
	  position: absolute;
	  top: 0px;
	  left: 0px;
	  width: 100%;
	  height: 100%;
	  -webkit-backface-visibility: hidden;
	  backface-visibility: hidden;
	}




	.one {
	  z-index: 3;
	  background-image: url("<?php echo base_url(); ?>assets/default/wislogo.png");
	  background-size: 100%;
	  -webkit-animation: move-one 2s infinite ease;
	  animation: move-one 2s infinite ease;
	  border-radius: 50%;
	  box-shadow: 0px 0px 10px 1px #999;
	}

	.two {
	  z-index: 1;
	  border-radius: 10px;
	  background-image:  linear-gradient(to top right, #ff3900 0%, #ffc100 100%);
	  -webkit-transform: rotateX(180deg);
	  border-radius: 50%;
	   box-shadow: 0px 0px 10px 1px #999;
	  transform: rotateX(180deg);
	  -webkit-animation: move-two 2s infinite ease;
	  animation: move-two 2s infinite ease;
	}


	@keyframes move-one {
	  0%   { transform: rotateX(0deg); }
	  25%  { transform: rotateX(180deg); }
	  50%  { transform: rotateX(180deg); }
	  75%  { transform: rotateX(360deg); }
	  100% { transform: rotateX(360deg); }
	}

	@keyframes move-two {
	  0%   { transform: rotateX(180deg); }
	  25%  { transform: rotateX(0deg); }
	  50%  { transform: rotateX(0deg); }
	  75%  { transform: rotateX(-180deg); }
	  100% { transform: rotateX(-180deg); }
	}
	 
	 @-webkit-keyframes move-one {
	  0%   { -webkit-transform: rotateX(0deg); }
	  25%  { -webkit-transform: rotateX(180deg); }
	  50%  { -webkit-transform: rotateX(180deg); }
	  75%  { -webkit-transform: rotateX(360deg); }
	  100% { -webkit-transform: rotateX(360deg); }
	 }

	@-webkit-keyframes move-two {
	  0%   { -webkit-transform: rotateX(180deg); }
	  25%  { -webkit-transform: rotateX(0deg); }
	  50%  { -webkit-transform: rotateX(0deg); }
	  75%  { -webkit-transform: rotateX(-180deg); }
	  100% { -webkit-transform: rotateX(-180deg); }
	}

	#itemslist{
		display: none;
	}
	.nomarg{
		margin: 0px;
	}
	.labelStyle{
		font-weight: 400;
		font-size: 20px;
		margin: 0px;
	}
	.tr-bottom{
		vertical-align:bottom!important;
	}
	.pad-t-4{
		padding: 4px!important;
	}
	.shadow-dash{
		box-shadow: 0px 4px 7px 0px #999;
	}
	.glow {
	  animation: glowing 2000ms infinite;
	}
	@keyframes glowing {
	  0% { box-shadow: 0 0 -10px #c4a300; }
	  40% { box-shadow: 0 0 20px #c4a300; }
	  60% { box-shadow: 0 0 20px #c4a300; }
	  100% { box-shadow: 0 0 -10px #c4a300; }
	}
	.back-g{
		background-image: linear-gradient(to top right, #ffb2b2, #ffffcc);
	}
	.itemSubBevel{
		 box-shadow: inset 5px 5px 2px rgba(255, 255, 255, .4), inset -5px -5px 2px rgba(0, 0, 0, .4);
	}
	.itemSubColor1{
		background: linear-gradient(40deg,#2096ff,#05ffa3,#2096ff);
		padding:20px 0px;
		background-size: 200% auto;
		transition: 1s;
	}
	.itemSubColor1:hover{background-position: right; }
	.itemSubColor2{
		background: linear-gradient(40deg,#303f9f, #45cafc,#303f9f);
		padding:20px 0px;
		background-size: 200% auto;
		transition: 1s;
	}
	.itemSubColor2:hover{background-position: right;}
	.itemSubColor3{
		background: linear-gradient(40deg,#fc6262,#ffd86f,#fc6262);
		background-size: 200% auto;
		transition: 1s;
	}
	.itemSubColor3:hover{background-position: right;}
	.subFcolor{
		color: #fff;
		font-size: 100px;
		margin: 0px;
	}
	.subColored{
		color: #fff!important;
	}
	.panel-bell-body{
		padding:122px 0px;
	}	
	.panel-bell {
    	font-size: 20px;
	    font-weight: 300;
	    letter-spacing: 0.025em;
	    height: 60px;
	    line-height: 38px;
	    padding: 10px 15px;
	    border-bottom: 1px solid transparent;
	    border-top-left-radius: 3px;
	    border-top-right-radius: 3px;
	}
	.rotate {
		-webkit-animation: rotation 2s infinite linear;
	}

	@-webkit-keyframes rotation {
		from {-webkit-transform: rotate(0deg);}
		to {-webkit-transform: rotate(359deg);}
	}
	.bell{
		-webkit-animation: ring 4s .7s ease-in-out infinite;
		-webkit-transform-origin: 50% 4px;
		-moz-animation: ring 4s .7s ease-in-out infinite;
		-moz-transform-origin: 50% 4px;
		animation: ring 4s .7s ease-in-out infinite;
		transform-origin: 50% 4px;
	}

	@-webkit-keyframes ring {
		0% { -webkit-transform: rotateZ(0); }
		1% { -webkit-transform: rotateZ(30deg); }
		3% { -webkit-transform: rotateZ(-28deg); }
		5% { -webkit-transform: rotateZ(34deg); }
		7% { -webkit-transform: rotateZ(-32deg); }
		9% { -webkit-transform: rotateZ(30deg); }
		11% { -webkit-transform: rotateZ(-28deg); }
		13% { -webkit-transform: rotateZ(26deg); }
		15% { -webkit-transform: rotateZ(-24deg); }
		17% { -webkit-transform: rotateZ(22deg); }
		19% { -webkit-transform: rotateZ(-20deg); }
		21% { -webkit-transform: rotateZ(18deg); }
		23% { -webkit-transform: rotateZ(-16deg); }
		25% { -webkit-transform: rotateZ(14deg); }
		27% { -webkit-transform: rotateZ(-12deg); }
		29% { -webkit-transform: rotateZ(10deg); }
		31% { -webkit-transform: rotateZ(-8deg); }
		33% { -webkit-transform: rotateZ(6deg); }
		35% { -webkit-transform: rotateZ(-4deg); }
		37% { -webkit-transform: rotateZ(2deg); }
		39% { -webkit-transform: rotateZ(-1deg); }
		41% { -webkit-transform: rotateZ(1deg); }

		43% { -webkit-transform: rotateZ(0); }
		100% { -webkit-transform: rotateZ(0); }
	}

	@-moz-keyframes ring {
		0% { -moz-transform: rotate(0); }
		1% { -moz-transform: rotate(30deg); }
		3% { -moz-transform: rotate(-28deg); }
		5% { -moz-transform: rotate(34deg); }
		7% { -moz-transform: rotate(-32deg); }
		9% { -moz-transform: rotate(30deg); }
		11% { -moz-transform: rotate(-28deg); }
		13% { -moz-transform: rotate(26deg); }
		15% { -moz-transform: rotate(-24deg); }
		17% { -moz-transform: rotate(22deg); }
		19% { -moz-transform: rotate(-20deg); }
		21% { -moz-transform: rotate(18deg); }
		23% { -moz-transform: rotate(-16deg); }
		25% { -moz-transform: rotate(14deg); }
		27% { -moz-transform: rotate(-12deg); }
		29% { -moz-transform: rotate(10deg); }
		31% { -moz-transform: rotate(-8deg); }
		33% { -moz-transform: rotate(6deg); }
		35% { -moz-transform: rotate(-4deg); }
		37% { -moz-transform: rotate(2deg); }
		39% { -moz-transform: rotate(-1deg); }
		41% { -moz-transform: rotate(1deg); }

		43% { -moz-transform: rotate(0); }
		100% { -moz-transform: rotate(0); }
	}

	@keyframes ring {
		0% { transform: rotate(0); }
		1% { transform: rotate(30deg); }
		3% { transform: rotate(-28deg); }
		5% { transform: rotate(34deg); }
		7% { transform: rotate(-32deg); }
		9% { transform: rotate(30deg); }
		11% { transform: rotate(-28deg); }
		13% { transform: rotate(26deg); }
		15% { transform: rotate(-24deg); }
		17% { transform: rotate(22deg); }
		19% { transform: rotate(-20deg); }
		21% { transform: rotate(18deg); }
		23% { transform: rotate(-16deg); }
		25% { transform: rotate(14deg); }
		27% { transform: rotate(-12deg); }
		29% { transform: rotate(10deg); }
		31% { transform: rotate(-8deg); }
		33% { transform: rotate(6deg); }
		35% { transform: rotate(-4deg); }
		37% { transform: rotate(2deg); }
		39% { transform: rotate(-1deg); }
		41% { transform: rotate(1deg); }

		43% { transform: rotate(0); }
		100% { transform: rotate(0); }
	}	
	/*--------------------USER Restriction-------------------*/


	.table-sty{
		padding: 5px;
		text-align: center;
		height: 31px!important;
	}
	.table-sty2{
		padding: 5px;
		text-align: left;
		font-weight: 700;
		height: 30px!important;
	}

	.table-sty3{
		padding: 5px;
		text-align: left;
		font-weight: 700;
		height: 50px!important;
	}

	.th-name-sub{background: #ff7c3e;color: #fff;}

	
	/*-------receive-------*/
	.th-rec{background: #2C3D0B;color: #fff;}
	.th-rec-sub{background: #719726;color: #fff;}
	.td-rec-body{background:#D0E8A1;color: #2C3D0B;}
	/*-------receive-------*/

	/*-------request-------*/
	.th-req{background: #0B3D2D;color: #fff;}
	.th-req-sub{background: #2E6051;color: #fff;}
	.td-req-body{background:#91CAB8;color: #0B3D2D;}
	/*-------request-------*/

	/*-------issue-------*/
	.th-iss{background: #0B223D;color: #fff;}
	.th-iss-sub{background: #184981;color: #fff;}
	.td-iss-body{background:#7EAFE7;color: #0B223D;}
	/*-------issue-------*/

	/*-------item-------*/
	.th-ite{background: #1D0B3D;color: #fff;}
	.th-ite-sub{background: #401192;color: #fff;}
	.td-ite-body{background:#AA9BEE;color: #1D0B3D;}
	/*-------item-------*/

	/*-------signatories-------*/
	.th-sig{background: #410E31;color: #fff;}
	.th-sig-sub{background: #7C0E59;color: #fff;}
	.td-sig-body{background:#EE68C4;color: #410E31;}
	/*-------signatories-------*/

	/*-------masterfile-------*/
	.th-mas{background: #361310;color: #fff;}
	.th-mas-sub{background: #B82619;color: #fff;}
	.td-mas-body{background:#F3B0AA;color: #361310;}
	/*-------masterfile-------*/

	/*-------request-------*/
	.th-res{background: #431F0C;color: #fff;}
	.th-res-sub{background: #E85302;color: #fff;}
	.td-res-body{background:#FED1B8;color: #431F0C;}
	/*-------request-------*/


	/*-------receive-------*/
	.th-use{background: #43310C;color: #fff;}
	.th-use-sub{background: #E79B04;color: #fff;}
	.td-use-body{background:#FEE7B9;color: #43310C;}
	/*-------receive-------*/

	.delete_but{
		right:20px;top: 65px;position:absolute;opacity: 0.7
	}
	.btn-danger:hover{
		opacity: 1.0
	}
	.btn-rounded{
		border-radius: 50%!important;
	}
	#prntby{
		display: none;
	}
	@media print {
		#printReport, #aging_table_length, #aging_table2_length, #aging_table_filter, #aging_table2_filter, .dataTables_length, .dataTables_filter{
			display: none;
		}
		#prntby{
			display: block;
		}
	}
</style>