@extends('admin.app')
<!-- Main Container  -->
@section('content')
@include('admin.partials.header',['title'=>''.$designer->name.'','description'=>'Refund Policy'])
<section class="content mb-5">
        <div class="container-fluid">
            <form method="post" action="">
                <div class="row mb-2" style="margin-top:-15px">
                    <div class="col-sm-12 mb-3">
                        <div class="backbtnPanel">
                            <div ></div>
                            <div>
                                <a href="{{ url('admin/designers/'.$designer->id)}}" class="btn btn-sm btn-auto btn-outline-dark">Back</a>
                                <button type="submit" id="save" class="btn btn-sm btn-dark btn-auto">Update Policy</button>
                            </div>
                        </div>
                    </div>
                </div>  
                @csrf
                <input type="hidden" name="id" value="{{$refundPolicy ? $refundPolicy->id : 0}}">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group textarea-group">
                            <label for="exampleFormControlTextarea1" style="color:#333333">Refund policy for Made-to-Mesure</label>
                            <textarea class="form-control theme-Ltext ckeditor" name="description" id="" rows="10">{{$refundPolicy ? $refundPolicy->description : ''}}</textarea>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group textarea-group">
                            <label for="exampleFormControlTextarea1" style="color:#333333">Refund policy for SUR-MESURE</label>
                             
                            <textarea class="form-control theme-Ltext ckeditor" name="description_1" id="" rows="10">{{$refundPolicy ? $refundPolicy->description_1 : ''}}</textarea>
                            
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="/assets/admin/ckeditor/ckeditor.js"></script>
    <script src="/assets/admin/ckeditor/samples/js/sample.js"></script>
    <link rel="stylesheet" href="/assets/admin/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
    <script type="text/javascript"> 
        CKEDITOR.replace( 'description' );
        CKEDITOR.add            
                             
        CKEDITOR.replace( 'description_1' );
        CKEDITOR.add            
    </script>
    
@endsection