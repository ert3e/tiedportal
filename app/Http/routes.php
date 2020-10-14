<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::model('customer', 'App\Models\Customer');
Route::model('contact', 'App\Models\Contact');
Route::model('supplier', 'App\Models\Supplier');
Route::model('media', 'App\Models\Media');
Route::model('note', 'App\Models\Note');
Route::model('notification', 'App\Models\Notification');
Route::model('cost', 'App\Models\Cost');
Route::model('bill', 'App\Models\Bill');
Route::model('user', 'App\Models\User');
Route::model('role', 'App\Models\Role');
Route::model('task', 'App\Models\Task');
Route::model('ticket', 'App\Models\Ticket');
Route::model('quote', 'App\Models\Quote');
Route::model('project', 'App\Models\Project');
Route::model('component_type', 'App\Models\ComponentType');
Route::model('component_field', 'App\Models\ComponentField');
Route::model('quote_request', 'App\Models\QuoteRequest');

Route::group(['middleware' => ['web']], function () {

    // TODO: Configure granual permissions (CRUD)

    /*
     * Public routes
     */
    Route::group(['middleware' => ['not_deleted']], function() {
        Route::get('login', ['uses' => 'LoginController@index', 'as' => 'login']);
        Route::post('login', ['uses' => 'LoginController@login', 'as' => 'login.post']);

        Route::get('forgot', ['uses' => 'LoginController@getEmail', 'as' => 'forgot']);
        Route::post('reset', ['uses' => 'LoginController@postEmail', 'as' => 'reset.post']);

        Route::get('password/reset/{token}', ['uses' => 'LoginController@getReset', 'as' => 'password.reset']);
        Route::post('password/reset', ['uses' => 'LoginController@postReset', 'as' => 'password.reset.post']);
    });

    /*
     * Global protected routes
     */
    Route::group(['middleware' => ['auth']], function() {

        Route::get('logout', ['uses' => 'LoginController@logout', 'as' => 'logout']);

        Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home.index']);

        Route::group(['prefix' => 'media'], function () {
            Route::get('{media}/{width?}/{height}/{name?}', ['uses' => 'MediaController@get', 'as' => 'media.get']);
            Route::get('{media}/{name?}', ['uses' => 'MediaController@download', 'as' => 'media.download']);
        });
    });

    /*
     * System user routes
     */
    Route::group(['middleware' => ['auth', 'user_type'], 'user_type' => 'user'], function() {

        /*
         * Session routes for keeping sessions alive
         */
        Route::group(['prefix' => 'session'], function() {
            Route::get('ping', ['uses' => 'SessionController@ping', 'as' => 'session.ping']);
        });

        /*
         * User routes
         */
        Route::group(['middleware' => ['permissions'], 'prefix' => 'user', 'permission_group' => 'users'], function() {

            Route::get('/', ['uses' => 'UserController@index', 'as' => 'users.index']);
            Route::post('store', ['uses' => 'UserController@store', 'as' => 'users.store']);

            Route::group(['middleware' => ['user_access']], function() {
                Route::get('{user}/details', ['uses' => 'UserController@details', 'as' => 'users.details']);
                Route::get('/profile', ['uses' => 'UserController@profile', 'as' => 'users.profile']);
                Route::post('store', ['uses' => 'UserController@store', 'as' => 'users.store']);
                Route::post('{user}/update', ['uses' => 'UserController@update', 'as' => 'users.update']);
                Route::post('{user}/delete', ['uses' => 'UserController@delete', 'as' => 'users.delete']);
            });

            // Autocomplete method
            Route::get('/lookup/autocomplete/{term?}', ['uses' => 'UserController@autocomplete', 'as' => 'users.autocomplete']);

            // Media (provided by UploadsMedia trait)
            Route::post('{user}/media/upload', ['uses' => 'UserController@uploadMedia', 'as' => 'users.media.upload']);
        });

        /*
         * Routes protected by permissions middleware
         * permission_group is enforced by the middleware
         */
        Route::group(['middleware' => ['permissions'], 'prefix' => 'customers', 'permission_group' => 'customers'], function() {

            Route::get('/', ['uses' => 'CustomerController@index', 'as' => 'customers.index']);
            Route::get('/leads', ['uses' => 'CustomerController@leads', 'as' => 'leads.index']);
            Route::post('store', ['uses' => 'CustomerController@store', 'as' => 'customers.store']);
            Route::get('{customer}', ['uses' => 'CustomerController@details', 'as' => 'customers.details']);
            Route::post('{customer}/delete', ['uses' => 'CustomerController@delete', 'as' => 'customers.delete']);

            // Update method (provided by HasEditableAttributes trait)
            Route::post('{customer}/update', ['uses' => 'CustomerController@update', 'as' => 'customers.update']);

            // Autocomplete method
            Route::get('/lookup/autocomplete/{term?}', ['uses' => 'CustomerController@autocomplete', 'as' => 'customers.autocomplete']);

            // Media (provided by UploadsMedia trait)
            Route::post('{customer}/media/upload', ['uses' => 'CustomerController@uploadMedia', 'as' => 'customers.media.upload']);

            // Customer address (provided by HasAddresses trait)
            Route::post('{customer}/address/store', ['uses' => 'CustomerController@storeAddress', 'as' => 'customers.address.store']);

            // Customer contacts (provided by HasContact trait)
            Route::post('{customer}/contact/store', ['uses' => 'CustomerController@storeContact', 'as' => 'customers.contact.store']);
            Route::get('{customer}/contacts-download', ['uses' => 'CustomerController@downloadContacts', 'as' => 'customers.contacts.download']);

            // Attachment methods (provided by HasAttachments trait)
            Route::group(['prefix' => '{customer}/attachments'], function() {
                Route::post('attach', ['uses' => 'CustomerController@addAttachment', 'as' => 'customers.attachments.attach']);
                Route::post('detach', ['uses' => 'CustomerController@removeAttachment', 'as' => 'customers.attachments.detach']);
            });

            // Notes methods (provided by HasNotes trait)
            Route::group(['prefix' => '{customer}/notes'], function() {
                Route::post('add', ['uses' => 'CustomerController@addNote', 'as' => 'customers.notes.add']);
                Route::post('search', ['uses' => 'CustomerController@searchNotes', 'as' => 'customers.notes.search']);
            });
        });

        /*
         * Notes
         */
        Route::group(['middleware' => [], 'prefix' => 'notes'], function() {

            Route::post('/{note}/delete', ['uses' => 'NoteController@delete', 'as' => 'notes.delete']);
            Route::post('/{note}/update', ['uses' => 'NoteController@update', 'as' => 'notes.update']);
        });

        /*
         * Notifications
         */
        Route::resource('/notifications', 'NotificationController');

        /*
         * Contacts
         */
        // TODO: Secure this in a way to allow updating your own profile
        Route::group(['middleware' => ['permissions'], 'prefix' => 'contacts', 'permission_group' => 'contacts'], function() {

            Route::get('/', ['uses' => 'ContactController@index', 'as' => 'contacts.index']);
            Route::post('/', ['uses' => 'ContactController@indexDownload', 'as' => 'contacts.index.download']);
            Route::get('{contact}', ['uses' => 'ContactController@details', 'as' => 'contacts.details']);
            Route::post('{contact}/update', ['uses' => 'ContactController@update', 'as' => 'contacts.update']);
            Route::post('{contact}/delete', ['uses' => 'ContactController@delete', 'as' => 'contacts.delete']);

            // Media (provided by UploadsMedia trait)
            Route::post('{contact}/media/upload', ['uses' => 'ContactController@uploadMedia', 'as' => 'contacts.media.upload']);

            // Update method (provided by HasEditableAttributes trait)
            Route::post('{contact}/update', ['uses' => 'ContactController@update', 'as' => 'contacts.update']);

            // Create user method. Used to allow this contact to login
            Route::group(['prefix' => '{contact}/user'], function() {
                Route::get('/create', ['uses' => 'ContactController@createUser', 'as' => 'contacts.user.create']);
                Route::post('/store', ['uses' => 'ContactController@storeUser', 'as' => 'contacts.user.store']);
            });
        });

        /*
         * Finance
         */
        Route::group(['middleware' => ['permissions'], 'prefix' => 'finance', 'permission_group' => 'finance'], function() {

            Route::get('/', ['uses' => 'FinanceController@index', 'as' => 'finance.index']);
            Route::post('/', ['uses' => 'FinanceController@index', 'as' => 'finance.index']);
        });

        /*
         * Tasks
         */
        Route::group(['middleware' => ['permissions'], 'prefix' => 'tasks', 'permission_group' => 'tasks'], function() {

            Route::get('/', ['uses' => 'TaskController@index', 'as' => 'tasks.index']);
            Route::post('{task}/delete', ['uses' => 'TaskController@delete', 'as' => 'tasks.delete']);
            Route::get('/{task}', ['uses' => 'TaskController@details', 'as' => 'tasks.details']);

            // Update method (provided by HasEditableAttributes trait)
            Route::post('{task}/update', ['uses' => 'TaskController@update', 'as' => 'tasks.update']);

            // Tasks methods (provided by HasTasks trait)
            Route::post('/store', ['uses' => 'TaskController@createTask', 'as' => 'tasks.store']);

            // Assignee methods (provided by HasAssignees trait)
            Route::group(['prefix' => '{task}/assignees'], function() {
                Route::post('add', ['uses' => 'TaskController@addAssignee', 'as' => 'tasks.assignees.add']);
                Route::post('remove', ['uses' => 'TaskController@removeAssignee', 'as' => 'tasks.assignees.remove']);
            });

            // Attachment methods (provided by HasAttachments trait)
            Route::group(['prefix' => '{task}/attachments'], function() {
                Route::post('attach', ['uses' => 'TaskController@addAttachment', 'as' => 'tasks.attachments.attach']);
                Route::post('detach', ['uses' => 'TaskController@removeAttachment', 'as' => 'tasks.attachments.detach']);
            });

            // Notes methods (provided by HasNotes trait)
            Route::group(['prefix' => '{task}/notes'], function() {
                Route::post('add', ['uses' => 'TaskController@addNote', 'as' => 'tasks.notes.add']);
                Route::post('search', ['uses' => 'TaskController@searchNotes', 'as' => 'tasks.notes.search']);
            });

            // Notes methods (provided by HasNotes trait)
            Route::group(['prefix' => '{task}/project'], function() {
                Route::post('add', ['uses' => 'TaskController@assigneeProject', 'as' => 'tasks.project.assignee']);
                // Route::post('search', ['uses' => 'TaskController@searchNotes', 'as' => 'tasks.notes.search']);
            });
        });

        /*
         * Quotes
         */
        Route::group(['middleware' => ['permissions'], 'prefix' => 'quote', 'permission_group' => 'quotes'], function() {

            Route::get('/', ['uses' => 'QuoteController@index', 'as' => 'quotes.index']);
            Route::get('/{project}/request', ['uses' => 'QuoteController@request', 'as' => 'quotes.request']);
            Route::post('/{project}/request/send', ['uses' => 'QuoteController@send', 'as' => 'quotes.request.send']);

            Route::group(['prefix' => '{quote}'], function() {
                Route::get('details', ['uses' => 'QuoteController@details', 'as' => 'quotes.details']);
                Route::post('accept', ['uses' => 'QuoteController@accept', 'as' => 'quotes.accept']);
                Route::post('delete', ['uses' => 'QuoteController@delete', 'as' => 'quotes.delete']);
            });
        });

        /*
         * Projects
         */
        Route::group(['middleware' => ['permissions'], 'prefix' => 'projects', 'permission_group' => 'projects'], function() {

            Route::get('/{type?}/list', ['uses' => 'ProjectController@index', 'as' => 'projects.index']);
            Route::get('/{project}', ['uses' => 'ProjectController@details', 'as' => 'projects.details']);
            Route::post('/store', ['uses' => 'ProjectController@store', 'as' => 'projects.store']);
            Route::post('{project}/delete', ['uses' => 'ProjectController@delete', 'as' => 'projects.delete']);
            Route::post('{project}/complete', ['uses' => 'ProjectController@complete', 'as' => 'projects.complete']);
            Route::post('{project}/convert', ['uses' => 'ProjectController@convert', 'as' => 'projects.convert']);

            // Autocomplete method
            Route::get('/lookup/autocomplete/{term?}', ['uses' => 'ProjectController@autocomplete', 'as' => 'projects.autocomplete']);

            // Update method (provided by HasEditableAttributes trait)
            Route::post('{project}/update', ['uses' => 'ProjectController@update', 'as' => 'projects.update']);

            // Notes methods (provided by HasNotes trait)
            Route::group(['prefix' => '{project}/notes'], function() {
                Route::post('add', ['uses' => 'ProjectController@addNote', 'as' => 'projects.notes.add']);
                Route::post('search', ['uses' => 'ProjectController@searchNotes', 'as' => 'projects.notes.search']);
            });

            // Tasks methods (provided by HasTasks trait)
            Route::group(['prefix' => '{project}/tasks'], function() {
                Route::post('create', ['uses' => 'ProjectController@createTask', 'as' => 'projects.tasks.create']);
            });

            // Attachment methods (provided by HasAttachments trait)
            Route::group(['prefix' => '{project}/attachments'], function() {
                Route::post('attach', ['uses' => 'ProjectController@addAttachment', 'as' => 'projects.attachments.attach']);
                Route::post('detach', ['uses' => 'ProjectController@removeAttachment', 'as' => 'projects.attachments.detach']);
            });

            // Assignee methods (provided by HasAssignees trait)
            Route::group(['prefix' => '{project}/assignees'], function() {
                Route::post('add', ['uses' => 'ProjectController@addAssignee', 'as' => 'projects.assignees.add']);
                Route::post('remove', ['uses' => 'ProjectController@removeAssignee', 'as' => 'projects.assignees.remove']);
            });

            // Supplier methods (provided by HasSuppliers trait)
            Route::group(['prefix' => '{project}/suppliers'], function() {
                Route::post('add', ['uses' => 'ProjectController@addSupplier', 'as' => 'projects.suppliers.add']);
                Route::post('remove', ['uses' => 'ProjectController@removeSupplier', 'as' => 'projects.suppliers.remove']);
            });

            // Components
            Route::group(['prefix' => '{project}/components'], function() {

                // Component methods (provided by HasComponents trait)
                Route::get('{component_type}/create', ['uses' => 'ProjectController@createComponent', 'as' => 'projects.components.create']);
                Route::post('{component_type}/store', ['uses' => 'ProjectController@storeComponent', 'as' => 'projects.components.store']);
            });

            // Costs
            Route::group(['prefix' => '{project}/costs', 'permission_group' => ['finance']], function() {

                Route::post('/create', ['uses' => 'ProjectController@addCost', 'as' => 'projects.costs.create']);
                Route::get('{cost}/edit', ['uses' => 'CostController@edit', 'as' => 'projects.costs.edit']);
                Route::post('{cost}/update', ['uses' => 'CostController@update', 'as' => 'projects.costs.update']);
                Route::post('{cost}/delete', ['uses' => 'CostController@delete', 'as' => 'projects.costs.delete']);
            });

            // Bills
            Route::group(['prefix' => '{project}/bills', 'permission_group' => ['finance']], function() {

                Route::post('/create', ['uses' => 'ProjectController@addBill', 'as' => 'projects.bills.create']);
                Route::get('{bill}/edit', ['uses' => 'BillController@edit', 'as' => 'projects.bills.edit']);
                Route::post('{bill}/update', ['uses' => 'BillController@update', 'as' => 'projects.bills.update']);
            });
        });

        /*
         * Roles
         */
        Route::group(['middleware' => ['permissions'], 'prefix' => 'roles', 'permission_group' => 'permissions'], function() {

            Route::get('/', ['uses' => 'RoleController@index', 'as' => 'roles.index']);
            Route::post('/store', ['uses' => 'RoleController@store', 'as' => 'roles.store']);
            Route::get('/{role}', ['uses' => 'RoleController@details', 'as' => 'roles.details']);
            Route::post('/{role}/update', ['uses' => 'RoleController@update', 'as' => 'roles.update']);
            Route::post('/{role}/delete', ['uses' => 'RoleController@delete', 'as' => 'roles.delete']);
        });

        /*
         * Suppliers
         */
        Route::group(['middleware' => ['permissions'], 'prefix' => 'suppliers', 'permission_group' => 'suppliers'], function() {

            Route::get('/', ['uses' => 'SupplierController@index', 'as' => 'suppliers.index']);
            Route::post('/store', ['uses' => 'SupplierController@store', 'as' => 'suppliers.store']);
            Route::get('{supplier}', ['uses' => 'SupplierController@details', 'as' => 'suppliers.details']);
            Route::post('{supplier}/delete', ['uses' => 'SupplierController@delete', 'as' => 'suppliers.delete']);
            Route::post('{supplier}/update', ['uses' => 'SupplierController@update', 'as' => 'suppliers.update']);
            Route::post('{supplier}/verify', ['uses' => 'SupplierController@verify', 'as' => 'suppliers.verify']);

            // Autocomplete method
            Route::get('/lookup/autocomplete/{term?}', ['uses' => 'SupplierController@autocomplete', 'as' => 'suppliers.autocomplete']);

            // Media (provided by UploadsMedia trait)
            Route::post('{supplier}/media/upload', ['uses' => 'SupplierController@uploadMedia', 'as' => 'suppliers.media.upload']);

            // Customer address (provided by HasAddresses trait)
            Route::post('{supplier}/address/store', ['uses' => 'SupplierController@storeAddress', 'as' => 'suppliers.address.store']);

            // Customer contacts (provided by HasContact trait)
            Route::post('{supplier}/contact/store', ['uses' => 'SupplierController@storeContact', 'as' => 'suppliers.contact.store']);
            Route::get('{supplier}/contacts-download', ['uses' => 'SupplierController@downloadContacts', 'as' => 'suppliers.contacts.download']);
        });

        /*
         * Settings
         */
        Route::group(['middleware' => ['permissions'], 'prefix' => 'settings', 'permission_group' => 'settings'], function() {

            Route::get('/', ['uses' => 'SettingsController@index', 'as' => 'settings.index']);

            Route::get('/{type}/overview', ['uses' => 'SettingsController@overview', 'as' => 'settings.overview']);
            Route::post('/{type}/store', ['uses' => 'SettingsController@store', 'as' => 'settings.store']);
            Route::post('/{type}/delete', ['uses' => 'SettingsController@delete', 'as' => 'settings.delete']);
            Route::get('/{type}/{id}/edit', ['uses' => 'SettingsController@edit', 'as' => 'settings.edit']);
            Route::post('/{type}/{id}/update', ['uses' => 'SettingsController@update', 'as' => 'settings.update']);
        });

        /*
         * Components
         */
        Route::group(['middleware' => ['permissions'], 'prefix' => 'component-types', 'permission_group' => 'component-types'], function() {

            Route::get('/', ['uses' => 'ComponentTypeController@index', 'as' => 'component-types.index']);
            Route::post('/store', ['uses' => 'ComponentTypeController@store', 'as' => 'component-types.store']);
            Route::get('/{component_type}', ['uses' => 'ComponentTypeController@details', 'as' => 'component-types.details']);
            Route::post('{component_type}/delete', ['uses' => 'ComponentTypeController@delete', 'as' => 'component-types.delete']);

            // Update method (provided by HasEditableAttributes trait)
            Route::post('{component_type}/update', ['uses' => 'ComponentTypeController@update', 'as' => 'component-types.update']);

            // Routes for component type fields
            Route::group(['prefix' => '{component_type}/fields'], function() {

                Route::post('/store', ['uses' => 'ComponentTypeController@storeField', 'as' => 'component-types.fields.store']);
                Route::post('{component_field}/delete', ['uses' => 'ComponentTypeController@deleteField', 'as' => 'component-types.fields.delete']);
            });
        });

        /*
         * Tickets
         */
        Route::group(['middleware' => ['permissions'], 'prefix' => 'tickets', '' /* TODO: Permissions for tickets */], function() {

            Route::group(['prefix' => '{ticket}'], function() {
                Route::get('/view', ['uses' => 'TicketController@view', 'as' => 'tickets.view']);
            });
        });
    });

    /*
     * Supplier routes
     */
    Route::group(['prefix' => 'supplier', 'middleware' => ['auth', 'user_type'], 'user_type' => 'supplier', 'namespace' => 'Supplier'], function() {

        Route::group(['prefix' => 'quote'], function() {

            Route::get('/', ['uses' => 'QuoteController@index', 'as' => 'supplier.quotes.index']);
            Route::get('/{quote_request}', ['uses' => 'QuoteController@view', 'as' => 'supplier.quotes.view']);
            Route::post('/{quote_request}/submit', ['uses' => 'QuoteController@submit', 'as' => 'supplier.quotes.submit']);

            // Notes methods (provided by HasNotes trait)
            Route::group(['prefix' => '{quote_request}/notes'], function() {
                Route::post('add', ['uses' => 'QuoteController@addNote', 'as' => 'supplier.quotes.notes.add']);
                Route::post('search', ['uses' => 'QuoteController@searchNotes', 'as' => 'supplier.notes.search']);
            });
        });
    });

    /*
     * Customer routes
     */
    Route::group(['prefix' => 'customer', 'middleware' => ['auth', 'user_type'], 'user_type' => 'customer', 'namespace' => 'Customer'], function() {

        Route::group(['prefix' => 'tickets'], function() {

            Route::get('/create', ['uses' => 'TicketController@create', 'as' => 'customer.tickets.create']);
            Route::post('/store', ['uses' => 'TicketController@store', 'as' => 'customer.tickets.store']);
            Route::get('/{ticket}', ['uses' => 'TicketController@details', 'as' => 'customer.tickets.details']);

            // Notes methods (provided by HasNotes trait)
            Route::group(['prefix' => '{ticket}/notes'], function() {
                Route::post('add', ['uses' => 'TicketController@addNote', 'as' => 'tickets.notes.add']);
                Route::post('search', ['uses' => 'TicketController@searchNotes', 'as' => 'tickets.notes.search']);
            });
        });
    });
});

/*
 * Unguarded route for catching incoming email
 */
Route::group(['prefix' => 'mail'], function() {

    Route::post('inbox', ['uses' => 'MailController@inbox', 'as' => 'mail.inbox']);
});
