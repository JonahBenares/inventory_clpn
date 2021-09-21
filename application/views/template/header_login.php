<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inventory System - Warehouse</title>
	<link href="<?php echo base_url(); ?>assets/default/wislogo.png" rel="icon">
	<link href="<?php echo base_url(); ?>assets/Styles/bootstrap.min.css" rel="stylesheet">	
	<link href="<?php echo base_url(); ?>assets/Styles/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/Styles/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/Styles/datepicker3.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/Styles/styles.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/Styles/jquery.dataTables.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/Styles/custom.css" rel="stylesheet">
	
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
	    background: #222222; 
	}
	::-moz-scrollbar-track {
	    background: #222222; 
	}
	 
	/* Handle */
	::-webkit-scrollbar-thumb {
	    background: #888; 
	    box-raduis: 50px 50px 50px 50px;
	}

	/* Handle on hover */
	::-webkit-scrollbar-thumb:hover {
	    background: #ff7c3e; 
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
  		height:40px; 
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
  		padding: 10px 0px 1px;
    	animation: mymove 10s infinite;
  	}

	@keyframes mymove {
	    from {left: -95px;}
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

	/*----------------SUPPLIER BUTTON--------------------*/
	.supplier{
		background-color: rgb(249, 36, 63, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	}
	.supplier a{
		color: white;
	}
	.supplier:hover{
		background-color: rgb(249, 36, 63);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    box-shadow: 0px 1px 20px 0px #ff8787;

	}
	.supplier:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	    
	}	
	/*----------------SUPPLIER BUTTON--------------------*/

	/*----------------category BUTTON--------------------*/
	.category{
		background-color: rgb(249, 130, 36, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    
	}
	.category a{
		color: white;
	}
	.category:hover{
		background-color: rgb(249, 130, 36);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
		box-shadow: 0px 1px 20px 0px #c19246;
	}
	.category:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	/*----------------category BUTTON--------------------*/

	/*----------------SUB category BUTTON--------------------*/
	
	.subcategory{
		background-color: rgb(255, 181, 62, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    
	}
	.subcategory a{
		color: white;
	}
	.subcategory:hover{
		background-color: rgb(255, 181, 62);
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
	/*----------------SUB category BUTTON--------------------*/
	
	/*----------------End_use BUTTON--------------------*/
	
	.employees{
		background-color:rgba(249, 36, 208, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	}
	.employees a{
		color: white;
	}
	.employees:hover{
		background-color:rgba(249, 36, 208);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
		box-shadow: 0px 1px 20px 0px #fd65ff;
	}
	.employees:hover .tooltiptext{
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
	
	.purpose{
		background-color:rgba(36, 37, 249, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    
	}
	.purpose a{
		color: white;
	}
	.purpose:hover{
		background-color:rgba(36, 37, 249);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
		box-shadow: 0px 1px 20px 0px #6e65ff;
	}
	.purpose:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	/*----------------Purpose BUTTON--------------------*/

	/*----------------Warehouse BUTTON--------------------*/
	
	.warehouse{
		background-color:rgba(36, 155, 249, .45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    
	}
	.warehouse a{
		color: white;
	}
	.warehouse:hover{
		background-color:rgba(36, 155, 249);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
		box-shadow: 0px 1px 20px 0px #249bf9;
	}
	.warehouse:hover .tooltiptext{
		visibility: visible;
	    opacity: 1;
	}
	/*----------------Warehouse BUTTON--------------------*/

	/*----------------Location BUTTON--------------------*/
	
	.location{
		background-color:rgba(50, 212, 255, 0.45);
		float: left;
	    margin: 10px 8px;
	    padding: 0px;
	    border-radius: 4px;
	    
	}
	.location a{
		color: white;
	}
	.location:hover{
		background-color:rgba(50, 212, 255);
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

	.pictures{
		max-width:100%;
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
	.loader{
		position: relative;
		float:right;
		transform: translateY(10vw);
		right:35%;
		width: 20px;
		height: 20px;
		background: #ff7400;
		animation: fade 2.5s infinite ;
		border-radius: 15%;
		margin: 0 2px
	}
	.loader:nth-child(2) {
		animation-delay: .15s;
		background: #ff7400;
	}
	.loader:nth-child(3) {
		animation-delay: .3s;
		background: #ff7400;
	}
	.loader:nth-child(4) {
		animation-delay: .45s;
		background:#ff7400;
	}
	.loader:nth-child(5) {
		animation-delay:.6s;
		background: #ff7400;
	}
	.loader:nth-child(6) {
		animation-delay: .75s;
		background: #ff7400;
	}
	.loader:nth-child(7) {
		animation-delay: .90s;
		background:#ff7400;
	}
	.loader:nth-child(8) {
		animation-delay: 1.05s;
		background: #ff7400;
	}
	.loader:nth-child(9) {
		animation-delay: 1.2s;
		background: #ff7400;
	}

	@keyframes fade {
		0%{
		height: 20px;
		-webkit-box-shadow: -11px 18px 29px -3px rgba(0,0,0,1);
-moz-box-shadow: -11px 18px 29px -3px rgba(0,0,0,1);
box-shadow: -11px 18px 29px -3px rgba(0,0,0,1);
		}

		50%{
		height: 120px;
		transform: translateY(15vw);
		background:#D1D5D8;
		-webkit-box-shadow: -11px 18px 29px -3px rgba(0,0,0,1);
-moz-box-shadow: -11px 18px 29px -3px rgba(0,0,0,1);
box-shadow: -11px 18px 29px -3px rgba(0,0,0,1);

		}
		100%{
		height: 20px;
		-webkit-box-shadow: -11px 18px 29px -3px rgba(0,0,0,1);
-moz-box-shadow: -11px 18px 29px -3px rgba(0,0,0,1);
box-shadow: -11px 18px 29px -3px rgba(0,0,0,1);
		}
	}
	.modal-background{
		background: radial-gradient(#696969, #444444, #2d2d2d);
		background-repeat: no-repeat;
		height: 100vmin;
	}
	/*----------------------------LOADER------------------------------*/


	#loader{
			position: absolute;
			left: 50%;
			top:50%;
			z-index: 1;
			width: 150px;
			height: 150px;
			margin: -75px 0 0 -75px;
			border: 16px solid #f3f3f3;
			border-radius: 50%;
			border-top: 16px solid #3498db;
			width: 120px;
			height: 120px;
			-webkit-animation: spin 2s linear infinite;
			-moz-animation: spin 2s linear infinite;
			animation:  spin 2s linear infinite;
		}

		@-webkit-keyframes spin{
			0% {transform: rotate(0deg);}
			100% { transform: rotate(360deg); }
		}

		@-moz-keyframes spin{
			0% {transform: rotate(0deg);}
			100% { transform: rotate(360deg); }
		}
		.animate-bottom{
			position: relative;
			-webkit-animation-name:animationbttom;
			-webkit-animation-duration:1s;
			-moz-animation-name:animationbttom;
			-moz-animation-duration:1s;
			animation-name: animationbottom;
			animation-duration: 1s;
		}

		@-moz-keyframes animationbottom{
			from {bottom:-100; opacity: 0}
			to {bottom: 0px; opacity: 1}
		}


		@-webkit-keyframes animationbottom{
			from {bottom:-100; opacity: 0}
			to {bottom: 0px; opacity: 1}
		}

		@keyframes animationbottom{
			from {bottom:-100; opacity: 0}
			to {bottom: 0px; opacity: 1}
		}

		#myDiv{
			display: none;
			text-align: center;
		}
</style>