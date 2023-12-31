<table class="rfqDT1 table table-bordered table-hover">
    <thead>
        <tr class="text-center">

            <th width="20%">RFQ Code</th>
            <th width="15%">Create Date</th>
            <th width="15%">Details</th>
            <th width="15%">Status</th>
            <th width="25%" class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($rfqs)
            @foreach ($rfqs as $key => $rfq)
                <tr class="text-center">
                    <td>{{ ucfirst($rfq->rfq_code) }}</td>
                    <td>{{ ucfirst($rfq->create_date) }}</td>
                    <td>
                        <a href="javascript:void(0);" class="text-info mx-2" title="Show RFQ Details"
                            data-bs-toggle="modal" data-bs-target="#show-deals-{{ $rfq->rfq_code }}">
                            <i class="icon-eye"></i>
                        </a>

                        <!---Deal Show modal--->

                        <!---Deal Show modal--->


                    </td>
                    <td><span class="badge bg-success p-1">{{ ucfirst($rfq->status) }}</span></td>
                    <td class="text-center">
                        {{-- <a href="{{ route('rfq.edit', [$rfq->id]) }}"
                            class="text-primary">
                            <i class="icon-pencil"></i>
                        </a> --}}
                        <a href="{{ route('single-rfq.show', $rfq->rfq_code) }}" class="text-success mx-3 float-start"
                            title="Go to Details">
                            <i class="mi-airplay mi-1x"></i>
                        </a>
                        @if ($rfq->status == 'rfq_created')
                            <a href="javascript:void(0);" class="text-primary mx-3 mx-3" data-bs-toggle="modal"
                                title="View & Assign Sales Manager"
                                data-bs-target="#assign-manager-{{ $rfq->rfq_code }}">
                                <i class="ph-user-circle-plus"></i>
                            </a>
                        @endif

                        @if ($rfq->status == 'assigned')
                            <a href="{{ route('deal.convert', [$rfq->id]) }}" class="text-success mx-3 mx-3"
                                title="Convert To Deal">
                                <i class="icon-pen-plus icon-1x"></i>
                            </a>
                        @endif
                        @if ($rfq->status == 'deal_created')
                            <a href="{{ route('deal-sas.show', $rfq->rfq_code) }}" class="text-success mx-3 mx-3"
                                title="Create SAS">
                                <i class="ph-file-plus"></i>
                            </a>
                        @endif
                        @if ($rfq->status == 'sas_created')
                            <a href="{{ route('deal-sas.edit', $rfq->rfq_code) }}" class="text-info mx-2"
                                title="Edit Sas">
                                <i class="icon-pencil"></i>
                            </a>
                            <a href="{{ route('dealsasapprove', $rfq->rfq_code) }}" class="text-warning mx-3 mx-3"
                                title="Approve Sas">
                                <i class="mi-check-circle"></i>
                            </a>
                        @endif
                        @if ($rfq->status == 'sas_approved')
                            <a href="javascript:void(0);" class="text-primary mx-3 mx-3" data-bs-toggle="modal"
                                title="Send Quotation" data-bs-target="#quotation-send-{{ $rfq->rfq_code }}">
                                <i class="icon-paperplane"></i>
                            </a>
                        @endif
                        <a href="{{ route('rfq.destroy', [$rfq->id]) }}" class="text-danger delete mx-2"
                            title="Delete Deal">
                            <i class="delete icon-trash"></i>
                        </a>

                        <!---Assign Manager modal--->

                        <!---Assign Manager modal--->
                        <!---Send Quotation modal--->

                        <!---Send Quotation modal--->

                    </td>

                </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{-- Modals --}}
@foreach ($rfqs as $rfq)
    <div id="show-deals-{{ $rfq->rfq_code }}" class="modal fade" tabindex="-1" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    @php
                        $rfq_details = App\Models\Admin\Rfq::where('rfq_code', $rfq->rfq_code)->first();
                        $deal_products = App\Models\Admin\DealSas::where('rfq_code', $rfq_details->rfq_code)->get();
                    @endphp
                    <h5 class="modal-title">Information Details : {{ $rfq_details->rfq_code }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body border br-7">


                    <div class="row mb-3">
                        <div class="card">

                            <div class="row">
                                <table class="table table-bordered table-striped p-1">
                                    <tbody>
                                        <tr class="text-center bg-indigo">
                                            <td class="text-white" colspan="3">
                                                Product :
                                                {{ App\Models\Admin\Product::where('id', $rfq_details->product_id)->value('name') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Client Type :
                                                {{ !empty($rfq_details->client_type) ? ucfirst($rfq_details->client_type) : 'Anonymous' }}
                                            </td>
                                            <td>
                                                Name : {{ ucfirst($rfq_details->name) }}
                                            </td>
                                            <td>
                                                Company Name :
                                                {{ ucfirst($rfq_details->company_name) }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Asking Quantity : @if (App\Models\Admin\DealSas::where('rfq_id', $rfq_details->id)->sum('qty') > 0)
                                                    {{ App\Models\Admin\DealSas::where('rfq_id', $rfq_details->id)->sum('qty') }}
                                                @else
                                                    {{ $rfq_details->qty }}
                                                @endif
                                            </td>
                                            <td>Phone Number : {{ $rfq_details->phone }}</td>
                                            <td>
                                                @if ($rfq_details->call = 1)
                                                    <span class="badge bg-success">Call Required</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                Assigned Sales Manager (L1) :
                                                {{ App\Models\User::where('id', $rfq_details->sales_man_id_L1)->value('name') }}
                                                <br>
                                                @if ($rfq_details->sales_man_id_T1)
                                                    Assigned Sales Manager (T1) :
                                                    {{ App\Models\User::where('id', $rfq_details->sales_man_id_T1)->value('name') }}
                                                    <br>
                                                @endif
                                                @if ($rfq_details->sales_man_id_T2)
                                                    Assigned Sales Manager (T2) :
                                                    {{ App\Models\User::where('id', $rfq_details->sales_man_id_T2)->value('name') }}
                                                @endif

                                            </td>
                                            <td>
                                                Status :
                                                <span
                                                    class="badge bg-success p-1">{{ ucfirst($rfq_details->status) }}</span>


                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                    </form>
                </div>


            </div>
        </div>
    </div>

    <div id="quotation-send-{{ $rfq->rfq_code }}" class="modal fade" tabindex="-1" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    @php
                        $rfq_details = App\Models\Admin\Rfq::where('rfq_code', $rfq->rfq_code)->first();
                        $deal_products = App\Models\Admin\DealSas::where('rfq_code', $rfq->rfq_code)->get();
                    @endphp
                    <h5 class="modal-title">Send Quotation : {{ $rfq_details->rfq_code }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body border br-7">

                    <form method="post" action="{{ route('quotation.send', $rfq_details->rfq_code) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="card">
                                <div class="row">
                                    <table class="table table-bordered table-striped p-1">
                                        <thead>
                                            <tr>
                                                <th> Product Name</th>
                                                <th> Quantity </th>
                                                <th> Sale Price </th>
                                            </tr>

                                            @if ($deal_products)
                                                @foreach ($deal_products as $item)
                                                    <tr class="bg-gray text-white">
                                                        <th>{{ $item->item_name }}</th>
                                                        <th>{{ $item->qty }}</th>
                                                        <th>{{ $item->sub_total_cost }}</th>
                                                    </tr>
                                                @endforeach
                                            @endif



                                        </thead>
                                    </table>
                                </div>
                                <div class="row">
                                    <table class="table table-bordered table-striped p-1">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Client Type :
                                                    {{ ucfirst($rfq_details->client_type) }}
                                                </th>
                                                <th>
                                                    Name : {{ ucfirst($rfq_details->name) }}
                                                </th>
                                                <th>
                                                    Company Name :
                                                    {{ ucfirst($rfq_details->company_name) }}
                                                </th>
                                            </tr>
                                            {{-- <tr>
                                                <th colspan="3" style="background: #7e7d7c">
                                                    <p class="text-center pt-1 text-white">Product Name : {{App\Models\Admin\DealSas::where('id' , $rfq_details->product_id)->value('name')}}</p>
                                                </th>
                                            </tr> --}}
                                            <tr>
                                                <th>Asking Quantity :
                                                    {{ App\Models\Admin\DealSas::where('rfq_id', $rfq_details->id)->sum('qty') }}
                                                </th>
                                                <th>Phone Number : {{ $rfq_details->phone }}</th>
                                                <th>
                                                    Total Price : $
                                                    {{ App\Models\Admin\DealSas::where('rfq_id', $rfq_details->id)->value('grand_total') }}
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Assigned Sales Manager (L1) :
                                                    {{ App\Models\User::where('id', $rfq_details->sales_man_id_L1)->value('name') }}
                                                    <br>
                                                    @if ($rfq_details->sales_man_id_T1)
                                                        Assigned Sales Manager (T1) :
                                                        {{ App\Models\User::where('id', $rfq_details->sales_man_id_T1)->value('name') }}
                                                        <br>
                                                    @endif
                                                    @if ($rfq_details->sales_man_id_T2)
                                                        Assigned Sales Manager (T2) :
                                                        {{ App\Models\User::where('id', $rfq_details->sales_man_id_T2)->value('name') }}
                                                    @endif

                                                </th>
                                                <th>
                                                    Status : <span
                                                        class="badge bg-success p-2">{{ ucfirst($rfq_details->status) }}</span>


                                                </th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th colspan="3" style="background: #7e7d7c">
                                                    <p class="text-center pt-1 text-white">Send
                                                        Quotation To : <input type="email" name="email"
                                                            id="" value="{{ $rfq_details->email }}"></p>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                        </div>




                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9 text-secondary">
                                <button type="submit" class="btn btn-primary">Send Quotation <i
                                        class="icon-paperplane ml-2"></i></button>
                            </div>
                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>


    <div id="assign-manager-{{ $rfq->rfq_code }}" class="modal fade" tabindex="-1" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    @php
                        $rfq_details = App\Models\Admin\Rfq::where('rfq_code', $rfq->rfq_code)->first();
                    @endphp
                    <h5 class="modal-title">Assign Sales Manager For RFQ No :
                        {{ $rfq_details->rfq_code }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body border br-7">

                    <form method="post" action="{{ route('assign.salesman', $rfq_details->rfq_code) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-1">
                            <div class="card">
                                <table class="table border p-1">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="text-white" colspan="3">
                                                Product :
                                                {{ App\Models\Admin\Product::where('id', $rfq_details->product_id)->value('name') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>
                                                Client Type :
                                                {{ !empty($rfq_details->client_type) ? ucfirst($rfq_details->client_type) : 'Anonymous' }}
                                            </td>
                                            <td>
                                                Name : {{ ucfirst($rfq_details->name) }}
                                            </td>
                                            <td>
                                                Company Name :
                                                {{ ucfirst($rfq_details->company_name) }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Asking Quantity : @if (App\Models\Admin\DealSas::where('rfq_id', $rfq_details->id)->sum('qty') > 0)
                                                    {{ App\Models\Admin\DealSas::where('rfq_id', $rfq_details->id)->sum('qty') }}
                                                @else
                                                    {{ $rfq_details->qty }}
                                                @endif
                                            </td>
                                            <td>Phone Number : {{ $rfq_details->phone }}</td>
                                            <td>
                                                @if ($rfq_details->call = 1)
                                                    <span class="badge bg-success">Call Required</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                Assigned Sales Manager (L1) :
                                                {{ App\Models\User::where('id', $rfq_details->sales_man_id_L1)->value('name') }}
                                                <br>
                                                @if ($rfq_details->sales_man_id_T1)
                                                    Assigned Sales Manager (T1) :
                                                    {{ App\Models\User::where('id', $rfq_details->sales_man_id_T1)->value('name') }}
                                                    <br>
                                                @endif
                                                @if ($rfq_details->sales_man_id_T2)
                                                    Assigned Sales Manager (T2) :
                                                    {{ App\Models\User::where('id', $rfq_details->sales_man_id_T2)->value('name') }}
                                                @endif

                                            </td>
                                            <td>
                                                Status :
                                                <span
                                                    class="badge bg-success p-1">{{ ucfirst($rfq_details->status) }}</span>


                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <div class="row p-2">
                                    <div class="col-12 text-center">
                                        <strong>Assign Sales Manager :</strong>
                                        <a class="p-1 editRfquser" href="javascript:void(0);">
                                            <i class="ph-note-pencil text-success" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="col-12 Rfquser" style="display:none">
                                        <div class="row mb-1 p-2 border">


                                            <div class="col-lg-4">
                                                <div class="col-sm-12">
                                                    <p class="mb-0">Sales Manager Name (Leader -
                                                        L1) <span class="text-danger">*</span></p>
                                                </div>
                                                <div class="form-group text-secondary col-sm-12">
                                                    <select name="sales_man_id_L1" class="form-control select"
                                                        data-minimum-results-for-search="Infinity"
                                                        data-placeholder="Choose Sales Manager">
                                                        <option></option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">
                                                                {{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="col-sm-12">
                                                    <p class="mb-0">Sales Manager Name (Team -
                                                        T1)</p>
                                                </div>
                                                <div class="form-group text-secondary col-sm-12">
                                                    <select name="sales_man_id_T1" class="form-control select"
                                                        data-minimum-results-for-search="Infinity"
                                                        data-placeholder="Choose Sales Manager">
                                                        <option></option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">
                                                                {{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="col-sm-12">
                                                    <p class="mb-0">Sales Manager Name (Team -
                                                        T2)</p>
                                                </div>
                                                <div class="form-group text-secondary col-sm-12">
                                                    <select name="sales_man_id_T2" class="form-control select"
                                                        data-minimum-results-for-search="Infinity"
                                                        data-placeholder="Choose Sales Manager">
                                                        <option></option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">
                                                                {{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-sm-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>
@endforeach
