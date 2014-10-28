function createApp(todolist, basePath, loggedIn){
  
  var app = angular.module('todoList', []);
  
  app.controller('TodoController', function(){
  
  	
	this.isLoggedIn = loggedIn;
	this.passwd = "";
	
	this.logout = function(){
		this.isLoggedIn = false;
		$.ajax({
			url: this.basePath + "ajax.php?action=logout",
			cache: false,
			async: false
			});
	}
	
	this.checkPW = function(){
	
		pw = $.ajax({
			url: this.basePath + "ajax.php?action=security&passwd=" +SHA256(this.passwd),
			cache: false,
			async: false
			}).responseText;
			
		this.passwd = "";	
		
		if(pw == "true"){
			this.isLoggedIn = true;
		}
	};
  
	this.basePath = basePath;
    this.todos = todolist;
	this.tmpDelTodo = {};
	this.isDel = false;
	
	this.delTodo = function(item){
		this.isDel = true;
		this.tmpDelTodo = item;
	};
	
	this.removeTodo = function(){
		this.todos.splice(this.todos.indexOf(this.tmpDelTodo),1);
		$.ajax( {url: this.basePath + "ajax.php?action=delete&id=" +this.tmpDelTodo.id, success: function( data ) {},cache: false});
		this.tmpDelTodo = {};
		this.isDel = false;
	
	};
	
	this.notDelTodo = function(){
		this.tmpDelTodo = {};
		this.isDel = false;
	};
	
	this.tmpTodo = {};
	
	this.addTodo = function(){
		this.tmpTodo.date = getToday();
		
		this.tmpTodo.text = ReplaceAll(this.tmpTodo.text, '\n','<br>')
		
		this.tmpTodo.id = $.ajax({
			url: this.basePath + "ajax.php?action=add&title=" +this.tmpTodo.title + "&text="+ this.tmpTodo.text + "&date=" + this.tmpTodo.date,
			cache: false,
			async: false
			}).responseText;
			
			
		this.todos.push(this.tmpTodo);
		this.tmpTodo = {};
	};
	
	this.cancleTodo = function(){
		this.tmpTodo = {};
	};
  });
    
	app.controller('EditController', function(){
	
	this.isEdit = false;
	this.editItem = {};
	
	this.editTodo = function(todoItem){
		this.editItem = todoItem;
		this.editItem.text = ReplaceAll(this.editItem.text, '<br>','\n')
		this.isEdit = true;
	};
	
	this.saveTodo = function(){
		this.isEdit = false;
		this.editItem.text = ReplaceAll(this.editItem.text, '\n','<br>')
		$.ajax( {url: this.basePath + "ajax.php?action=save&id=" + this.editItem.id + "&title=" + this.editItem.title + "&text="+ this.editItem.text + "&date=" + this.editItem.date, success: function( data ) {},cache: false});
		this.editItem = {};
	};
	
	this.cancleEdit = function(){
		this.isEdit = false;
		this.editItem = {};
	};
	
	});
	
	
  app.filter('htmltags', function($sce) {
    return function(val) {
        return $sce.trustAsHtml(val);
    };
});
  
}


function getToday(){
	var today = new Date();

	var mm = today.getMonth()+1;
	var dd = today.getDate();
	var yyyy = today.getFullYear();

	return zeroFill(mm,2) + "/" + zeroFill(dd,2) + "/" + yyyy;
}

function zeroFill( number, width )
{
  width -= number.toString().length;
  if ( width > 0 )
  {
    return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
  }
  return number + ""; // always return a string
}

function ReplaceAll(Source,stringToFind,stringToReplace){

  var temp = Source;

    var index = temp.indexOf(stringToFind);

        while(index != -1){

            temp = temp.replace(stringToFind,stringToReplace);

            index = temp.indexOf(stringToFind);

        }

        return temp;

}
