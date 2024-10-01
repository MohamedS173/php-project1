@extends('layout')

@section('content')

                <a class="nav-link " aria-current="page" href="/">Home</a>
                <a class="nav-link active" aria-current="page" href="/user-requests">User Page</a>
                <a class="nav-link" href="/manager-requests">Manager Page</a>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="services_taital">Your <span class="text-warning">Requests</span></h1>
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
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($goods as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity > 0 ? 'Available' : 'Not Available' }}</td>
                        <?php
                           // dd($goods);
                        ?>
                        <td>
                            @if($item->quantity > 0)
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#requestModal"
                                data-goods-id="{{ $item->id }}" id="requestbutton" data-item-name="{{ $item->name }}" onclick="getrequest(this)">Request</button>
                            @else
                            <button class="btn btn-sm btn-secondary" disabled>Not Available</button>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="requestForm" action="/submit-request" method="post" onsubmit="userrequsets(event)">
                                        @csrf
                                        <input type="hidden" name="goods_id" id="goods_id" value="">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Request Item</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p id="item_name" name="item"></p>
                                            <div class="mb-3">
                                                <label for="quantity" class="form-label">Quantity</label>
                                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Submit Request</button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">


        <!-- User requests table -->
        <div class="col-sm-12">
            <h2 class="services_taital">Your <span class="text-warning">Pending Requests</span></h2>
        </div>
        <div class="col-sm-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Goods ID</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userRequests as $request)
                    <tr>
                        <td>{{ $request->goods_id }}</td>
                        <td>{{ $request->goods->name }}</td>
                        <td>{{ $request->quantity }}</td>
                        <td>{{ ucfirst($request->status) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function getrequest(elm) {
      //alert($(elm).attr('data-user-id'));
        var myUserId = $(elm).attr('data-goods-id');
        $("#goods_id").attr('value', myUserId);
        var myitemname = $(elm).attr('data-item-name');
        $("#item_name").text(myitemname);


      $.ajax({
         url: "/getrequest",
         type: "GET",
         data: {
            'goods_id': myUserId,
            'item':myitemname
         },
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         success: function(response) {
            console.log(response['goods_id']);
            console.log(response['item']);
          
            $("#goods_id").val(response['goods_id']);
            $("#item_name").text(response['item']);
            

            //$("#equipTableBody").html(response);
         },
         error: function(error) {
            console.log("Error:", error);
         }
      });
   }

    function userrequsets(event) {
        event.preventDefault();

       
        
        // $("#item_name").attr('value', myitemname);

        // var goodsId = event.target.getAttribute('data-goods-id');
        // var itemName = event.target.getAttribute('data-item-name');
        // // $('#goods_id').val(goodsId);
        // document.getElementById('item_name').textContent = "Item: " + itemName;
        var formData = $('#requestForm').serialize();
        // var formData = new FormData(event.target);
        $.ajax({
            type: 'POST',
            url: '/submit-request',
            data: formData,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert(response.success);
                $('#requestModal').hide(''); // Close the modal after success
                $('.modal-backdrop').hide(''); // Close the modal backdrop
                location.reload(); // Reload the page to update the pending requests
            },
            error: function(error) {
                alert('Error submitting request');
                console.log(error);
            }
        });
    }
</script>










@endsection