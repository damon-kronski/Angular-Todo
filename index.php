<!DOCTYPE html>
<html ng-app="todoList">
  <head>
	<?php 
	include "config/config.php";
	include "lib/php/lang.php";
	include "lib/php/angularphp.php";
	include "lib/php/jsondb.php";
	
	session_start();
	
	if(!$config['useLogin'])
		$_SESSION['loggedin'] = true;
	
	if(!isset($_GET['lang']))
		$_GET['lang'] = "";
	
	include(getLangPath($_GET['lang']));
	
	if($config['useCookies'])
		$JsonDB = JsonDB::withCookies();
	else
		$JsonDB = JsonDB::withJson();
	$AngularPhp = new AngularPhp();
	?>
	
    <link rel="stylesheet" type="text/css" href="<?php echo $config['base_path'];?>/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $config['base_path'];?>/css/theme.css" />
    <script type="text/javascript" src="<?php echo $config['base_path'];?>/lib/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $config['base_path'];?>/lib/js/angular.min.js"></script>
	<script type="text/javascript" src="<?php echo $config['base_path'];?>/lib/js/security.js"></script>
    <script type="text/javascript" src="<?php echo $config['base_path'];?>/lib/js/app.js"></script>
	<script>
	<?php
		echo $AngularPhp->ArrayToJs3D($JsonDB->readDB(),"TmpToDoList");
		
		if(isset($_SESSION['loggedin']))
			if($_SESSION['loggedin'])
				echo "loggedin = true;";
			else
				echo "loggedin = false;";
		else
			echo "loggedin = false;";
	?>

	createApp(TmpToDoList, '<?php echo $config['base_path']?>',loggedin) ;
	</script>
  </head>
  <body class="body-container" ng-controller="TodoController as todo">

<div class="head-container">
<table class="head-table">
<tr>
	<td class="head-table-lang">
	</td>	
	<td class="head-table-title">
		<h1><?php lang('PageTitle');?></h1>
	</td>
	<td class="head-table-lang">
		<?php
		if(isset($_SESSION['loggedin']) AND $config['useLogin'])
		if($_SESSION['loggedin']){
			echo '<a class="btn btn-link pull-right" href="" ng-click="todo.logout()">';
			lang('Logout');
			echo '</a>';
		}
		
		foreach($config['languages'] as $Key => $Value){
			echo '<a class="btn btn-link pull-right" href="'.$config['base_path'].$Key.'">'.strtoupper($Key).'</a>';
		}

		?>
	</td>
</tr>
</table>
</div>

<div class="main-container" ng-show="todo.isLoggedIn" ng-controller="EditController as edit">

	<div class="input-container container pull-left" ng-hide="edit.isEdit">
		<form class="form form-vertical" ng-submit="todo.addTodo()">
		
		<input type="hidden" class="form-control" placeholder="date" ng-model="todo.tmpTodo.date">
		
		<div class="row row-input">
			<label for="title" class=" control-label"><?php lang('Title');?></label>
			<div class="">
				<input type="text" name="title" class="form-control" placeholder="<?php lang('Title');?>" ng-model="todo.tmpTodo.title">
			</div>
		</div>	
				
		<div class="row row-input">
			<label for="text" class=" control-label"><?php lang('Text');?></label>
			<div class="">
				<textarea class="form-control" name="text" rows="4" placeholder="<?php lang('Description');?>" ng-model="todo.tmpTodo.text"></textarea>
			</div>
		</div>	
		
		<div class="row row-input">
			<div class=""></div>
			<div class="">
				<input class="btn btn-primary pull-left" type="submit" value="<?php lang('Add');?>">
				<a class="btn btn-link pull-left" ng-click="todo.cancleTodo()"><?php lang('Cancle');?></a>
			</div>
		</div>
	
		</form>
	</div>	
	
	<div class="input-container container pull-left" ng-show="edit.isEdit">
		<form class="form form-vertical" ng-submit="edit.saveTodo()">
		
		<input type="hidden" class="form-control" placeholder="date" ng-model="edit.editItem.date">
		
		<div class="row row-input">
			<label for="title" class=" control-label"><?php lang('Title');?></label>
			<div class="">
				<input type="text" name="title" class="form-control" placeholder="<?php lang('Title');?>" ng-model="edit.editItem.title">
			</div>
		</div>	
				
		<div class="row row-input">
			<label for="text" class=" control-label"><?php lang('Text');?></label>
			<div class="">
				<textarea class="form-control" name="text" rows="4" placeholder="<?php lang('Description');?>" ng-model="edit.editItem.text"></textarea>
			</div>
		</div>	
		
		<div class="row row-input">
			<div class=""></div>
			<div class="">
				<input class="btn btn-primary pull-left" type="submit" value="<?php lang('Description');?>">
				<a class="btn btn-link pull-left" ng-click="edit.cancleEdit()"><?php lang('Cancle');?></a>
			</div>
		</div>
	
		</form>
	</div>
	
	<div class="todo-list pull-right">
	<table class="table todo-table">
		<tr ng-repeat="todoitem in todo.todos">
			<td class="todo-item">
			<div class="todo-item-container">
				<b>{{todoitem.title}}</b>
				<em class="pull-right">{{todoitem.date}}</em>
				<div class="todo-item-text">
					<span ng-bind-html="todoitem.text | htmltags"></span>
					<a href="" ng-click="todo.delTodo(todoitem)" class="btn btn-default btn-delete pull-right"><?php lang('Delete');?></a>
					<a href="" ng-click="edit.editTodo(todoitem)" class="btn btn-default btn-delete pull-right"><?php lang('Edit');?></a>
				</div>
			</div>	
			</td>	
		</tr>		
	</table>	
	</div>
</div>	


<div class="main-container" ng-hide="todo.isLoggedIn">
<div class="login-form">
<form class="form form-inline" ng-submit="todo.checkPW()">
	<label for="password" class=" control-label"><?php lang('Password');?></label>
	<input class="form-control passwd" type="password" placeholder="<?php lang('Password');?>" ng-model="todo.passwd">
	<input class="btn btn-primary" type="submit" value="<?php lang('Login');?>">
</form>
</div>
</div>


<div class="delete-popup" ng-show="todo.isDel">
<h1><?php lang('Delete');?>?</h1>
<div class="delete-h2">({{todo.tmpDelTodo.title}})</div>
<a href="" ng-click="todo.removeTodo()" class="btn btn-default btn-delete"><?php lang('Yes');?></a>
<a href="" ng-click="todo.notDelTodo()" class="btn btn-default btn-delete"><?php lang('No');?></a>
</div>
  </body>
</html>
