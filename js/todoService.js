/**
 * Todo service - Makes AJAX requests abstract when making todo CRUD operations
 * on the server side.
 */
angular.module('todoService', ['ngResource']).
	factory('Todo', function($resource) {
		return $resource(generic.createUrl('todo') + '/:action', {}, {
			/**
			 * Returns all todos for logged in user. Accepts no filtering.
			 */
			query: {
				method: 'GET',
				params: {action: 'query'},
				isArray: true
			},
			/**
			 * Saves a single todo.
			 */
			save: {
				method: 'POST',
				params: {action: 'save'}
			},
			/**
			 * Saves a list of todos. 
			 */
			saveAll: {
				method: 'POST',
				params: {action: 'saveAll'},
				isArray: true
			},
			/**
			 * Removes a list of todos.
			 */
			removeAll: {
				method: 'DELETE',
				params: {action: 'deleteAll'},
				isArray: true
			}
		});
	});