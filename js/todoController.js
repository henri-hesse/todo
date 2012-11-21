function TodoController($scope) {
	$scope.todoList = [];

	$scope.addTodo = function() {
		if( typeof this.newTodo==='undefined' || this.newTodo==='' )
			return;

		var todo = {
			text: this.newTodo,
			done: false
		};

		this.todoList.push(todo);
		this.newTodo = '';
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

	$scope.markAllDone = function() {
		for(var i=0,len=this.todoList.length; i<len; i++) {
			this.todoList[i].done = true;
		}
	};

	$scope.dropDone = function() {
		var oldTodoList=this.todoList, newTodoList=[], todo;
		for(var i=0; i<oldTodoList.length; i++) {
			todo = oldTodoList[i];

			if( todo.done===false )
				newTodoList.push(todo);
		}

		this.todoList = newTodoList;
	};

	$scope.isListEmpty = function() {
		return ( this.todoList.length===0 );
	};
};