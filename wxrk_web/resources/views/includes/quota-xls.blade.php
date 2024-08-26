<table>
    <tr>
        <th colspan="3" style="text-align: center;">
            QUOTATION
        </th>
    </tr>
    <tr>
        <td></td>
        <td style="height: 120">
           AIMS BUILDMART PVT. LTD<br/>
            {{ $quotation->branch->address1}}, {{$quotation->branch->address2}},<br/>{{$quotation->branch->city}}, {{ $quotation->branch->state->name}} - {{$quotation->branch->zip}}<br/>
            Email:{{ $quotation->branch->email }}<br/>
            
            Tel: {{ $quotation->branch->phone }}<br/>
            Web: {{ $quotation->branch->website }}<br/>
            Office in {{env('OFFICE_IN', 'Delhi | Gurgoan | Greater Noida')}}
        </td>
        <td colspan="3">
            Quotation No. {{ $quotation->uid }}<br/>
            Quotation Date. {{ date('d-M-Y', strtotime($quotation->created_at)) }}<br/>
            PAN No. {{ $quotation->branch->pan_no }}<br/>
            CIN No. {{ $quotation->branch->cin_no }}<br/>
            GSTIN. {{ $quotation->branch->gstin }}
        </td>
    </tr>
    <tr>
        <td></td>
        <th>To</th>
    </tr>
    <tr>
        <td></td>
        <td style="height: 120">
            {{$quotation->address->address_name}}<br/>
            {{ $quotation->address->address_1}}, {{$quotation->address->address_2}},<br/>{{$quotation->address->city}}, {{ $quotation->address->state->name}} - {{$quotation->address->zip}}<br/>

            @if($quotation->address->mobile)
            Mob: {{ $quotation->address->mobile }} <br/>
            @endif

            @if($quotation->address->phone)
            Tel: {{ $quotation->address->phone }}
            @endif
        </td>
        <td  colspan="3">
            @if($quotation->contact_person)
            <div class="address">
                Contact Person: {{ $quotation->contact_person }}<br/>
                @if($quotation->contact_number)
                Contact Number No.: {{ $quotation->contact_number }}
                @endif
            </div> 
        @endif
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
       <?php if($quotation->branch->alias != 'CST') {
        $colspan = 5;
        ?>
        <th colspan="2">SGST</th>
        <th colspan="2">CGST</th>
        <?php } else { $colspan = 3; ?>
        <th colspan="2">IGST</th>
        <?php } ?>
    </tr>
    <tr>
        <?php if($quotation->branch->alias != 'CST') { ?>
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
        <td align="center">@numberFormat($quotation->amount)
            
        </td>
        <?php if($quotation->branch->alias != 'CST') { ?>
         <td colspan="2" style="text-align: right">{{$quotation->tax / 2}}</td>
         <td colspan="2" style="text-align: right">{{$quotation->tax / 2}}</td>
         <?php } else { ?>
         <td colspan="2" style="text-align: right">{{$quotation->tax}}</td>
         <?php } ?>
    </tr>

    <?php if($quotation->transport != 0) { ?>
        <tr>
            <td colspan="6" style="text-align: right" >Transportation Charge
         
            </td>
            <td colspan="<?= $colspan ?>" style="text-align: right">
               @numberFormat($quotation->transport)
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td  colspan="6" style="text-align: right">
            <b>Total INR</b>
        </td>
        <td colspan="<?= $colspan ?>" style="text-align: right">
            <b>@numberFormat($quotation->total)</b>
        </td>
    </tr>
</table>