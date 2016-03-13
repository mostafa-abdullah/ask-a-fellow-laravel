@extends('layouts.app')

@section('content')
    <form id="register_form" class="form-horizontal center-block" style="width: 40%; background-color: rgba(255, 175, 108, 0.64); padding: 40px; padding-right: 20px; margin-bottom: 150px; min-width: 250px;" method="POST" action="/register">
        {!! csrf_field() !!}
        <span class="input input--manami">
            <input class="input__field input__field--manami" type="text" required id="register_firstname" name="first_name" value="{{ old('first_name') }}">
            <label class="input__label input__label--manami" for="firstName">
                <span class="input__label-content input__label-content--manami">First Name</span>
            </label>
            @if ($errors->has('first_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('first_name') }}</strong>
                </span>
            @endif
        </span>
        <span class="input input--manami">
            <input class="input__field input__field--manami" type="text" required id="register_lastname" name="last_name" value="{{ old('first_name') }}">
            <label class="input__label input__label--manami">
                <span class="input__label-content input__label-content--manami">Last Name</span>
            </label>
            @if ($errors->has('last_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
            @endif
        </span>
        <span class="input input--manami">
            <input class="input__field input__field--manami" type="email" required id="register_email" name="email" value="{{ old('email') }}">
            <label class="input__label input__label--manami">
                <span class="input__label-content input__label-content--manami">Email</span>
            </label>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </span>
        <span class="input input--manami">
            <input class="input__field input__field--manami" type="password" required id="register_password" name="password">
            <label class="input__label input__label--manami">
                <span class="input__label-content input__label-content--manami">Password</span>
            </label>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </span>
        <span class="input input--manami">
            <input class="input__field input__field--manami" type="password" required id="register_confirm_password" name="password_confirmation">
            <label class="input__label input__label--manami">
                <span class="input__label-content input__label-content--manami">Confirm Password</span>
            </label>
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </span>
        <div style="color:red" id="register_feedback"></div>
        <div class="form-group">
            <div class=" col-sm-10" style="margin-top:20px; margin-left:10px;">
                <!--<a class="submit" style="float:right;" href="#">Register</a>-->
                <input type="submit" class="btn btn-default submit" style="background-color:#FF953D; border: 1px solid #CC953D;float:right;" href="#" value="Register" id="register_submit">
            </div>
        </div>
    </form>
    <style>
        .help-block{
            color:red;
        }
    </style>
    <link href="css/formInput.css" rel="stylesheet">
    <script type="text/javascript" src="js/classie.js"></script>
    <script>
        (function() {
            // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
            if (!String.prototype.trim) {
                (function() {
                    // Make sure we trim BOM and NBSP
                    var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
                    String.prototype.trim = function() {
                        return this.replace(rtrim, '');
                    };
                })();
            }

            [].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
                // in case the input is already filled..
                if( inputEl.value.trim() !== '' ) {
                    classie.add( inputEl.parentNode, 'input--filled' );
                }

                // events:
                inputEl.addEventListener( 'focus', onInputFocus );
                inputEl.addEventListener( 'blur', onInputBlur );
            } );

            function onInputFocus( ev ) {
                classie.add( ev.target.parentNode, 'input--filled' );
            }

            function onInputBlur( ev ) {
                if( ev.target.value.trim() === '' ) {
                    classie.remove( ev.target.parentNode, 'input--filled' );
                }
            }
        })();
    </script>
@endsection
