@extends('layouts.app')


@section('content')
<div class="container">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Role Management</h2>
        </div><br>
        <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a><br><br>
            @endcan
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
     <th width="280px">Action</th>
  </tr>
    @foreach ($roles as  $role)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $role->name }}</td>
        <td>
            <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
            @can('role-edit')
                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
            @endcan
            @can('role-delete')
                <!-- <form action="{{route('roles.destroy',$role->id)}}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Delete
                    </button>
                </form> -->
                <button class="btn btn-danger" onclick="deleteItem(this)" data-id="{{ $role->id }}">Delete</button>
            @endcan
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
                            url:"roles/"+id,
                            data:{
                                "_token": "{{ csrf_token() }}",
                                "_method": 'DELETE',
                            },
                            success:function(data) {
                                if (data.success){
                                    swalWithBootstrapButtons.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
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