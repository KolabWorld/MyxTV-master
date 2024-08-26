<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@section('title') Aimsbuildmart @show</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="keywords" content="Aimsbuildmart"/>
    <meta name="author" content="Ashish Chauhan"/>
    <meta name="description" content="Aimsbuildmart"/>
    <style type="text/css">
        .hrline{
            height: 10px;
            width:720px;
			background-repeat:repeat;
			height: 10px;
			margin-top: 20px;
			margin-bottom: 20px;
        }

        th { font-size: 10px;
            text-align: center;
        }
        td { font-size: 9px !important; }
        .heading1 {
            font-size: 20px; font-weight: bold;
        }
        .heading2{
            font-size: 14px; 
            font-weight: bold;   
            margin-bottom: 10px;
        }
        .f15 {
            font-size: 14px;
        }
        .f12 {
            font-size: 11px;
        }
        .f10 {
            font-size: 9px;
        }
        .logo {
            height: 70px;
        }
        .address {
            float: left;
            line-height: 15px;
            border: 1px solid #000;
            padding: 10px;
            width: 45%;
			margin-left: 10px;
        }
        .invoice .address {
            min-height: 180px;
        }
        .quotation .address {
            height: 120px;
        }
        hr {
            border-top-color: #000 !important;
            margin-top: 5px !important;
            margin-bottom: 5px !important;
        }
        
		table {
			width: 100%;
			border-collapse: collapse;
			border-spacing: 0;
			margin-bottom: 20px;
			margin: auto;
			font-size: 8px;
		}

		table th {
			padding: 5px 5px;
			text-align: center;
			font-weight: bold;
			white-space: nowrap; 
			font-size: 9px;
		}

		table td {
			padding: 5px 5px;
			text-align: right;
			font-size: 11px;
		}

		table td {
			text-align: right;
		}

		table td h3{
			color: #101010;
			font-size: 1.0em;
			font-weight: bold;
			margin: 0 0 0.2em 0;
		}

		table .no {
			color: #FFFFFF;
			font-size: 1.6em;
			background: #57a4ff;
		}

		table .sno {
			text-align: center;
			vertical-align: top;
		}

		table .desc {
			text-align: left;
		}

		table .tax {
			background: #DDDDDD;
		}

		table .total {
			background: #57a4ff;
			color: #FFFFFF;
		}

		table td.basecost,
		table td.qty,
		table td.total {
			font-size: 11px;
			text-align: center;
		}
	
		table tfoot tr:last-child td {
			color: #101010;
			font-size: 1.4em;
			font-weight: bold;

		}

		table .grey {
			background: #f2f2f2 !important;
			font-weight: bold;
		}

		.text-center {
			text-align: center;
		}
    </style>

</head>
<body>
	@yield('content')
</body>
</html>