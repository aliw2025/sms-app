@extends('template.main')

@section('content')
<div class="container-fluid mt-5">
    <h2 class="text-center">Transaction Details</h2>
    
    <div class="mb-4">
        <h4>Transaction Information</h4>
        <p><strong>ID:</strong> {{ $transaction->id }}</p>
        <p><strong>Subject:</strong> {{ $transaction->subject }}</p>
        <p><strong>Number of Contacts:</strong>  {{ $transaction->num_of_contacts }}</p>
        <p><strong>Number of Successful:</strong> <span style="font-weight:bold;color:#6fc96f;" > {{ $transaction->num_of_successfull }}</span></p>
        <p><strong>Number of Failed:</strong>  <span style="font-weight:bold;color:red;" >{{ $transaction->num_of_failed }}</span></p>
        <p><strong>Date:</strong> {{ $transaction->created_at->format('j M Y h:i a') }}</p>
    </div>

    <h4>Details</h4>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-stripped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Contact</th>
                        <th>SMS Status</th>
                        <th>Response Code</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $detail)
                    <tr>
                        <td>{{ $detail->id }}</td>
                        <td>{{ $detail->contact }}</td>
                        <td>{{ $detail->Smsstatus->description }}</td>
                        <td>{{ $detail->response_code }}</td>
                        <td>{{ $detail->created_at->format('j M Y h:i a') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        
        </div>
    </div>
   
    <a href="{{ route('history') }}" class="mt-2 btn btn-primary">Back to Transactions</a>
</div>
@endsection
