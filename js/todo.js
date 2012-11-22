angular.module('todo', ['todoService']);

function TodoController($scope, Todo) {
	$scope.todoList = Todo.query();

	$scope.addTodo = function() {
		if( typeof this.newTodo==='undefined' || this.newTodo==='' )
			return;

		var todo = new Todo({
			text: this.newTodo,
			done: false
		});
		
		todo.$save();
		
		this.todoList.push(todo);
		this.newTodo = '';
	};

	$scope.toggleDone = function(todo) {
		todo.done = !todo.done;
		todo.$save();
	};

	$scope.undoneCount = function() {
		var count = 0, todo;
		for(var i=0,len=this.todoList.length; i<len; i++) {
			todo = this.todoList[i];
			if( todo.done===false )
				count++;
		}

		return count;
	};

	$scope.markAll = function(done) {
		var todo, changedList = [];
		for(var i=0,len=this.todoList.length; i<len; i++) {
			todo = this.todoList[i];
			
			if( todo.done===!done ) {
				todo.done = done;
				changedList.push(todo);
			}
		}
		
		if( changedList.length>0 )
			Todo.saveAll({}, changedList);
	};

	$scope.dropDone = function() {
		var todo, oldTodoList=this.todoList, newTodoList=[], removedTodoList=[];
		
		for(var i=0; i<oldTodoList.length; i++) {
			todo = oldTodoList[i];

			if( todo.done===false )
				newTodoList.push(todo);
			else
				removedTodoList.push(todo);
		}

		if( removedTodoList.length>0 ) {
			Todo.removeAll({}, removedTodoList);
			this.todoList = newTodoList;			
		}
	};

	$scope.isListEmpty = function() {
		return ( this.todoList.length===0 );
	};
};