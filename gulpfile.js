var elixir = require('laravel-elixir');
if(elixir.config.babel) {
	elixir.config.babel.enabled = false;
}

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	return mix
		.styles([
			'plugins/bootstrap.min.css',
			'all.css'
		])
		.scripts([
			'plugins/jquery-1.11.3.min.js',
			'plugins/bootstrap.min.js',
			'plugins/jquery-sortable.js',
			'plugins/jquery.maskedinput.min.js',
			'plugins/jquery.validate.min.js',
			'plugins/additional-methods.min.js',
			'plugins/nprogress.js',
			'all.js'
		])
		.version(['css/all.css', 'js/all.js']);
});
