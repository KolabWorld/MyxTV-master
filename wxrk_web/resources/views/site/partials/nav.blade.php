<nav class="navbar navbar-inverse" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#ip-navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				Menu &nbsp; <i class="fa fa-bars"></i>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="ip-navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-caret-down"></i> &nbsp;<span class="hidden-sm">Quotations</span><i class="visible-sm-inline fa fa-file-text"></i>
					</a>
					<ul class="dropdown-menu">
						<li><a  href="/quotation/create" class="create-invoice">Create Quotation</a></li>
						<li><a href="/quotations">View Quotations</a></li>
					   
					</ul>
				</li>
				
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-caret-down"></i> &nbsp;<span class="hidden-sm">Invoices</span><i class="visible-sm-inline fa fa-file-text"></i>
					</a>
					<ul class="dropdown-menu">
						<li><a  href="/invoice/create" class="create-invoice">Create Invoice</a></li>
						<li><a href="/invoices">View Invoices</a></li>
					   
					</ul>
				</li>

			</ul>			
			<ul class="nav navbar-nav navbar-right">		   
				<li>
					<a href="#"> {{Auth::user()->name}} </a>
				</li>
				<li>
					<a href="/admin"> Admin Panel </a>
				</li>
				<li>
					<a href="/logout" class="tip icon logout" data-placement="bottom" data-original-title="Logout">
						<i class="fa fa-power-off"></i>
						<span class="visible-xs">&nbsp;Logout</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<div class="sidebar hidden-xs hidden">
	<ul>
		<li>
			<a href="/invoices" title="" class="tip" data-placement="right" data-original-title="Invoices">
				<i class="fa fa-dashboard"></i>
			</a>
		</li>
		<li>
			<a href="/quotations" title="" class="tip" data-placement="right" data-original-title="Quotations">
				<i class="fa fa-text"></i>
			</a>
		</li>
	   
		<li>
			<a href="/admin" title="" class="tip" data-placement="right" data-original-title="Admin">
				<i class="fa fa-file-text"></i>
			</a>
		</li>
	</ul>
</div>
