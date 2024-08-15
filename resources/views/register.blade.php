@extends('template.main')
@section('content')
<div class="container d-flex justify-content-center " style="margin-top: 100px;">
    <div class="w-50 card">
        <div class="card-body">
            <H4 class="text-center">Login</H4>
            <form>
                <div class="mb-3">
                    <label for="textField" class="form-label">Email</label>
                    <input type="text" class="form-control" id="textField" placeholder="Enter text here">
                </div>
                <div class="mb-3">
                    <label for="textField" class="form-label">Password</label>
                    <input type="password" class="form-control" id="textField" placeholder="Enter text here">
                </div>
                <div class="mb-3">
                    <label for="textField" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="textField" placeholder="Enter text here">
                </div>
               
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>
@endsection
    
