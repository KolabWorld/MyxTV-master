<div v-bind:class="{ 'active': activeTab == 'attribute' }" id="attributes" class="tab-pane">
    <div class="box-body" >
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <add-attribute-panel>
                            <div class="form-group">
                                <label class="control-label" style="margin: 5px !important;">
                                    <b>Attribute</b>
                                </label> 
                                <input type="text" name="name" v-model="attribute.inputs.name" class="form-control" placeholder="Enter Attribute !!">   
                            </div>
                            <div class="form-group text-right" style="border: none">
                                <button type="submit" id="submitButton" value="Save" v-on:click="saveProductServiceAttribute()" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok-circle"></span>
                                    Save
                                </button>
                                <a type="reset" class="btn btn-warning close_popup" href="/admin/setup/product-service/{{$productService->id}}/view">
                                    <span class="glyphicon glyphicon-ban-circle"></span> Cancel
                                </a>
                            </div>
                        </add-attribute-panel>
                    </div>
                    <div class="col-md-6">
                        <view-attribute-panel>
                            <ul class="conversation-list slimscroll " v-for="atr in attribute.data">
                                <li class="clearfix" style="list-style-type:none;box-shadow:0 1px 5px #333;padding:1%;">
                                    <div class="row">
                                        <div class="col-xs-10 col-sm-10 col-md-10">
                                            <div class="conversation-text">
                                                <div class="ctext-wrap">
                                                    <p style="display:flex;clear: both;float: left;padding-right:">
                                                        <span style="font-size: 16px; line-height: 20px; padding-left: 5px;">@{{atr.name}}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <a v-on:click="deleteProductServiceAttribute(atr.id)" data-toggle="tooltip" title="delete" class="btn btn-danger btn-xs pull-right"> 
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </view-attribute-panel>    
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>