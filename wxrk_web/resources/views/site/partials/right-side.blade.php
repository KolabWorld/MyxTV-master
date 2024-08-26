<style type="text/css">
	.notify{
		/*display: none;*/
		top: 20px; right: 20px; 
		position: fixed; 
		width: 310px; height: auto; 
		margin: 0px; padding: 0px; 
		list-style-type: none; 
		z-index: 10000000;
	}
	.notify .alert {
		display: none;
	}
</style>

<div class="notify">
	<div class="alert alert-danger alert-dismissible">
        <div class="alert-msg"></div>
    </div>
    <div class="alert alert-info alert-dismissible">
        <div class="alert-msg"></div>
    </div>
    <div class="alert alert-warning alert-dismissible">
         <div class="alert-msg"></div>
    </div>
    <div class="alert alert-success alert-dismissible">
        <div class="alert-msg"></div>
    </div>
</div>