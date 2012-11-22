<h1>Todos</h1>
<div id="todo-container" ng-controller="TodoController" ng-app="todo">
	<form ng-submit="addTodo()">
		<input type="text" placeholder="Add new todo..." ng-model="newTodo" />
		<input type="submit" value="&raquo;" />
	</form>
	<div ng-hide="isListEmpty()">
		<ul>
			<li ng-repeat="todo in todoList" ng-click="toggleDone(todo)">
				<input type="checkbox" ng-checked="todo.done" />
				<label class="todo-label-{{todo.done}}">{{todo.text}}</label>
			</li>
		</ul>
		<div>{{undoneCount()}} of {{todoList.length}} remaining
			<span id="actions">
				Mark all <a href="" ng-click="markAll(true)">done</a> / <a href="" ng-click="markAll(false)">undone</a> -
				<a href="" ng-click="dropDone()">Drop done todos</a>
			</span>
		</div>
	</div>
</div>
