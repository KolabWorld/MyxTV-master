
<div class="text-center">
    <span  class="heading1">QUOTATION</span>
</div>
<div class="row f12" >
    <div class="col-xs-7 col-sm-7">
        <img src="{{$logo}}" class="logo">
        <br/>
        <span><b>CORETRADE PVT. LTD.</b><br/>
        B-6,Hortron Complex, Electronic City, <br/>
        Sector 18,Phase IV, Gurugram-122015 <br/>
        0124-4065533/+91-9811212164 
    </div>

    <div class="col-xs-5 col-sm-5">
        <!-- <img width="170px" src="assets/default/img/Logo.png"><br/><br/> -->
        <b>Email:</b> info@coretrade.in<br/>
        <b>Web:</b> www.coretrade.in<br/>
        <b>Tel:</b> 0124-4065533<br/>
        <b>PAN No.</b> PAN<br/>
        <b>CIN No.</b> CIN<br/>
        <b>GSTIN.</b> GSTIN<br/>
        <b>Quotation No.</b> {{ $quotation->uid }}<br/>
        <b>Quotation Date.</b> {{ date('d-M-Y', strtotime($quotation->created_at)) }}
    </div> 
</div>
<img src="{{$line}}"  style="margin-top: 10px; margin-bottom: 10px" class="hrline">

<div class="row f12 quotation">
    <div class="address">
        <span class="heading2"><u>To</u></span><br/>
        <span><b>{{$quotation->customer_name}}</b><br/>
        @if($quotation->customer)
            {{ $quotation->address->address_1}}, {{$quotation->address->address2}},<br/>{{$quotation->address->city}}, {{ $quotation->address->state->name}} - {{$quotation->address->zip}}
        <br/>
        @endif
        @if($quotation->customer_phone)
            <b>Tel:</b> {{ $quotation->customer_phone }}<br/>
        @endif
    </div>

</div>

<div class="row f10" style="margin-top: 12px; padding: 5px; padding-left: 15px">
    <table id="table" class="table table-sm table-bordered">
        <thead>
            <tr>
                <th rowspan="2" width="5%" align="center">S.No.</th>
                <th rowspan="2" width="30%">Description</th>
                <th rowspan="2" align="center"  style="white-space: nowrap;">Qty</th>
                <th rowspan="2" align="center"  style="white-space: nowrap;">Sub Total</th>
                @if($quotation->total_discount)
                    <th rowspan="2" align="center"  style="white-space: nowrap;">Discount</th>
                @endif
                <th rowspan="2" align="center"  style="white-space: nowrap;">Taxable<br/>Value</th>
                @if($quotation->gst_type == 'inter_state')
                    @php $colspan = 3; @endphp
                    <th colspan="2" align="center"  style="white-space: nowrap;">IGST</th>
                @else
                    @php $colspan = 5; @endphp
                    <th colspan="2" align="center"  style="white-space: nowrap;">SGST</th>
                    <th colspan="2" align="center"  style="white-space: nowrap;">CGST</th>
                @endif
            </tr>
            <tr>
                @if($quotation->gst_type == 'inter_state')
                    <th>RATE</th>
                    <th>AMOUNT</th>
                @else
                    <th>RATE</th>
                    <th>AMOUNT</th>
                    <th>RATE</th>
                    <th>AMOUNT</th>
                @endif
            </tr>
        </thead>
        <tbody>

            @foreach($quotation->items as $key => $item)
                <tr>
                    <td align="center">{{ ($key + 1) }}</td>
                    <td>{{ $item->product_name }}
                        @if($item->hsn_code)
                            <br/>
                            <b> HSN/SAC Code: </b> {{ $item->hsn_code }}
                        @endif
                        <br/>
                        <b> Unit Price: </b> @numberFormat($item->item_price)
                    </td>
                    <td align="center">
                        {{$item->quantity }}
                    </td>
                    <td class="text-right">
                        @numberFormat($item->price)
                    </td> 
                    @if($item->discount_value)
                        <td class="text-right">
                            {{$item->discount_value}}
                        </td>
                    @endif
                    <td class="text-right">
                        @numberFormat($item->taxable_amount)
                    </td>
                    @if($quotation->gst_type == 'intra_state')
                        <td class="text-right">
                            {{$item->cgst_perc}}%
                        </td>
                        <td class="text-right">
                            @numberFormat($item->cgst_value)
                        </td>
                        <td class="text-right">
                            {{$item->sgst_perc}}%
                        </td>
                        <td class="text-right">
                            @numberFormat($item->sgst_value)
                        </td>
                    @else
                        <td class="text-right">
                            {{$item->igst_perc}}%
                        </td>
                        <td class="text-right">
                            @numberFormat($item->igst_value)
                        </td>
                    @endif
                </tr>
            @endforeach

            <tr>
                <td colspan="4" class="text-right">
                    <b>Total</b>
                </td>
                @if($quotation->total_discount)
                    @php $colspan++; @endphp
                    <td class="text-right">@currencyPDF($quotation->total_discount)</td>
                @endif
                <td align="center">
                    @currencyPDF($quotation->total_taxable_amount)
                </td>
                @if($quotation->gst_type == 'inter_state')
                    <td colspan="2" class="text-right">@currencyPDF($quotation->total_igst)</td>
                @else 
                    <td colspan="2" class="text-right">@currencyPDF($quotation->total_cgst)</td>
                    <td colspan="2" class="text-right">@currencyPDF($quotation->total_sgst)</td>
                @endif
            </tr>

            <tr>
                <td  colspan="4" class="text-right">
                    <b>Total INR</b>
                </td>
                <td class="text-right" colspan="<?= $colspan ?>">
                    <b>@currencyPDF($quotation->invoice_total)</b>
                </td>
            </tr>
        
        </tbody>
    </table>
</div>
<footer class="f12">
    <div class="row">
        <div class="col-md-12">
            Amount in words:<br/> 
             only.
        </div>
    </div>
    <div class="col-md-12">
        <div style="margin-left: 70%;text-align: center;">
            For <b>CORETRADE PVT. LTD</b><br/>
            Authorized Signatory
        </div>
    </div>
    <div class="col-md-12">
        <div style="margin-top: 50px" class="f10">
            <b>Note: </b> Our proposal is valid for 30 days only.
        </div>
    </div>
</footer>