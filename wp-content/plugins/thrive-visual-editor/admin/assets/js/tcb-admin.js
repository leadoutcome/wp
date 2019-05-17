// This file was generated by modules-webmake (modules for web) project.
// See: https://github.com/medikoo/modules-webmake

(function (modules) {
	'use strict';

	var resolve, getRequire, wmRequire, notFoundError, findFile
	  , extensions = {".js":[],".json":[],".css":[],".html":[]}
	  , envRequire = typeof require === 'function' ? require : null;

	notFoundError = function (path) {
		var error = new Error("Could not find module '" + path + "'");
		error.code = 'MODULE_NOT_FOUND';
		return error;
	};
	findFile = function (scope, name, extName) {
		var i, ext;
		if (typeof scope[name + extName] === 'function') return name + extName;
		for (i = 0; (ext = extensions[extName][i]); ++i) {
			if (typeof scope[name + ext] === 'function') return name + ext;
		}
		return null;
	};
	resolve = function (scope, tree, path, fullPath, state, id) {
		var name, dir, exports, module, fn, found, ext;
		path = path.split('/');
		name = path.pop();
		if ((name === '.') || (name === '..')) {
			path.push(name);
			name = '';
		}
		while ((dir = path.shift()) != null) {
			if (!dir || (dir === '.')) continue;
			if (dir === '..') {
				scope = tree.pop();
				id = id.slice(0, id.lastIndexOf('/'));
			} else {
				tree.push(scope);
				scope = scope[dir];
				id += '/' + dir;
			}
			if (!scope) throw notFoundError(fullPath);
		}
		if (name && (typeof scope[name] !== 'function')) {
			found = findFile(scope, name, '.js');
			if (!found) found = findFile(scope, name, '.json');
			if (!found) found = findFile(scope, name, '.css');
			if (!found) found = findFile(scope, name, '.html');
			if (found) {
				name = found;
			} else if ((state !== 2) && (typeof scope[name] === 'object')) {
				tree.push(scope);
				scope = scope[name];
				id += '/' + name;
				name = '';
			}
		}
		if (!name) {
			if ((state !== 1) && scope[':mainpath:']) {
				return resolve(scope, tree, scope[':mainpath:'], fullPath, 1, id);
			}
			return resolve(scope, tree, 'index', fullPath, 2, id);
		}
		fn = scope[name];
		if (!fn) throw notFoundError(fullPath);
		if (fn.hasOwnProperty('module')) return fn.module.exports;
		exports = {};
		fn.module = module = { exports: exports, id: id + '/' + name };
		fn.call(exports, exports, module, getRequire(scope, tree, id));
		return module.exports;
	};
	wmRequire = function (scope, tree, fullPath, id) {
		var name, path = fullPath, t = fullPath.charAt(0), state = 0;
		if (t === '/') {
			path = path.slice(1);
			scope = modules['/'];
			if (!scope) {
				if (envRequire) return envRequire(fullPath);
				throw notFoundError(fullPath);
			}
			id = '/';
			tree = [];
		} else if (t !== '.') {
			name = path.split('/', 1)[0];
			scope = modules[name];
			if (!scope) {
				if (envRequire) return envRequire(fullPath);
				throw notFoundError(fullPath);
			}
			id = name;
			tree = [];
			path = path.slice(name.length + 1);
			if (!path) {
				path = scope[':mainpath:'];
				if (path) {
					state = 1;
				} else {
					path = 'index';
					state = 2;
				}
			}
		}
		return resolve(scope, tree, path, fullPath, state, id);
	};
	getRequire = function (scope, tree, id) {
		return function (path) {
			return wmRequire(scope, [].concat(tree), path, id);
		};
	};
	return getRequire(modules, [], '');
})({
	"workspace": {
		"admin": {
			"assets": {
				"js": {
					"src": {
						"base.js": function (exports, module, require) {
							/**
							 * Created by Ovidiu on 3/4/2017.
							 */

							var baseView, modalView, baseModel, baseCollection;
							(function ( $ ) {
								baseView = Backbone.View.extend( {
									/**
									 * Always try to return this !!!
									 *
									 * @returns {baseView}
									 */
									render: function () {
										return this;
									},
									/**
									 *
									 * Instantiate and open a new modal which has the view constructor assigned and send params further along
									 *
									 * @param ViewConstructor View constructor
									 * @param params
									 */
									modal: function ( ViewConstructor, params ) {
										return TVE_Dash.modal( ViewConstructor, params );
									}
								} );

								modalView = TVE_Dash.views.Modal.extend( {} );

								/**
								 * Sets Backbone to emulate HTTP requests for models
								 * HTTP_X_HTTP_METHOD_OVERRIDE set to PUT|POST|PATH|DELETE|GET
								 *
								 * @type {boolean}
								 */
								Backbone.emulateHTTP = true;

								baseModel = Backbone.Model.extend( {
									idAttribute: 'id'
								} );

								baseCollection = Backbone.Collection.extend( {
									/**
									 * helper function to get the last item of a collection
									 *
									 * @return Backbone.Model
									 */
									last: function () {
										return this.at( this.size() - 1 );
									}
								} );
							})( jQuery );

							module.exports = {
								base_view: baseView,
								modal_view: modalView,
								base_model: baseModel,
								base_collection: baseCollection
							};
						},
						"collections": {
							"breadcrumbs.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/13/2017.
								 */
								var base = require( '../base' ),
									BreadcrumbLink = require( '../models/breadcrumb-link' );

								module.exports = base.base_collection.extend( {
									model: base.base_collection.extend( {
										defaults: {
											hash: '',
											label: ''
										}
									} ),
									/**
									 * helper function allows adding items to the collection easier
									 *
									 * @param {string} route
									 * @param {string} label
									 */
									add_page: function ( route, label ) {
										var _model = new BreadcrumbLink( {
											hash: route,
											label: label
										} );
										return this.add( _model );
									}
								} );
							},
							"templates.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/6/2017.
								 */
								var base = require( '../base' ),
									TemplatesModel = require( '../models/templates' ),
									utils = require( '../util' );

								/**
								 * Contains templates + category association
								 */
								module.exports = base.base_collection.extend( {
									model: TemplatesModel,
									url: function () {
										return utils.ajaxurl( 'action=tcb_admin_ajax_controller&route=templates' );
									}
								} );
							},
							"tpl.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/8/2017.
								 */
								var base = require( '../base' ),
									TplModel = require( '../models/tpl' );

								module.exports = base.base_collection.extend( {
									model: TplModel
								} );
							}
						},
						"main.js": function (exports, module, require) {
							/**
							 * Created by Ovidiu on 3/4/2017.
							 */

							/**
							 * Settings for the underscore templates
							 * Enables <##> tags instead of <%%>
							 *
							 * @type {{evaluate: RegExp, interpolate: RegExp, escape: RegExp}}
							 */
							_.templateSettings = {
								evaluate: /<#([\s\S]+?)#>/g,
								interpolate: /<#=([\s\S]+?)#>/g,
								escape: /<#-([\s\S]+?)#>/g
							};

							(function ( $ ) {
								var TVE_Admin = window.TVE_Admin = window.TVE_Admin || {};
								TVE_Admin.globals = TVE_Admin.globals || {};

								$( function () {

									var Router = Backbone.Router.extend( {
										view: null,
										$el: $( '#tcb-admin-dashboard-wrapper' ),
										routes: {
											'templates': 'templates',
											'template/:id': 'template_view'
										},
										breadcrumbs: {
											col: null,
											view: null
										},
										init_breadcrumbs: function () {

											var BreadcrumbsView = require( './views/breadcrumbs' ),
												BreadcrumbsCollection = require( './collections/breadcrumbs' );

											this.breadcrumbs.col = new BreadcrumbsCollection();
											this.breadcrumbs.view = new BreadcrumbsView( {
												collection: this.breadcrumbs.col
											} )
										},
										/**
										 * set the current page - adds the structure to breadcrumbs and sets the new document title
										 *
										 * @param {string} section page hierarchy
										 * @param {string} label current page label
										 *
										 * @param {Array} [structure] optional the structure of the links that lead to the current page
										 */
										set_page: function ( section, label, structure ) {
											this.breadcrumbs.col.reset();
											structure = structure || {};
											/* Thrive Dashboard is always the first element */
											this.breadcrumbs.col.add_page( TVE_Admin.dash_url, TVE_Admin.t.dashboard, true );
											_.each( structure, _.bind( function ( item ) {
												this.breadcrumbs.col.add_page( item.route, item.label );
											}, this ) );
											/**
											 * last link - no need for route
											 */
											this.breadcrumbs.col.add_page( '', label );
											/* update the page title */
											var $title = $( 'head > title' );
											if ( ! this.original_title ) {
												this.original_title = $title.html();
											}
											$title.html( label + ' &lsaquo; ' + this.original_title )
										},
										templates: function () {
											this.set_page( 'templates', TVE_Admin.t.templates );
											var self = this,
												TemplateList = require( './views/template-list' );

											if ( this.view ) {
												this.view.remove();
											}

											TVE_Dash.showLoader();

											TVE_Admin.globals.templates.fetch( {
												update: true,
												success: function ( model, response, options ) {
													self.view = new TemplateList( {
														collection: TVE_Admin.globals.templates
													} );
													self.$el.html( self.view.render().$el );
												},
												error: function ( collection, response, options ) {
													TVE_Dash.err( response.responseText );
													TVE_Dash.hideLoader();
												}
											} );
										},
										template_view: function ( id ) {
											if ( this.view ) {
												this.view.remove();
											}

											if ( TVE_Dash.opened_modal_view ) {
												TVE_Dash.opened_modal_view.close();
											}
											if ( isNaN( parseInt( id ) ) ) {
												TVE_Admin.router.navigate( '#templates', {trigger: true} );
												return;
											}

											var self = this,
												TplModel = require( './models/tpl' ),
												model = new TplModel( {id: parseInt( id )} ),
												TemplateItem = require( './views/template-item' );

											TVE_Dash.showLoader();

											model.fetch( {
												cache: false,
												success: function ( model, response, options ) {
													self.view = new TemplateItem( {
														model: model
													} );
													self.$el.html( self.view.render().$el );

													self.set_page( 'template/' + model.get( 'id' ), model.get( 'name' ), [
														{
															route: 'templates',
															label: 'Templates'
														},
														{
															route: 'template/' + model.get( 'id' ),
															label: model.get( 'name' )
														}
													] );
												}
											} ).error( function ( response ) {
												TVE_Dash.err( response.responseText );
												TVE_Dash.hideLoader();
												TVE_Admin.router.navigate( '#templates', {trigger: true} );
											} );
										}
									} );

									var TemplatesCollection = require( './collections/templates' );
									TVE_Admin.globals.templates = new TemplatesCollection( {} );

									TVE_Admin.router = new Router;
									TVE_Admin.router.init_breadcrumbs();

									Backbone.history.stop();
									Backbone.history.start( {hashchange: true} );
									if ( ! Backbone.history.fragment ) {
										TVE_Admin.router.navigate( '#templates', {trigger: true} );
									}
								} );
							})( jQuery );
						},
						"models": {
							"breadcrumb-link.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/13/2017.
								 */
								var base = require( '../base' );
								module.exports = base.base_model.extend( {
									defaults: {
										id: '',
										hash: '',
										label: '',
										full_link: false
									},
									/**
									 * we pass only hash and label, and build the ID based on the label
									 *
									 * @param {object} att
									 */
									initialize: function ( att ) {
										if ( ! this.get( 'id' ) ) {
											this.set( 'id', att.label.replace( / /g, '' ).toLowerCase() );
										}
										this.set( 'full_link', att.hash.match( /^http/ ) );
									},
									/**
									 *
									 * @returns {String}
									 */
									get_url: function () {
										return this.get( 'full_link' ) ? this.get( 'hash' ) : ( '#' + this.get( 'hash' ));
									}
								} );
							},
							"template-category.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/7/2017.
								 */
								var base = require( '../base' ),
									utils = require( '../util' );

								module.exports = base.base_model.extend( {
									defaults: {
										id: '',
										category: []
									},
									url: function () {
										return utils.ajaxurl( 'action=tcb_admin_ajax_controller&route=templatecategory' );
									}
								} );
							},
							"templates.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/9/2017.
								 */
								var base = require( '../base' ),
									utils = require( '../util' );

								module.exports = base.base_model.extend( {
									defaults: {
										id: '',
										name: '',
										tpl: []
									},
									url: function () {
										var _url = utils.ajaxurl( 'action=tcb_admin_ajax_controller&route=templatemodel' );

										if ( _.isNumber( this.get( 'id' ) ) ) {
											_url += '&id=' + this.get( 'id' );
										}

										return _url;
									}
								} );
							},
							"tpl.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/8/2017.
								 */
								var base = require( '../base' ),
									utils = require( '../util' );

								module.exports = base.base_model.extend( {
									defaults: {
										id: ''
									},
									url: function () {
										var _url = utils.ajaxurl( 'action=tcb_admin_ajax_controller&route=usertpl' );

										if ( _.isNumber( this.get( 'id' ) ) ) {
											_url += '&id=' + this.get( 'id' );
										}

										return _url;
									}
								} );
							}
						},
						"util.js": function (exports, module, require) {
							/**
							 * Created by Ovidiu on 3/5/2017.
							 */

							var util = {};


							(function ( $ ) {
								/**
								 * Override Backbone ajax call and append wp security token
								 *
								 * @returns {*}
								 */
								Backbone.ajax = function () {
									if ( arguments[0].url.indexOf( '_nonce' ) === - 1 ) {
										arguments[0]['url'] += "&_nonce=" + TVE_Admin.admin_nonce;
									}

									return Backbone.$.ajax.apply( Backbone.$, arguments );
								};

								/**
								 * pre-process the ajaxurl admin js variable and append a querystring to it
								 * some plugins are adding an extra parameter to the admin-ajax.php url. Example: admin-ajax.php?lang=en
								 *
								 * @param {string} [query_string] optional, query string to be appended
								 */
								util.ajaxurl = function ( query_string ) {
									var _q = ajaxurl.indexOf( '?' ) !== - 1 ? '&' : '?';
									if ( ! query_string || ! query_string.length ) {
										return ajaxurl + _q + '_nonce=' + TVE_Admin.admin_nonce;
									}
									query_string = query_string.replace( /^(\?|&)/, '' );
									query_string += '&_nonce=' + TVE_Admin.admin_nonce;

									return ajaxurl + _q + query_string;
								};

							})( jQuery );

							module.exports = util;
						},
						"views": {
							"breadcrumbs.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/13/2017.
								 */
								var base = require( '../base' );
								module.exports = base.base_view.extend( {
									el: jQuery( '#tcb-admin-breadcrumbs-wrapper' )[0],
									template: TVE_Dash.tpl( 'breadcrumbs' ),
									/**
									 * setup collection listeners
									 */
									initialize: function () {
										this.$title = jQuery( 'head > title' );
										this.original_title = this.$title.html();
										this.listenTo( this.collection, 'change', this.render );
										this.listenTo( this.collection, 'add', this.render );
									},
									/**
									 * render the html
									 */
									render: function () {
										this.$el.empty().html( this.template( {links: this.collection} ) );
									}
								} );
							},
							"modal-delete.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/8/2017.
								 */
								var base = require( '../base' );
								var TVE_Admin = TVE_Admin || {};
								module.exports = base.modal_view.extend( {
									template: TVE_Dash.tpl( 'modals/delete-confirmation' ),
									events: {
										'click .tvd-modal-submit': 'yes'
									},
									afterInitialize: function ( args ) {
										this.text = args.text;
										this.extra_setting = (args.extra_setting && args.extra_setting === 1) ? 1 : 0;
									},
									afterRender: function () {
										if ( this.extra_setting ) {
											this.$( '.tcb-admin-extra-setting-row' ).removeClass( 'hidden' );
										}
									},
									yes: function ( event ) {
										var $btn = jQuery( event.currentTarget ), self = this;
										this.btnLoading( $btn );
										TVE_Dash.showLoader();
										this.model.destroy( {
											data: {extra_setting_check: (self.$( '#tcb-admin-extra-setting-check' ).is( ':checked' )) ? 1 : 0},
											processData: true,
											wait: true,
											success: function ( model, response ) {
												TVE_Dash.success( response.text );
											},
											error: function ( model, response ) {
												TVE_Dash.err( response.responseText );
											},
											complete: function () {
												self.close();
												TVE_Dash.hideLoader();
											}
										} );
									}
								} );
							},
							"modal-move-category.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/10/2017.
								 */
								var base = require( '../base' );
								module.exports = base.modal_view.extend( {
									template: TVE_Dash.tpl( 'modals/move-category' ),
									events: {
										'click .tvd-modal-submit': 'save'
									},
									save: function () {
										var self = this;
										TVE_Dash.showLoader();
										this.model.set( 'id_category', this.$( '#tcb-admin-t-categ-combo' ).val() );

										this.model.save( null, {
											wait: true,
											success: function ( model, response ) {
												TVE_Dash.success( response.text );
												window.TVE_Admin.router.templates();
											},
											error: function ( model, response ) {
												TVE_Dash.err( response.responseText );
											},
											complete: function () {
												TVE_Dash.hideLoader();
												self.close();
											}
										} );
									}
								} );
							},
							"modal-new-category.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/6/2017.
								 */
								var base = require( '../base' );
								module.exports = base.modal_view.extend( {
									template: TVE_Dash.tpl( 'modals/new-category' ),
									className: 'tvd-modal tvd-modal-fixed-footer',
									events: {
										'click #tcb-add-new-category-input': 'addNewCategoryInput',
										'click .tcb-admin-delete-text-element': 'deleteTextElement',
										'click .tvd-modal-submit': 'save'
									},
									afterInitialize: function ( args ) {
									},
									afterRender: function () {
										this.addNewCategoryInput();
									},
									addNewCategoryInput: function () {
										var $clone = this.$( '#tcb-categ-input-template' ).clone();
										this.$( '#tcb-categ-input' ).append( $clone.html() );
									},
									deleteTextElement: function ( ev ) {
										var $target = jQuery( ev.target );
										$target.closest( '.tcb-admin-text-element-wrapper' )[0].remove();
									},
									save: function () {
										var categ_arr = [],
											self = this;
										this.$( '.tcb-category-input-item' ).each( function ( index, input ) {
											if ( input.value ) {
												categ_arr.push( input.value );
											}
										} );

										if ( categ_arr.length > 0 ) {
											TVE_Dash.showLoader();
											this.model.set( 'category', categ_arr );

											this.model.save( null, {
												wait: true,
												success: function ( model, response ) {
													TVE_Dash.success( response.text );
													window.TVE_Admin.router.templates();
												},
												error: function ( model, response ) {
													TVE_Dash.err( response.responseText );
												},
												complete: function () {
													TVE_Dash.hideLoader();
													self.close();
												}
											} );

										} else {
											TVE_Dash.err( TVE_Admin.t.no_categories );
										}


									}
								} );
							},
							"template-c-item.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/7/2017.
								 */
								var base = require( '../base' ),
									TemplateItem = require( './template-t-item' ),
									TextEdit = require( './text-edit' ),
									ModalDelete = require( './modal-delete' ),
									TplCollection = require( '../collections/tpl' );

								module.exports = base.base_view.extend( {
									template: TVE_Dash.tpl( 'c-item' ),
									className: 'tcb-admin-c-item-row',
									events: {
										'click .tcb-admin-edit-category-name': 'editCategoryTitle',
										'click .tcb-admin-delete-category-item': 'deleteCategory',
										'click .tcb-admin-show-more-less-btn': 'showMoreShowLess'
									},
									index: 0,
									initialize: function ( args ) {
										this.collection = new TplCollection( this.model.get( 'tpl' ) );

										this.listenTo( this.collection, 'remove', function () {
											window.TVE_Admin.router.templates();
										} );
										this.listenTo( this.model, 'destroy', function () {
											window.TVE_Admin.router.templates();
										} );
									},
									render: function () {
										this.$el.html( this.template( {model: this.model} ) );
										this.$categoryTitle = this.$( '.tvd-card-title' );
										this.collection.each( this.renderOneTemplateItem, this );

										if ( this.index > 5 ) {
											this.$( '.tcb-admin-show-more-less' ).removeClass( 'hidden' );
										}

										return this;
									},
									renderOneTemplateItem: function ( item ) {
										this.index ++;
										var view = new TemplateItem( {
											model: item,
											index: this.index
										} );

										this.$( '.tcb-admin-template-t-item' ).append( view.render().$el );

										return this;
									},
									showMoreShowLess: function () {
										var $showHideTpls = this.$( '.tcb-admin-show-hide-tpl' ),
											$showHideBtn = this.$( '.tcb-admin-show-more-less-btn' );
										
										if ( $showHideTpls.is( ':visible' ) ) {
											$showHideTpls.addClass( 'hidden' );
											$showHideBtn.html( TVE_Admin.t.show_more );
										} else {
											$showHideTpls.removeClass( 'hidden' );
											$showHideBtn.html( TVE_Admin.t.show_less );
										}
									},
									deleteCategory: function () {
										this.modal( ModalDelete, {
											model: this.model,
											text: TVE_Admin.t.delete_category_txt.replace( '%s', this.model.get( 'name' ) ),
											extra_setting: 1,
											'max-width': '60%',
											width: '750px',
											in_duration: 200,
											out_duration: 0
										} );
									},
									/**
									 * Hides Title and shows Edit Category Title input
									 */
									editCategoryTitle: function () {
										var self = this,
											edit_btn = this.$( '.tcb-admin-edit-category-name' ),
											edit_model = new Backbone.Model( {
												value: this.model.get( 'name' ),
												label: '',
												required: true
											} ),
											textEdit = new TextEdit( {
												model: edit_model,
												tagName: 'div'
											} );

										edit_btn.hide();

										this.$categoryTitle.hide().after( textEdit.render().$el );
										edit_model.on( 'change:value', function () {
											self.saveCategoryName.apply( self, arguments );
											textEdit.remove();
											self.$categoryTitle.show();
											edit_btn.show();
										} );
										edit_model.on( 'tcb_admin_no_change', function () {
											self.$categoryTitle.html( self.model.get( 'name' ) ).show();
											textEdit.remove();
											edit_btn.show();
										} );
										textEdit.focus();
									},
									saveCategoryName: function ( edit_model, new_value ) {
										var self = this;
										this.model.set( 'name', new_value );
										this.model.save( null, {
											success: function ( model, response ) {
												self.$categoryTitle.html( new_value );
												TVE_Dash.success( response.text );
											},
											error: function ( model, response ) {
												TVE_Dash.err( response.responseText );
											}
										} );
									}
								} );
							},
							"template-item.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/9/2017.
								 */
								var base = require( '../base' );
								module.exports = base.base_view.extend( {
									template: TVE_Dash.tpl( 'item' ),
									render: function () {
										this.$el.html( this.template( {model: this.model} ) );
										TVE_Dash.hideLoader();
										return this;
									}
								} );
							},
							"template-list.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/5/2017.
								 */
								var base = require( '../base' ),
									NewCategModal = require( './modal-new-category' ),
									TemplateCategoryItem = require( './template-c-item' ),
									TemplateCategoryModel = require( '../models/template-category' );

								module.exports = base.base_view.extend( {
									template: TVE_Dash.tpl( 'list' ),
									events: {
										'click #tcb-add-new-category': 'addNewCategory'
									},
									render: function () {
										this.$el.html( this.template( {} ) );
										this.collection.each( this.renderOne, this );
										TVE_Dash.hideLoader();
										return this;
									},
									renderOne: function ( item ) {
										var view = new TemplateCategoryItem( {
											model: item
										} );
										this.$el.append( view.render().$el );
										return this;
									},
									addNewCategory: function () {
										this.modal( NewCategModal, {
											model: new TemplateCategoryModel( {} )
										} );
									}
								} );
							},
							"template-t-item.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/8/2017.
								 */
								var base = require( '../base' ),
									TextEdit = require( './text-edit' ),
									MoveCategory = require( './modal-move-category' ),
									ModalDelete = require( './modal-delete' );

								module.exports = base.base_view.extend( {
									template: TVE_Dash.tpl( 't-item' ),
									className: 'tvd-col tcb-admin-c-item-card',
									events: {
										'click .tcb-admin-edit-template-name': 'editTitle',
										'click .tcb-admin-icon-move': 'moveCategory',
										'click .tcb-admin-delete-template-item': 'deleteTemplate'
									},
									initialize: function ( args ) {
										this.index = args.index;
									},
									render: function () {
										this.$el.html( this.template( {model: this.model} ) );
										this.$templateTitle = this.$( '.tvd-card-title' );

										if ( this.index > 5 ) {
											this.$el.addClass( 'tcb-admin-show-hide-tpl hidden' );
										}

										return this;
									},
									deleteTemplate: function () {
										this.modal( ModalDelete, {
											model: this.model,
											text: TVE_Admin.t.delete_template_txt.replace( '%s', this.model.get( 'name' ) ),
											extra_setting: 0,
											'max-width': '60%',
											width: '750px',
											in_duration: 200,
											out_duration: 0
										} );
									},
									moveCategory: function () {
										this.modal( MoveCategory, {
											model: this.model,
											'max-width': '60%',
											width: '750px',
											in_duration: 200,
											out_duration: 0
										} );
									},
									/**
									 * Hides Title and shows Edit Title input
									 */
									editTitle: function () {
										var self = this,
											edit_btn = this.$( '.tcb-admin-edit-template-name' ),
											edit_model = new Backbone.Model( {
												value: this.model.get( 'name' ),
												label: '',
												required: true
											} );

										edit_btn.hide();

										var textEdit = new TextEdit( {
											model: edit_model,
											tagName: 'div'
										} );
										this.$templateTitle.hide().after( textEdit.render().$el );
										edit_model.on( 'change:value', function () {
											self.saveName.apply( self, arguments );
											textEdit.remove();
											self.$templateTitle.show();
											edit_btn.show();
										} );
										edit_model.on( 'tcb_admin_no_change', function () {
											self.$templateTitle.html( self.model.get( 'name' ) ).show();
											textEdit.remove();
											edit_btn.show();
										} );
										textEdit.focus();
									},
									/**
									 * Saves the new name and hides the input value
									 */
									saveName: function ( edit_model, new_value ) {
										var self = this;

										this.model.set( 'name', new_value );
										this.model.save( null, {
											success: function ( model, response ) {
												self.$templateTitle.html( new_value );
												TVE_Dash.success( response.text );
											},
											error: function ( model, response ) {
												TVE_Dash.err( response.responseText );
											}
										} );
									}

								} );
							},
							"text-edit.js": function (exports, module, require) {
								/**
								 * Created by Ovidiu on 3/8/2017.
								 */
								var base = require( '../base' );

								module.exports = base.base_view.extend( {
									className: 'tvd-input-field',
									template: TVE_Dash.tpl( 'text-edit' ),
									events: {
										'keyup input': 'keyup',
										'change input': function () {
											var trim_value = this.input.val().trim();
											if ( ! trim_value ) {
												this.input.addClass( 'tvd-invalid' );
												return false;
											}
											this.model.set( 'value', trim_value );
											return false;
										},
										'blur input': function () {
											this.model.trigger( 'tcb_admin_no_change' );
										}
									},
									keyup: function ( event ) {
										if ( event.which === 27 ) {
											this.model.trigger( 'tcb_admin_no_change' );
										}
									},
									render: function () {
										this.$el.html( this.template( {item: this.model} ) );
										this.input = this.$( 'input' );

										return this;
									},
									focus: function () {
										this.input.focus().select();
									}
								} );
							}
						}
					}
				}
			}
		}
	}
})("workspace/admin/assets/js/src/main");