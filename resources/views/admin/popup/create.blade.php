@extends('admin.layouts.popup')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @include('message.alert')
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="card-title">Create Popup</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.popup.store') }}" method="post" id="popup-form" >
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="title" name="title" class="form-control" required autocomplete="title" autofocus maxlength="200">
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <!-- <input type="content" name="email" class="form-control" required autocomplete="email"> -->
                            <div>
                                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" style="min-height:200px !important" autofocus></textarea>

                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="text" name="image" class="form-control" required autocomplete="image">
                        </div>
                        <div class="form-group">
                            <label>Button</label>
                            <input type="text" name="bt_name" class="form-control" required autocomplete="bt_name">
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="" class="btn btn-secondary"  data-dismiss="modal">Close</a>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
// CKEDITOR.replace( 'content' );
    // jQuery Validation
    $(function(){
        $('#popup-form').validate(
        {
            rules:{
              
            }
        }); //valdate end
    }); //function end
</script>
@endsection