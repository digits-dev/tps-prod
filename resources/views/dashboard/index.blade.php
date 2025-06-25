@extends('crudbooster::admin_template')

@push('head')
    <style type="text/css">
        table.sales-table tbody {
            border: 2px solid black;
        }

        .panel-heading.store-header {
            background-color: #dd4b39;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row">

            @foreach ($stores as $key => $store)
                <div class="col-md-4">
                    <div class='panel panel-default'>
                        <div class='panel-heading store-header'>{{ $store }}</div>
                        <div class="panel-body">
                            <h5>Date: <b>{{ $gross_sale[$key]->date }}</b></h5>

                            <b>Sales</b>
                            <table class="table table-striped sales-table" style="width:100%">
                                <tbody>
                                    <tr>
                                        <td>Gross Sales</td>
                                        <td> {{ number_format($gross_sale[$key]->amount,2) }} </td>
                                    </tr>
                                    <tr>
                                        <td>MTD Gross Sales</td>
                                        <td> {{ number_format($gross_sale_mtd[$key]->amount,2) }} </td>
                                    </tr>

                                    <tr>
                                        <td>Ave. Daily Sales</td>
                                        <td> {{ number_format($adds[$key],2) }} </td>
                                    </tr>
                                </tbody>
                            </table>

                            <br>

                            <b>Mode of Order</b>
                            <table class="table table-striped sales-table" style="width:100%">
                                <tbody>
                                    <tr>
                                        <td>Dine in</td>
                                        <td> {{ number_format($dine[$key]->amount,2) }} / {{ $dine_qty[$key]->count }} </td>
                                    </tr>
                                    <tr>
                                        <td>Take out</td>
                                        <td> {{ number_format($takeout[$key]->amount,2) }} / {{ (empty($takeout_qty[$key]->count)) ? 0 :  $takeout_qty[$key]->count }}</td>
                                    </tr>
                                    <tr>
                                        <td>Delivery</td>
                                        <td> {{ number_format($delivery[$key]->amount,2) }} / {{ (empty($delivery_qty[$key]->count)) ? 0 : $delivery_qty[$key]->count }} </td>
                                    </tr>
                                    <tr>
                                        <td>Dine-In Ave. Check</td>
                                        <td> {{ number_format($dine_ave[$key],2) }} </td>
                                    </tr>
                                    <tr>
                                        <td>Total Transaction</td>
                                        <td> {{ number_format($total_trx[$key]->count,2) }} </td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection

@push('bottom')
    <script type="text/javascript">
        function preventBack() {
            window.history.forward();
        }
        window.onunload = function() {
            null;
        };
        setTimeout('preventBack()', 0);
    </script>
@endpush
