<div class="f10" style="text-align: right;margin-right:60px;"><b>
    @if($invoice->downloads == 0 || $invoice->downloads == 1)
        Original to recipient
    @elseif($invoice->downloads == 2)
        Duplicate to recipient
    @elseif($invoice->downloads > 2)
        Triplicate to recipient
    @endif

</b>
</div>
<div class="text-center">
    <sapn class="heading1">TAX INVOICE</sapn>
</div>
<div class="row f12">
    <div class="col-xs-7 col-sm-7">
        <span><b>AIMS BUILDMART PVT. LTD.</b><br/>
        {{ $invoice->branch->address1}}, {{$invoice->branch->address2}},<br/>{{$invoice->branch->city}}, {{ $invoice->branch->state->name}} - {{$invoice->branch->zip}}<br/>
        <b>Email:</b> {{ $invoice->branch->email }}<br/>
        <b>Web:</b> {{ $invoice->branch->website }}<br/>
        <b>Tel:</b> {{ $invoice->branch->phone }}<br/>
        <b>Office in</b> {{env('OFFICE_IN', 'Delhi | Gurgoan | Greater Noida')}}
    </div>

    <div class="col-xs-5 col-sm-5">
        <!-- <img width="170px" src="assets/default/img/Logo.png"><br/><br/> -->
        <b>PAN No.</b> {{ $invoice->branch->pan_no }}<br/>
        <b>CIN No.</b> {{ $invoice->branch->cin_no }} <br/>
        <b>GSTIN.</b> {{ $invoice->branch->gstin }}   <br/>
        <b>Invoice No.</b> {{ $invoice->uid }}<br/>
        <b>Invoice Date</b> {{ date('d-M-Y', strtotime($invoice->created_at)) }}<br/>
        @if($invoice->po_number)
        <b>PO No.</b> {{ $invoice->po_number }}<br/>
        @endif
        @if($invoice->eway_bill)
        <b>E-Way Bill</b> {{ $invoice->eway_bill }}
        @endif
    </div> 
</div>

<img src="{{$line}}"  style="margin-top: 10px; margin-bottom: 10px" class="hrline">

<div class="row f12 invoice">
    <div class="address">
        <span class="heading2"><u>Billing Address</u></span><br/>
        <b>{{$invoice->client->name}}</b><br/>
        {{ $invoice->client->address_1}}, {{$invoice->client->address_2}},<br/>{{$invoice->client->city}}, {{ $invoice->client->state->name}} - {{$invoice->client->zip}}<br/>
        @if($invoice->client->email)
        <b>Email:</b> {{ $invoice->client->email}}
        @endif
        <br/>
        @if($invoice->client->mobile)
        <b>Mob:</b> {{ $invoice->client->mobile }}
        @endif
        <br/>
        @if($invoice->client->phone)
        <b>Tel:</b> {{ $invoice->client->phone }}
        @endif
        <br/>
        <hr/>
        <b>STATE:</b> {{$invoice->client->state->name}} 
        <br/>
        <b>STATE CODE:</b> {{$invoice->client->state->code}} 
        <br/>
        <b>PAN No:</b> {{$invoice->client->pan}} 
        <br/>
        <b>GSTIN:</b> {{$invoice->client->gstin}} 
        <br/>

    </div>
    <div class="address">
        <span class="heading2"><u>Shipping Address</u></span><br/>
        <!-- <img width="170px" src="assets/default/img/Logo.png"><br/><br/> -->
        <b>{{$invoice->address->address_name}}</b><br/>
        {{ $invoice->address->address_1}}, {{$invoice->address->address_2}},<br/>{{$invoice->address->city}}, {{ $invoice->address->state->name}} - {{$invoice->address->zip}}<br/>
        @if($invoice->address->mobile)
        <b>Mob:</b> {{ $invoice->address->mobile }}
        @endif
        <br/>
        @if($invoice->address->phone)
        <b>Tel:</b> {{ $invoice->address->phone }}
        @endif
        <br/>
        <br/>
        <hr/>
        <b>STATE:</b> {{$invoice->address->state->name}} 
        <br/>
        <b>STATE CODE:</b> {{$invoice->address->state->code}} 
        <br/>
        <b>PAN No:</b> {{$invoice->client->pan}} 
        <br/>
        <b>GSTIN:</b> {{$invoice->client->gstin}} 
        <br/>
    </div>
</div>

<div class="row f10" style="margin-top: 12px; padding: 5px; padding-left: 15px">
    <table id="table" class="table table-sm table-bordered">
        <thead>
            <tr>
                <th rowspan="2" width="5%" align="center">S.No.</th>
                <th rowspan="2" width="30%">Description</th>
                <th rowspan="2" align="center"  style="white-space: nowrap;">HSN/SAC<br/>Code</th>
                <th rowspan="2" align="center"  style="white-space: nowrap;">Unit</th>
                <th rowspan="2" align="center"  style="white-space: nowrap;">Qty</th>
                <th rowspan="2" align="center"  style="white-space: nowrap;">Rate</th>
                <th rowspan="2" align="center"  style="white-space: nowrap;">Taxable<br/>Value</th>
               <?php if($invoice->branch->alias != 'CST') {
                $colspan = 5;
                ?>
                <th colspan="2" align="center"  style="white-space: nowrap;">SGST</th>
                <th colspan="2" align="center"  style="white-space: nowrap;">CGST</th>
                <?php } else { $colspan = 3; ?>
                <th colspan="2" align="center"  style="white-space: nowrap;">IGST</th>
                <?php } ?>
            </tr>
            <tr>
                <?php if($invoice->branch->alias != 'CST') { ?>
                <th>RATE</th>
                <th>AMOUNT</th>
                <?php } ?>
                <th>RATE</th>
                <th>AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            foreach ($items as $item) { ?>
                <tr>
                    <td align="center"><?php echo $count; ?></td>
                    <td><b><?php echo $item->name; ?></b> <?php echo $item->description; ?></td>

                    <td align="center">
                        <?php echo $item->gst->code; ?>
                    </td>
                    <td align="center">
                        <?php echo $item->unit; ?>
                    </td>
                    <td align="center">
                       <?php echo $item->quantity; ?>
                    </td>
                    <td class="text-right">
                       @numberFormat($item->unit_price)
                    </td> 
                    <td class="text-right">
                        @numberFormat($item->amount)
                    </td>
                    <?php if($item->sgst > 0) { ?>
                    <td class="text-right">
                         <?= $item->tax_rate/2 ?> %
                    </td>
                    <td class="text-right">
                       @numberFormat($item->sgst)
                    </td>
                    <?php } if($item->cgst > 0) {  ?>
                    <td class="text-right">
                        <?= $item->tax_rate/2 ?> %
                    </td>
                    <td class="text-right">
                       @numberFormat($item->cgst)
                    </td>
                    <?php } if($item->igst > 0) { ?>
                    <td class="text-right">
                        <?= $item->tax_rate ?> %
                    </td>
                     <td class="text-right">
                        @numberFormat($item->igst)
                    </td>
                    <?php } ?>
                    
                </tr>
            <?php $count++; } ?>

            <tr>
                <td colspan="6" class="text-right">
                    <b>Total</b>
                </td>
                <td align="center">@currencyPDF($invoice->amount)
                    
                </td>
                <?php if($invoice->branch->alias != 'CST') { ?>
                 <td colspan="2" class="text-right">@currencyPDF($invoice->tax / 2)</td>
                 <td colspan="2" class="text-right">@currencyPDF($invoice->tax / 2)</td>
                 <?php } else { ?>
                 <td colspan="2" class="text-right">@currencyPDF($invoice->tax)</td>
                 <?php } ?>
            </tr>


             <?php if($invoice->transport != 0) { ?>
                <tr>
                    <td colspan="6" class="text-right" >Transportation Charge
                 
                    </td>
                    <td class="text-right" colspan="<?= $colspan ?>">
                       @currencyPDF($invoice->transport)
                    </td>
                </tr>
            <?php } ?>

            <tr>
                <td  colspan="6" class="text-right">
                    <b>Total INR</b>
                </td>
                <td class="text-right" colspan="<?= $colspan ?>">
                    <b>@currencyPDF($invoice->total)</b>
                </td>
            </tr>
         
        </tbody>
    </table>
</div>
<footer>
    <div class="row f12">
        <div class="col-md-12">
            Amount in words:<br/> 
            {{$amountInWords}} only.
        </div>
        <div class="col-md-12">
            <div style="margin-left: 70%;text-align: center;margin-top: 80px">
                For <b>AIMS BUILDMART PVT. LTD</b><br/>
                Authorized Signatory
            </div>
        </div>
    </div>
</footer>