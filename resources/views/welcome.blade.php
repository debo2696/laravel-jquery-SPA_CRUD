<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
        <title>CRUD with JQuery</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        
    </head>
    <body>
        <div class="container">
            <h2>CRUD using JQuery's Modal in Laravel 8</h2>
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-info btn-lg"  id="add_todo">Add Todo</button>
        
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Todo Name</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody id="list_todo">
                    @foreach($todos as $todo)
                    <tr id="row_todo_{{$todo->id}}">
                    <td>{{$todo->id}}</td>
                    <td>{{$todo->name}}</td>
                    <td>
                        <button type="button" id="edit_todo" data-id="{{$todo->id}}" class="btn btn-sm btn-info">Edit</button> <!--Data id's id goin to edit data jquery-->
                        <button type="button" id="delete_todo" data-id="{{$todo->id}}" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>

            <!-- Modal -->
            <div class="modal fade" id="modal_todo" role="dialog">
            <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content">
                <form id="form_todo" >        
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="modal_title"></h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <input type="text" name="name" id="name_todo" placeholder="Enter Todo...">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-blue" >Submit</button>
                    </div>
                </form>
                </div>
            
            </div>
            </div>
            
        </div>
        <script type="text/javascript">

        $(document).ready(function(){
            //CSRF token sending in the beginning so that it does not need to be sent on every action
            $.ajaxSetup({
                headers:{
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });    
        //Modal popping up
        $("#add_todo").on('click',function(){
            console.log("Opening modal");
            $("#form_todo").trigger('reset');
            $("#modal_title").html('Add todo');
            $("#modal_todo").modal('show');
        });
        //Edit
        $("body").on('click', '#edit_todo', function(){
            var id= $(this).data('id');
            console.log("Edited"+ id+ "th Todo");
            $.get('todos/'+id+'/edit', function(res){
                console.log('todos/'+id+'/edit');
                $("modal_title").html('Edit Todo');
                $("#id").val(res.id);
                $("#name_t  odo").val(res.id);
                $("#modal_todo").modal('show');
            });
        });
        //Deletion
        $("body").on('click', '#delete_todo', function(){
            var id= $(this).data('id');
            console.log("Deleted"+ id+ "th Todo");
            confirm('Are you sure you want to delete?');
            $.ajax({
                type: 'DELETE',
                url: "todos/destroy/" + id,

            }).done(function(){
                var n=$("#row_todo_" + id).remove();    
            });
        });
        //Creation or Store
        $("form").on('submit', function(e){
            console.log("Submitting form");
            e.preventDefault();
            $.ajax({
                url: "todos/store",
                data: $("#form_todo").serialize(),
                type: "POST"
            }).done(function(res){
                var row='<tr id="row_todo_' +res.id+'">';
                row += '<td>' + res.id + '</td>';
                row += '<td>' + res.name + '</td>';
                row += '<td>' + '<button type="button" id="edit_todo" data-id="'+res.id+'" class="btn btn-sm btn-info">Edit</button>' +
                '<button type="button" id="delete_todo" data-id="'+res.id+'" class="btn btn-sm btn-danger">Delete</button>' + '</td>';
            

                if($("#id").val()){
                    $("#row_todo_" + res.id).replaceWith(row);
                }else{
                    $("#list_todo").prepend(row);
                }
            });

            $("#form_todo").trigger('reset');
            $("#modal_todo").modal('hide');
        });
        

        </script>
    </body>
</html>
