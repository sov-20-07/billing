/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.resize_enabled = false;
	config.removePlugins='forms';
	config.removeButtons = 'Iframe,NewPage,Save,Smiley';
	config.removeDialogTabs = 'link:upload;flash:Upload;image:Upload;';
};