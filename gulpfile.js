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
		.styles(['all.css'])
		.scripts(['all.js'])
		.version(['css/all.css', 'js/all.js'])
		;
});
