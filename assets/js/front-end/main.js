jQuery( document ).ready( function( $ ) {
	require( [ 'models/formCollection', 'models/formModel', 'models/fieldCollection', 'controllers/loadControllers', 'views/mainLayout'], function( formCollection, FormModel, FieldCollection, LoadControllers, mainLayout ) {

		var NinjaForms = Marionette.Application.extend({
			forms: {},
			initialize: function( options ) {

				var that = this;
				Marionette.Renderer.render = function(template, data){
					var template = that.template( template );
					return template( data );
				};

				// Underscore one-liner for getting URL Parameters
				this.urlParameters = _.object(_.compact(_.map(location.search.slice(1).split('&'), function(item) {  if (item) return item.split('='); })));

				if( 'undefined' != typeof this.urlParameters.nf_resume ) {
					this.listenTo(nfRadio.channel('form-' + this.urlParameters.nf_resume), 'loaded', this.restart);
				}

				var loadControllers = new LoadControllers();
				nfRadio.channel( 'app' ).trigger( 'after:loadControllers' );

				nfRadio.channel( 'app' ).reply( 'get:template', this.template );
			},
			
			onStart: function() {
				var formCollection = nfRadio.channel( 'app' ).request( 'get:forms' );
				_.each( formCollection.models, function( form, index ) {
					var layoutView = new mainLayout( { model: form, fieldCollection: form.get( 'fields' ) } );			
					nfRadio.channel( 'form' ).trigger( 'render:view', layoutView );
				} );
			},

			restart: function( formModel ) {
				if( 'undefined' != typeof this.urlParameters.nf_resume ){
					var data = {
						'action': 'nf_ajax_submit',
						'security': nfFrontEnd.ajaxNonce,
						'nf_resume': this.urlParameters
					};

					nfRadio.channel( 'form-' + formModel.get( 'id' ) ).trigger( 'disable:submit' );
					nfRadio.channel( 'form-' + formModel.get( 'id' ) ).trigger( 'processingLabel' );

					this.listenTo( nfRadio.channel( 'form' ), 'render:view', function() {
						/**
						 * TODO: This needs to be re-worked for backbone. It's not dynamic enough.
						 */
						/*
						 * Hide form fields (but not the submit button).
						 */
						jQuery( '#nf-form-' + formModel.get( 'id' ) + '-cont .nf-field-container:not(.submit-container)' ).hide();
					});

					// TODO: Refactor Duplication
					jQuery.ajax({
						url: nfFrontEnd.adminAjax,
						type: 'POST',
						data: data,
						cache: false,
						success: function( data, textStatus, jqXHR ) {
							try {
						   		var response = jQuery.parseJSON( data );
						        nfRadio.channel( 'forms' ).trigger( 'submit:response', response, textStatus, jqXHR, formModel.get( 'id' ) );
						    	nfRadio.channel( 'form-' + formModel.get( 'id' ) ).trigger( 'submit:response', response, textStatus, jqXHR );
							} catch( e ) {
								console.log( 'Parse Error' );
							}

					    },
					    error: function( jqXHR, textStatus, errorThrown ) {
					        // Handle errors here
					        console.log('ERRORS: ' + textStatus);
					        // STOP LOADING SPINNER
							nfRadio.channel( 'forms' ).trigger( 'submit:response', 'error', textStatus, jqXHR, errorThrown );
					    }
					});
				}
			},

			template: function( template ) {
				return _.template( $( template ).html(),  {
					evaluate:    /<#([\s\S]+?)#>/g,
					interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
					escape:      /\{\{([^\}]+?)\}\}(?!\})/g,
					variable:    'data'
				} );
			}
		});
	
		var ninjaForms = new NinjaForms();
		ninjaForms.start();		
	} );
} );