@extends('template.main')
@section('content')
    <div class="container my-5">
        <h2 class="mb-4">History </h2>
        <div class="container-fluid mt-5">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center">Transactions</h2>
                    <table id="transactionsTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>Number of Contacts</th>
                                <th>Number of Successful</th>
                                <th>Number of Failed</th>
                                <th>Date</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated via AJAX -->
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#transactionsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('transactions.fetch') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'num_of_contacts',
                        name: 'num_of_contacts'
                    },
                    {
                        data: 'num_of_successfull',
                        name: 'num_of_successfull'
                    },
                    {
                        data: 'num_of_failed',
                        name: 'num_of_failed'
                    },
                    {
                        data: 'created_at',
                        name: 'Date'
                    },
                    {
                        data: 'details'
                    }


                ],
                order: [
                    [0, 'desc']
                ] // Order by ID, descending
            });

        });
    </script>
@endsection
