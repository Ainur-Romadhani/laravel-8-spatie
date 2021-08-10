@extends('layouts.app')


@section('content')
<div class="container">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Users Management</h2>
        </div><br>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a><br><br>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
<table class="table table-striped">
 <tr>
   <th>No</th>
   <th>Name</th>
   <th>Email</th>
   <th>Roles</th>
   <th width="280px">Action</th>
 </tr>
 @foreach ($data as $user)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
      @if(!empty($user->getRoleNames()))
        @foreach($user->getRoleNames() as $v)
           <label class="badge badge-success">{{ $v }}</label>
        @endforeach
      @endif
    </td>
    <td>
       <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
       <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
       <!-- <form action="{{route('users.destroy',$user->id)}}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-danger">
                Delete
            </button>
        </form> -->
        <button class="btn btn-danger" onclick="deleteItem(this)" data-id="{{ $user->id }}">Delete</button>
    </td>
  </tr>
 @endforeach
</table>
</div>
<script type="application/javascript">

        function deleteItem(e){

            let id = e.getAttribute('data-id');
            console.log(id)

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true
            });

            swalWithBootstrapButtons.fire({
                title: 'هل تريد الاستمرار؟?',
                text: "لن تتمكن من التراجع عن هذا!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم ، احذفها!',
                cancelButtonText:  'لا ، إلغاء!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    if (result.isConfirmed){

                        $.ajax({
                            type:'POST',
                            url:"users/"+id,
                            data:{
                                "_token": "{{ csrf_token() }}",
                                "_method": 'DELETE',
                            },
                            success:function(data) {
                                if (data.success){
                                    swalWithBootstrapButtons.fire(
                                        'تم الحذف!',
                                        'تم حذف ملفك.',
                                        "success"
                                    ).then((result) => {
                                        location.reload();
                                    })
                                    $("#"+id+"").remove(); // you can add name div to remove
                                }
                            }
                           
                        });

                    }

                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'ألغيت',
                        'ملفك التخيلي آمن:)',
                        'error'
                    );
                }
            });

        }

    </script>
@endsection