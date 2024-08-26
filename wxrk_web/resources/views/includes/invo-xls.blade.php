<table>
    <tr>
        <th colspan="3" style="text-align: center;">
            TAX INVOICE
        </th>
    </tr>
    <tr>
        <td></td>
        <td style="height: 120">
           AIMS BUILDMART PVT. LTD<br/>
            {{ $invoice->branch->address1}}, {{$invoice->branch->address2}},<br/>{{$invoice->branch->city}}, {{ $invoice->branch->state->name}} - {{$invoice->branch->zip}}<br/>
            Email:{{ $invoice->branch->email }}<br/>
            
            Tel: {{ $invoice->branch->phone }}<br/>
            Web: {{ $invoice->branch->website }}<br/>
            Office in {{env('OFFICE_IN', 'Delhi | Gurgoan | Greater Noida')}}
        </td>
        <td colspan="3">
            Invoice No. {{ $invoice->uid }}<br/>
            Invoice Date. {{ date('d-M-Y', strtotime($invoice->created_at)) }}<br/>
            PAN No. {{ $invoice->branch->pan_no }}<br/>
            CIN No. {{ $invoice->branch->cin_no }}<br/>
            GSTIN. {{ $invoice->branch->gstin }}
            @if($invoice->po_number)
            PO No. {{ $invoice->po_number }}<br/>
            @endif
            @if($invoice->eway_bill)
            E-Way Bill  {{ $invoice->eway_bill }}
            @endif
        </td>
    </tr>
    <tr>
        <td></td>
        <th>Billing Address</th>
        <th>Shipping Address</th>
    </tr>
    <tr>
        <td></td>
        <td style="height: 120">
            {{$invoice->client->name}}
            {{ $invoice->client->address_1}}, {{$invoice->client->address_2}},<br/>{{$invoice->client->city}}, {{ $invoice->client->state->name}} - {{$invoice->client->zip}}<br/>
            @if($invoice->client->email)
            Email: {{ $invoice->client->email}} <br/>
            @endif

            @if($invoice->client->mobile)
            Mob: {{ $invoice->client->mobile }} <br/>
            @endif

            @if($invoice->client->phone)
            Tel: {{ $invoice->client->phone }} <br/>
            @endif
        </td>
        <td  colspan="3">
            {{$invoice->address->address_name}}<br/>
            {{ $invoice->address->address_1}}, {{$invoice->address->address_2}},<br/>{{$invoice->address->city}}, {{ $invoice->address->state->name}} - {{$invoice->address->zip}}<br/>

            @if($invoice->address->mobile)
            Mob: {{ $invoice->address->mobile }} <br/>
            @endif

            @if($invoice->address->phone)
            Tel: {{ $invoice->address->phone }}
            @endif
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="height: 60">
            STATE: {{$invoice->client->state->name}} 
            <br/>
            STATE CODE: {{$invoice->client->state->code}} 
            <br/>
            PAN No: {{$invoice->client->pan}} 
            <br/>
            GSTIN: {{$invoice->client->gstin}} 
        </td>
        <td>
            STATE: {{$invoice->address->state->name}} 
            <br/>
            STATE CODE: {{$invoice->address->state->code}} 
            <br/>
            PAN No: {{$invoice->client->pan}} 
            <br/>
            GSTIN: {{$invoice->client->gstin}} 
        </td>
    </tr>
    <tr>
        <th rowspan="2" style="height: 30;width: 10">Sr. No.</th>
        <th rowspan="2" style="width: 40;">Description</th>
        <th rowspan="2">HSN/SAC<br/>Code</th>
        <th rowspan="2">Unit</th>
        <th rowspan="2">Qty</th>
        <th rowspan="2">Rate</th>
        <th rowspan="2">Taxable<br/>Value</th>
       <?php if($invoice->branch->alias != 'CST') {
        $colspan = 5;
        ?>
        <th colspan="2">SGST</th>
        <th colspan="2">CGST</th>
        <?php } else { $colspan = 3; ?>
        <th colspan="2">IGST</th>
        <?php } ?>
    </tr>
    <tr>
        <?php if($invoice->branch->alias != 'CST') { ?>
        <th colspan="7"></th>
        <th>RATE</th>
        <th>AMOUNT</th>
        <th>RATE</th>
        <th>AMOUNT</th>
        <?php } ?>
        <th colspan="7"></th>
        <th>RATE</th>
        <th>AMOUNT</th>
    </tr>

    <?php
    $count = 1;
    foreach ($items as $item) { ?>
        <tr>
            <td>{{$count}}</td>
            <td>{{ $item->name }}<br/> {{ $item->description }}</td>

            <td align="center">
                {{ $item->gst->code }}
            </td>
            <td align="center">
                {{ $item->unit }}
            </td>
            <td align="center">
               {{ $item->quantity }}
            </td>
            <td style="text-align: right">
               @numberFormat($item->unit_price)
            </td> 
            <td style="text-align: right">
                @numberFormat($item->amount)
            </td>
            <?php if($item->sgst > 0) { ?>
            <td style="text-align: right">
                {{ $item->tax_rate/2 }} %
            </td>
            <td style="text-align: right">
               @numberFormat($item->sgst)
            </td>
            <?php } if($item->cgst > 0) {  ?>
            <td style="text-align: right">
                {{ $item->tax_rate/2 }} %
            </td>
            <td style="text-align: right">
               @numberFormat($item->cgst)
            </td>
            <?php } if($item->igst > 0) { ?>
            <td style="text-align: right">
                {{ $item->tax_rate }} %
            </td>
             <td style="text-align: right">
                @numberFormat($item->igst)
            </td>
            <?php } ?>
            
        </tr>
    <?php $count++; } ?>

    <tr>
        <td colspan="6" style="text-align: right">
            <b>Total</b>
        </td>
        <td align="center">@numberFormat($invoice->amount)
            
        </td>
        <?php if($invoice->branch->alias != 'CST') { ?>
         <td colspan="2" style="text-align: right">{{$invoice->tax / 2}}</td>
         <td colspan="2" style="text-align: right">{{$invoice->tax / 2}}</td>
         <?php } else { ?>
         <td colspan="2" style="text-align: right">{{$invoice->tax}}</td>
         <?php } ?>
    </tr>

    <?php if($invoice->transport != 0) { ?>
        <tr>
            <td colspan="6" style="text-align: right" >Transportation Charge
         
            </td>
            <td colspan="<?= $colspan ?>" style="text-align: right">
               @numberFormat($invoice->transport)
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td  colspan="6" style="text-align: right">
            <b>Total INR</b>
        </td>
        <td colspan="<?= $colspan ?>" style="text-align: right">
            <b>@numberFormat($invoice->total)</b>
        </td>
    </tr>
</table>