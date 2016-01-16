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
			'plugins/jquery.growl.css',
			'app.css'
		], 'public/build/css/app.css')
		.scripts([
			'plugins/jquery-1.11.3.min.js',
			'plugins/bootstrap.min.js',
			'plugins/jquery-sortable.js',
			'plugins/jquery.maskedinput.min.js',
			'plugins/jquery.validate.min.js',
			'plugins/additional-methods.min.js',
			'plugins/nprogress.js',
			'plugins/jquery.smooth-scroll.js',
			'plugins/jquery.growl.js',
			'app.js'
		], 'public/build/js/app.js')
		.version(['build/css/app.css', 'build/js/app.js']);
});
