/**
 * Tdo module - Handles the todo list in "todo/index"- This includes todo creation,
 * marking todos done/undone and deleting todos in client side. See todoService for
 * server side interactions.
 */
angular.module('todo', ['todoService']);

function TodoController($scope, Todo) {
	/**
	 * List for all todos that belongs to this user.
	 */
	$scope.todoList = Todo.query();

	/**
	 * Adds new todo with user written content text.
	 */
	$scope.addTodo = function() {
		if( typeof this.newTodo==='undefined' || this.newTodo==='' )
			return;

		var todo = new Todo({
			// NewTodo is binded to the text field in the page.
			text: this.newTodo,
			done: false
		});
		
		// Server side save
		todo.$save();
		
		this.todoList.push(todo);
		// Empty the text field.
		this.newTodo = '';
	};

	/**
	 * Toggles todo's done property.
	 */
	$scope.toggleDone = function(todo) {
		todo.done = !todo.done;
		todo.$save();
	};

	/**
	 * Returns the number of undone todos.
	 * @returns Number
	 */
	$scope.undoneCount = function() {
		var count = 0, todo;
		for(var i=0,len=this.todoList.length; i<len; i++) {
			todo = this.todoList[i];
			if( todo.done===false )
				count++;
		}

		return count;
	};

	/**
	 * Marks all todos as done or undone
	 * @param done Boolean Whether to mark todos as done (true) or undone (false).
	 */
	$scope.markAll = function(done) {
		var todo, changedList = [];
		for(var i=0,len=this.todoList.length; i<len; i++) {
			todo = this.todoList[i];
			
			// Toggle done property & save the changed todos
			if( todo.done===!done ) {
				todo.done = done;
				changedList.push(todo);
			}
		}
		
		// Save changed todos.
		if( changedList.length>0 )
			Todo.saveAll({}, changedList);
	};

	/**
	 * Deletes permanently done todos.
	 */
	$scope.dropDone = function() {
		var todo, oldTodoList=this.todoList, newTodoList=[], removedTodoList=[];
		
		for(var i=0; i<oldTodoList.length; i++) {
			todo = oldTodoList[i];

			// Collect undone todos.
			if( todo.done===false )
				newTodoList.push(todo);
			// Collect done todos to be removed.
			else
				removedTodoList.push(todo);
		}

		// Remove done todos.
		if( removedTodoList.length>0 ) {
			Todo.removeAll({}, removedTodoList);
			this.todoList = newTodoList;			
		}
	};

	/**
	 * Check whether the todo list is empty
	 * @return Boolean Whether the list is empty or not.
	 */
	$scope.isListEmpty = function() {
		return ( this.todoList.length===0 );
	};
};