@extends('layouts.fixed')

@section('title','Purchase Booking')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Purchase Booking</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Order</li>
                        <li class="breadcrumb-item active">Purchase Booking</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="col-12">
            <div class="card"><br>
                <div class="row justify-content-center">
                    <div class="card-info" style="width:95%">
                        <div class="card-header">
                            <h3 class="card-title">Update Purchase Booking</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover text-center">
                                <thead class="text-bold">
                                    <tr>
                                        <td>Element Name</td>
                                        <td>Size</td>
                                        <td>Quantity</td>
                                        <td>Purchase</td>
                                        <td style="width: 12%">Timeline days</td>
                                        <td>Receive</td>
                                        <td>Remarks</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->elements as $element)
                                        <?php
                                            $quantity = $element->sizeQuantity["quantity"];
                                        ?>
                                        <tr>
                                            <td>{{$element->element_name}}</td>
                                            <td>{{$element->sizeQuantity["size_name"]}}</td>
                                            <td>{{ceil($element->waste_percentage * $element->quantity_per_unit * $element->sizeQuantity["quantity"])}}</td>
                                            <td><input onchange="elementStatusUpdate({{$element->id}}, 1)" type="checkbox" id="Order{{$element->id}}" name="vehicle1" value="{{$element->id}}" <?php if($element->status >= 1) echo "checked disabled"?>></td>
                                            <td><input type="number" class="form-control" id="timelineDays{{$element->id}}" name="timelineDays" value="{{$element->timeline_days}}" step="1"></td>
                                            <td><input onchange="elementStatusUpdate({{$element->id}}, 2)" type="checkbox" id="Receive{{$element->id}}" name="vehicle1" value="{{$element->id}}" <?php if($element->status >= 2) echo "checked disabled"?>></td>
                                            <td><input type="text" class="form-control" id="Note{{$element->id}}" name="vehicle1" value="{{$element->note}}"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-right pb-3 pt-4">
                                <a href="{{url('order-details/'.$order->id)}}" class="btn btn-outline-info">
                                    Order Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap4.css') }}">
@stop

@section('plugin')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
@stop

@section('script')
    <script>
        $(document).ready(function(){
        });

        function elementStatusUpdate(elementId, status){
            let remarks = $("#Note"+elementId).val();
            let timelineDays = $("#timelineDays"+elementId).val();
            if(timelineDays === ""){
                $('#Order'+elementId).prop('checked', false);
                alert("Please insert timeline days.");
                return;
            }
            console.log(remarks);
            $.ajax({
                url: '/elements-status-update',
                data: {elementId : elementId, status : status, timelineDays : timelineDays, remarks : remarks},
                type: "POST",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(response){
                    $('#Order'+elementId).prop('checked', true);
                    if(status === 2){
                        $('#Receive'+elementId).prop('checked', true);
                    }
                    alert("Successfully updated");
                    console.log(response.status, response["message"]);
                },
                error: function(response){
                }
            });
        }
    </script>
@stop
