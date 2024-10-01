@extends('layout')

@section('content')

                <a class="nav-link "  href="/">Home</a>
                <a class="nav-link" href="/user-requests">User Page</a>
                <a class="nav-link active" aria-current="page" href="/manager-requests">Manager Page</a>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="services_taital">Pending <span class="text-warning">Requests</span></h1>
        </div>
        <div class="col-sm-12 mt-5">
            @if (session('status'))
            <h6 class="alert alert-success"> {{session('status')}}</h6>
            @endif
            <table border="3" class="table table-bordered table-hover mt-5">
                <thead class="table-dark">
                    <tr>
                        <th>Goods ID</th>
                        <th>Item Name</th>
                        <th>User</th>
                        <th>Requested Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                    <tr id="request-{{ $request->id }}">
                        <td>{{ $request->goods->id }}</td>
                        <td>{{ $request->goods->name }}</td>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->quantity }}</td> 
                        <td>
                            <button class="btn btn-sm btn-success" onclick="approveRequest('{{ $request->id }}')">Approve</button>
                            <button class="btn btn-sm btn-danger" onclick="rejectRequest('{{ $request->id }}')">Reject</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function approveRequest(id) {
        $.ajax({
            type: 'POST',
            url: `/approve-request/${id}`,
            data: { _token: "{{ csrf_token() }}" },
            success: function(response) {
                alert(response.success);
                $('#request-' + id).remove();
            },
            error: function(xhr) {
                alert('Error approving request');
            }
        });
    }

    function rejectRequest(id) {
        $.ajax({
            type: 'POST',
            url: `/reject-request/${id}`,
            data: { _token: "{{ csrf_token() }}" },
            success: function(response) {
                alert(response.success);
                $('#request-' + id).remove();
            },
            error: function(error) {
                alert('Error rejecting request');
                console.log(error);
            }
        });
    }
</script>










@endsection