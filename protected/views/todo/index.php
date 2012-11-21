<h1>Todos</h1>
<div id="todo-container" ng-controller="TodoController">
	<form ng-submit="addTodo()">
		<input type="text" placeholder="Add new todo..." ng-model="newTodo" />
		<input type="submit" value="&raquo;" />
	</form>
	<div ng-hide="isListEmpty()">
		<ul>
			<li ng-repeat="todo in todoList">
				<input type="checkbox" id="todo-{{$index}}" ng-model="todo.done" />
				<label class="todo-label-{{todo.done}}" for="todo-{{$index}}">{{todo.text}}</label>
			</li>
		</ul>
		<div>{{undoneCount()}} of {{todoList.length}} remaining <span id="actions"><a href="" ng-click="markAllDone()">Mark all done</a> - <a href="" ng-click="dropDone()">Drop done todos</a></span></div>
	</div>
</div>
