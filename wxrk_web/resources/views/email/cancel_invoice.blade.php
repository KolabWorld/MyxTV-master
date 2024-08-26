
Invoice <a href="{{$data['invoice_url']}}"> <b> {{$data['invoice']->invoice->invoice_no}} </b></a> is canceled by {{$data['invoice']->invoice->updatedBy->name }} ({{$data['invoice']->invoice->updatedBy->email}}). Please see the details below or Click <a href="{{$data['invoice_url']}}"> <b> Here </b></a> to see the invoice...
<br/>
<br/>

Invoice to: {{$data['invoice']->salon->registered_name}} ({{str_replace('Glam Studio','',$data['invoice']->salon->name)}}) <br/>
Total Amount: {{$data['invoice']->invoice->total_amount}}<br/>
Tax: {{$data['invoice']->invoice->total_tax }}<br/>
Adjustment: {{$data['invoice']->invoice->adjustment}}<br/>
Balance Amount: {{$data['invoice']->invoice->invoice_total}}<br/>

