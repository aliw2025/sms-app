@extends('template.main')
@section('content')
<div class="container my-5">
    <h2 class="mb-4">History </h2>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</div>


<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

@endsection
   
