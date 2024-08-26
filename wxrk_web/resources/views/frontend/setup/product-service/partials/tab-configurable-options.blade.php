
<form action="/admin/setup/product-service/configurable-option/update" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="product_service_id" value="{{$productService->id}}">
    <div class="box-body">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group {{{ $errors->has('config_group_id') ? 'has-error' : '' }}}">
                            {!! Form::label('config_group_id', 'Assigned Option Groups') !!}
                            <select id="config_groups" name="config_groups[]" multiple>
                                @foreach($configGroups as $configGroup)
                                    <option value="{!! $configGroup->id !!}" @if($productService->hasConfigGroup($configGroup->name))selected @endif>
                                        {!! $configGroup->name !!}
                                    </option>
                                @endforeach 
                            </select>
                            <label for="config_group_id"></label>
                            {!! $errors->first('config_group_id', '<label class="control-label" for="config_group_id">:message</label>')!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
    
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">
            <span class="glyphicon glyphicon-ok-circle"></span>
            Save Changes
        </button>
        <a type="reset" class="btn btn-warning close_popup" href="/admin/setup/product-service/{{$productService->id}}/view">
            <span class="glyphicon glyphicon-ban-circle"></span> Cancel Changes
        </a>
    </div>
</form>
