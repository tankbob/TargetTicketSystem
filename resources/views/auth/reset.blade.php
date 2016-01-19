@extends('includes.layout')

@section('sectionTitle')
	Reset Password
@stop

@section('content')
<div class="row">
    <div class="auth-form col-md-8 col-md-offset-2">
		<h3 class="form-header">Reset Password</h3>

		{!! Form::open(array('url' => '/password/reset')) !!}
			@if (count($errors) > 0)
				<div class="alert alert-warning">
					<strong>Whoops!</strong> There were some problems with your input.<br><br>
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="token" value="{{ $token }}">

			<div class="form-group">
				<input type="email" class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="Email">
			</div>

			<div class="form-group">
				<input type="password" class="form-control input-lg" name="password" placeholder="Password">
			</div>

			<div class="form-group">
				<input type="password" class="form-control input-lg" name="password_confirmation" placeholder="Confirm Password">
			</div>

			<div class="row">
				<div class="col-sm-6">
					<a href="/auth/login" class="btn btn-info">
						Cancel
					</a>
				</div>
				<div class="col-sm-6">
					<button type="submit" class="btn btn-primary pull-right">
						Reset Password
					</button>
				</div>
			</div>
		{!! Form::close() !!}
    </div>
</div>
@endsection
