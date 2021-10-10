<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Products</div>

                <div class="card-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Price</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 0; @endphp

                            @foreach ($products as $product)
                                @php $no++; @endphp

                                <tr>
                                    <td scope="col">{{ $no }}</td>
                                    <td>{{ $product->title }}</td>
                                    <td>Rp {{ number_format($product->price,2,",",".") }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info text-white">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
