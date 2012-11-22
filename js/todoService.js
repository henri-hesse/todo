angular.module('todoService', ['ngResource']).
	factory('Todo', function($resource) {
	return $resource(generic.createUrl('todo') + '/:action', {}, {
			query: {
				method: 'GET',
				params: {action: 'query'},
				isArray: true
			},
			save: {
				method: 'POST',
				params: {action: 'save'}
			},
			saveAll: {
				method: 'POST',
				params: {action: 'saveAll'},
				isArray: true
			},
			removeAll: {
				method: 'DELETE',
				params: {action: 'deleteAll'},
				isArray: true
			}
		});
	});