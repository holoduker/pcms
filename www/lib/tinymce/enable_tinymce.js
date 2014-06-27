tinyMCE.init({
	theme : "advanced",
	mode : "textareas",
	language: "ru", 
	editor_selector : "clsRichFormControl",
	plugins : "paste",

	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,bullist,numlist,separator,undo,redo,separator,link,unlink,separator,removeformat,code",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",

	extended_valid_elements : "a[name|href|target|title|onclick]",
	theme_advanced_resize_horizontal : false,
	theme_advanced_resizing : true,
	paste_auto_cleanup_on_paste : true,
	paste_strip_class_attributes : "all"
});
