@extends('layouts.fixed')

@section('title','Order Details')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Order</li>
                        <li class="breadcrumb-item active">Order Details</li>
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
                            <h3 class="card-title">Order</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="style_name" class="col-md-3 offset-1 control-label">Style Name</label>
                                <div class="col-md-8 pl-0 pr-0">
                                    <span>{{$order->style_name ?? ""}}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="order_no" class="col-md-3 offset-1 control-label">Order No</label>
                                <div class="col-md-8 pl-0 pr-0">
                                    <span>{{$order->order_no ?? ""}}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-3 offset-1 control-label">Description<span class="text-danger">*</span></label>
                                <div class="col-md-8 pl-0 pr-0">
                                    <span>{{$order->order_name ?? ""}}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="buyer" class="col-md-3 offset-1 control-label">Buyer Name</label>
                                <div class="col-md-3 pl-0 pr-0">
                                    <span>{{$order->buyer->name ?? ""}}</span>
                                </div>
                            </div>

                            <?php
                                $start = strtotime($order->delivery_date);
                                $end = strtotime(date('Y-m-d'));
                                $days_between = ceil(abs($end - $start) / 86400);

                                $orderDate = date('Y-m-d', strtotime($order->created_at));
                            ?>

                            <div class="form-group row">
                                <label for="buyer" class="col-md-3 offset-1 control-label">Order Date</label>
                                <div class="col-md-3 pl-0 pr-0">
                                    <span>{{$orderDate ?? ""}}</span>
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('delivery_date') ? 'has-error' : '' }}">
                                <label for="delivery_date" class="col-md-3 offset-1 control-label">Delivery Date</label>
                                <div class="col-md-4 pl-0 pr-0">
                                    <span>{{$order->delivery_date ?? ""}}</span>
                                </div>
                                <div class="col-md-4 pl-0 pr-0">
                                    <label>Left <span id="day_range">{{$days_between ?? 0}}</span> days </label>
                                </div>
                            </div>

                            <div class="card-body table-responsive">
                                <table class="table table-hover text-center">
                                    <thead class="text-bold">
                                        <tr>
                                            <td>Size Name</td>
                                            <td>Quantity</td>
                                            <td>Cumulative Quantity</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $total = 0;
                                            foreach($order->sizeQuantity as $size){
                                                $total += $size->quantity;
                                                ?>
                                                <tr>
                                                    <td>{{$size->size_name ?? ""}}</td>
                                                    <td>{{$size->quantity ?? ""}}</td>
                                                    <td>{{$total ?? ""}}</td>
                                                </tr>
                                            <?php
                                              }
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-header">
                            <h3 class="card-title">Order Elements</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover text-center">
                                <thead class="text-bold">
                                    <tr>
                                        <td>Element Name</td>
                                        <td>Size</td>
                                        <td>Quantity</td>
                                        <td>Quantity/Unit</td>
                                        <td>Wastage</td>
                                        <td>Need</td>
                                        <td>Order</td>
                                        <td>Receive</td>
                                        <td>Color</td>
                                        <td>Type</td>
                                        <td>Note</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->elements as $element)
                                        <?php
                                            $quantity = $element->sizeQuantity["quantity"];
                                        ?>
                                        <tr>
                                            <td>{{$element->element_name ?? ""}}</td>
                                            <td>{{$element->sizeQuantity["size_name"] ?? ""}}</td>
                                            <td>{{$quantity ?? ""}}</td>
                                            <td>{{$element->quantity_per_unit ?? ""}}</td>
                                            <td>{{$element->waste_percentage ?? ""}} %</td>
                                            <td>{{ceil($element->waste_percentage * $element->quantity_per_unit * $quantity)}}</td>
                                            <td>{{$element->status > 0 ? date("Y-m-d", strtotime($element->order_place)) : "No"}}</td>
                                            <td>{{$element->status > 1 ? date("Y-m-d", strtotime($element->order_receive)) : "No"}}</td>
                                            <td>{{$element->color ?? ""}}</td>
                                            <td>{{$element->type ?? ""}}</td>
                                            <td>{{$element->note ?? ""}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class=" row justify-content-end pb-3">
                            <div class="pr-3">
                                <a href="{{url('edit-order/'.$order->id)}}" class="btn btn-outline-info">
                                    Edit Order
                                </a>
                            </div>
                            <div class="pr-3">
                                <a href="{{url('edit-order-elements/'.$order->id)}}" class="btn btn-outline-info">
                                    Edit Order Elements
                                </a>
                            </div>
                            <div class="">
                                <a href="{{url('elements-order/'.$order->id)}}" class="btn btn-outline-info">
                                    Update Elements Order
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
    </script>
@stop
