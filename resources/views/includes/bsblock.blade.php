<div class="form-group @if($errors->has($name)) has-error dark @endif">
	{!! Form::label($name, $text, ['class' => 'col-sm-2 control-label'])!!}
	<div class="col-sm-10">

	@if($type == 'text')
	{!! Form::$type($name, $default, ['class' => 'form-control', 'id' => $name]) !!}
	@endif

	@if($type == 'number')
	{!! Form::input('number', $name, $default, ['class' => 'form-control', 'id' => $name]) !!}
	@endif

	@if($type == 'textarea')
	{!! Form::$type($name, $default, ['class' => 'form-control redactor', 'id' => $name]) !!}
	@endif

	@if($type == 'password')
	{!! Form::$type($name, ['class' => 'form-control']) !!}
	@endif

	@if($type == 'select')
	{!! Form::$type($name, $data, $default, ['class' => 'form-control', 'id' => $name]) !!}
	@endif

	@if($type == 'multiselect')
	{!! Form::select($name."[]", $data, $default, ['class' => 'form-control', 'id' => $name, 'multiple'=>'multiple']) !!}
	@endif

	@if($type == 'checkbox')
		{!! Form::checkbox($name, 1, $default, ['class' => 'form-control', 'id' => $name, 'style' => 'width: 25px; height: 25px;']) !!}
	@endif

	@if($type == 'position')
		{!! Form::select($name, ['C' => 'Center', 'R' => 'Right', 'L' => 'Left'], $default, ['class' => 'form-control', 'id' => $name]) !!}
	@endif

	@if($type == 'boolean')
		{!! Form::select($name, [1 => 'Yes', 0 => 'No'], $default, ['class' => 'form-control', 'id' => $name]) !!}
	@endif

	@if($type == 'background')
		If no background file is selected, the default one will be used
		{!! Form::file($name, ['class' => 'form-control', 'id' => 'b'.$name]) !!}
		<div class="preview-logo panel col-xs-12 col-md-6 col-md-offset-3">
			<div class="panel-heading">
				Preview Background
			</div>
			<div class="panel-body text-center">
				<img @if($default)src="/backgrounds/{!!@$default!!}"@endif id="pb{!!$name!!}" style="max-height: 200px; max-width: 400px;"></img>
			</div>
		</div> 
		
		<script type="text/javascript">
			function readURL(input) {
		        if (input.files && input.files[0]) {
		            var reader = new FileReader();
		            
		            reader.onload = function (e) {
		                $('#pb').attr('src', e.target.result);
		            }
		            
		            reader.readAsDataURL(input.files[0]);
		        }
		    }

		    $(document).ready(function() {
			    $("#b{!!$name!!}").on('change', function(){
			        if (this.files && this.files[0]) {
		            var reader = new FileReader();
		            
		            reader.onload = function (e) {
		                $("#pb{!!$name!!}").attr('src', e.target.result);
		            }
		            
		            reader.readAsDataURL(this.files[0]);
		        }
			    });
			});
		</script>

		<div class="col-xs-12"></div>
	@endif

	@if($type == 'file')
		{!! Form::$type($name, ['class' => 'form-control', 'id' => $name]) !!}
	@endif

	@if($type == 'time')
		<input type="time" name="{!!$name!!}" id="{!!$name!!}" data-provide="time" class="form-control" value="{!!$default!!}">
	@endif

	@if($type == 'date')
		<input type="date" name="{!!$name!!}" id="{!!$name!!}" data-provide="date" class="form-control" value="{!!$default!!}" date-format="Y-m-d">
	@endif

	@if($type == 'video')
		{!! Form::text($name, $default, ['class' => 'form-control video-url', 'id' => 'v'.$name]) !!}
		<p>
			<br/>
			Please insert in the text box just the video id (the code written after 'v=') as the picture below:
			<img alt="videoHelper" src="/logo/Video Guide.png"> 
		</p>
		<div class="preview-video panel col-xs-12 col-md-8 col-md-offset-2">
			<div class="panel-heading">
				Preview Video
			</div>
			<div class="panel-body text-center">
				<iframe class="youtube-video" id="vv{!!$name!!}" width="420" height="315"
				src="http://www.youtube.com/embed/{!! $default !!}">
				</iframe>
			</div>
		</div>
		<div class="col-xs-12"></div>
	@endif

	@if($type == 'captcha')
	{!! Form::text($name, null, ['class' => 'form-control', 'style' => 'margin-bottom:15px;']) !!}
		@if ($errors->has($name))
			<p class="help-block">{!! $errors->first($name) !!}</p>
		@endif
	{!! HTML::image(Captcha::img(), 'Captcha image') !!}
	@elseif ($errors->has($name))
		<p class="help-block">{!! $errors->first($name) !!}</p>
	@endif

	</div>
</div>