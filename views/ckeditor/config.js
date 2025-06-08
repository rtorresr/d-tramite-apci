/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.language = 'es';
			//config.uiColor = '#F7B42C';
			config.height = 500;
			config.toolbarCanCollapse = true;
			// Define changes to default configuration here. For example:
			// config.language = 'fr';
			// config.uiColor = '#AADC6E';
			// The toolbar groups arrangement, optimized for two toolbar rows.	
			config.toolbarGroups = [
				{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
				{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
				{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
				{ name: 'forms', groups: [ 'forms' ] },
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
				{ name: 'links', groups: [ 'links' ] },
				{ name: 'insert', groups: [ 'insert' ] },
				'/',
				{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
				{ name: 'styles', groups: [ 'styles' ] },
				{ name: 'colors', groups: [ 'colors' ] },
				{ name: 'tools', groups: [ 'tools' ] },
				{ name: 'others', groups: [ 'others' ] },
				{ name: 'about', groups: [ 'about' ] }
			];

			config.removeButtons = 'Form,Radio,TextField,Checkbox,Textarea,Select,Button,ImageButton,HiddenField,Replace,SelectAll,Templates,Save,Print,NewPage,Preview,Cut,BidiLtr,BidiRtl,Language,Image,Flash,Smiley,SpecialChar,PageBreak,Iframe,ShowBlocks,CreateDiv';

			// Set the most common block elements.
			config.format_tags = 'p;h1;h2;h3;pre';

			// Simplify the dialog windows.
			config.removeDialogTabs = 'image:advanced;link:advanced';
};
