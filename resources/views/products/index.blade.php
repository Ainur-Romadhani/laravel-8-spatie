@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Products</h2>
            </div><br>
            <div class="pull-right">
                @can('product-create')
                <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a><br><br>
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
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($products as $product)
	    <tr>
	        <td>{{ $loop->iteration }}</td>
	        <td>{{ $product->name }}</td>
	        <td>{{ $product->detail }}</td>
	        <td>
                    <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a>
                    @can('product-edit')
                    <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
                    @endcan
                    @can('product-delete')
                    <button class="btn btn-danger" onclick="deleteItem(this)" data-id="{{ $product->id }}">Delete</button>
                    @endcan
               
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $products->links() !!}

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
                            url:"product/"+id,
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
                                    );
                                    $("#"+id+"").remove(); // you can add name div to remove
                                    location.reload();
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