@extends('template.main')
@section('content')
<div class="container d-flex justify-content-center " style="margin-top: 100px;">
    <div class="w-50 card">
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                 @enderror
                </div>
                <div class="mb-3">
                    <label for="textField" class="form-label">Email</label>
                    <input name="email" type="text" class="form-control" id="textField" placeholder="Enter text here">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="textField" class="form-label">Password</label>
                    <input  name="password" type="password" class="form-control" id="textField" placeholder="Enter text here">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="textField" class="form-label">Confirm Password</label>
                    <input  name="password_confirmation"  type="password" class="form-control" id="textField" placeholder="Enter text here">
                    @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                     @enderror
                </div>
               
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>
@endsection
    
