<ul class="nav nav-tabs">
	<li class="@if ($clientTab =='summary') active @endif">
		<a href="/admin/users/{{ $user->id }}/view">Summary</a>
	</li>
	<li class="@if ($clientTab =='profile') active @endif">
		<a href="/admin/users/{{ $user->id }}/view/profile" >Profile</a>
	</li>
	<li class="@if ($clientTab =='services') active @endif">
		<a href="/admin/users/{{ $user->id }}/view/services" >Products/Services</a>
	</li>
	<li class="@if ($clientTab =='domains') active @endif">
		<a href="/admin/users/{{ $user->id }}/view/domains" >Domains</a>
	</li>
	<li class="@if ($clientTab =='billable') active @endif">
		<a href="/admin/users/{{ $user->id }}/view/billable" >Billable Items</a>
	</li>
	<li class="@if ($clientTab =='orders') active @endif">
		<a href="/admin/users/{{ $user->id }}/view/orders" >Orders</a>
	</li>
	<li class="@if ($clientTab =='invoices') active @endif">
		<a href="/admin/users/{{ $user->id }}/view/invoices" >Invoices</a>
	</li>
	<li class="@if ($clientTab =='transactions') active @endif">
		<a href="/admin/users/{{ $user->id }}/view/transactions" >Transactions</a>
	</li>
	<li class="@if ($clientTab =='wallets') active @endif">
		<a href="/admin/users/{{ $user->id }}/view/user-wallets" >Wallet</a>
	</li>
	<li class="@if ($clientTab =='mails') active @endif">
		<a href="/admin/users/{{ $user->id }}/view/user-mails" >E-Mail</a>
	</li>
</ul>