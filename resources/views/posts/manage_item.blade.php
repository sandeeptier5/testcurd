@extends('layouts.default')

@section('content')

<div class="row">
            <div class="col-lg-12 margin-tb">                   
                <div class="pull-left">
                    <h2>Laravel Ajax CRUD Example</h2>
                </div>
                <div class="pull-right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item" id="create-manage-form">
                      Create Item
                </button>
                </div>
            </div>
</div>

        <table class="table table-bordered">
            <thead>
                <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th width="200px">Action</th>
                </tr>
            </thead>
            <tbody>
            
             @foreach($result as $key => $results)
              <tr>
                 <td>{{ $results->title }}</td>
                 <td>{{ $results->description }}</td>
                 <td><img src="{{ asset('images') }}/{{ $results->photo }}" style="height: 200px;width: 200px;"></td>
                 <td>
                     <button data-toggle="modal" data-id="{{ $results->id }}" id="edit-manage-form" class="btn btn-primary edit-item">Edit</button>
                     <button class="btn btn-danger remove-item" id="">Delete</button>
                 </td>
              </tr>   
            @endforeach   
             
            </tbody>
        </table>
       

        <ul id="pagination" class="pagination-sm">{!! $result->render() !!}</ul>

        <!-- Create Item Modal -->
        <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Create Item</h4>
              </div>
              <div class="modal-body">
              <div id="result"></div>
 <form enctype="multipart/form-data" id="contact_form" role="form" method="POST" action="" >            
<input type="hidden" id="token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="control-label" for="title">Title:</label>
                            <input type="text" name="title" id="title" class="form-control" data-error="Please enter title." required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Description:</label>
                            <textarea name="description" id="description" class="form-control" data-error="Please enter description." required></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Image:</label>
                            <input type="file" name="photo" id="photo" class="form-control" data-error="Please select image." required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn crud-submit btn-success btn-sava-item">Submit</button>
                        </div>
                    </form>
                          </div>
            </div>
          </div>
        </div>


 <!-- Create Item Modal for view -->
        <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Item</h4>
              </div>
              <div class="modal-body">
              <div id="result1"></div>
 <form enctype="multipart/form-data" id="contact_form_edit1" class="contact_form_edit" role="form" method="POST" action="" >            
<input type="hidden" id="token" value="{{ csrf_token() }}">
<input type="hidden" name="id" id="id">
                       <div class="form-group">
                            <img src="" id="get_img" style="height: 200px;width: 200px;">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Title:</label>
                            <input type="text" name="title" id="title1" value="" class="form-control" value="" data-error="Please enter title." required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Description:</label>
                            <textarea name="description" id="description1" class="form-control" data-error="Please enter description." required></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Image:</label>
                            <input type="file" name="photo" id="photo1" class="form-control" data-error="Please select image." required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn crud-submit btn-success btn-edit-item">Update</button>
                        </div>
                    </form>
                          </div>
            </div>
          </div>
        </div>        



@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $('#create-manage-form').on('click',function(){
            $('#create-item').modal();
        });
        
$('.btn-sava-item').on('click',function(e){
 
  e.preventDefault();
 
    var title          = $('input[name=title]').val(); 
    var description    = $('textarea[name=description]').val();
    var photo          = $('input[name=photo]')[0].files[0];

    var proceed = true;
    if(title==""){ 
        $('input[name=title]').css('border-color','red'); 
        proceed = false;
    }
    if(description==""){ 
        $('textarea[name=description]').css('border-color','red'); 
        proceed = false;
    }
    if(proceed){
        var post_data = new FormData();    
        post_data.append( 'title', title );
        post_data.append( 'photo', photo );
        post_data.append( 'description', description );    
            $.ajax({
              url: "{{ route('itemInsertPost') }}",
              data: post_data,
              processData: false,
              contentType: false,
              type: 'POST',
              dataType:'json',
              success: function(data){
                     // console.log(data);
                      if(data.status == 'success') {
                        output = '<div class="success">'+data.msg+'</div>';            
                        //reset values in all input fields
                        $('#contact_form input').val(''); 
                        $('#contact_form textarea').val('');          
                      }
                      $("#result").hide().html(output).slideDown();
              }
            });
          }      
    });
  //reset previously set border colors and hide all message on .keyup()
    $("#contact_form input, #contact_form textarea").keyup(function() { 
        $("#contact_form input, #contact_form textarea").css('border-color',''); 
        $("#result").slideUp();
    });

    $('.edit-item').on('click',function(e){
      var dataId = $(this).data('id');
      //alert(dataId);
      $('#edit-item').modal();

      $.get("{{ route('itemEditPost') }}",{id:dataId},function(data){
        console.log(data);
         //$('#title').val(data.title);
         $('#id').val(data.id);
         $('#title1').val(data.title);
         $('#description1').val(data.description);
         var photoName = data.photo;
         
         $('#get_img').attr('src',BASE_URL+'/images/'+photoName);
      });    
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#get_img').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#photo1").change(function(){
        readURL(this);
    });
    
    $('.btn-edit-item').on('click',function(e){
 
      e.preventDefault();
      var dataId         = $('input[name=id]').val();
      var title          = $('input[name=title]').val(); 
      var description    = $('textarea[name=description]').val();
      var photo          = $('input[name=photo]')[0].files[0];
      var proceed = true;
    /*  if(title==""){ 
          $('input[name=title]').css('border-color','red'); 
          proceed = false;
      }
      if(description==""){ 
          $('textarea[name=description]').css('border-color','red'); 
          proceed = false;
      }*/
      if(proceed){
          var post_data = new FormData();   
          //post_data.append( 'id', id ); 
          post_data.append( 'title', title );
          post_data.append( 'photo', photo );
          post_data.append( 'description', description ); 
          $.ajax({
              url: "{{ route('itemUpdatePost') }}",
              data: {post_data:post_data},
              processData: false,
              contentType: false,
              type: 'GET',
              dataType:'json',
              success: function(data){
                     // console.log(data);
                      if(data.status == 'success') {
                        output = '<div class="success">'+data.msg+'</div>';            
                        //reset values in all input fields
                        $('#contact_form1 input').val(''); 
                        $('#contact_form1 textarea').val('');          
                      }
                      $("#result1").hide().html(output).slideDown();
              }
            });   
      }
  });

});
</script>
@endsection