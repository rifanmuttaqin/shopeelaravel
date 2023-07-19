<a class='btn btn-info' href='{{ route('produk-show', $product) }}'><i class='far fa-eye'></i></a> 
<a class='btn btn-info' href='{{ route('produk-edit', $product) }}'><i class='far fa-edit'></i></a>
<button class='btn btn-info' onclick="deleteAction('{{ $product->id }}')" data-id="{{ $product->id }}"><i class='fas fa-trash'></i></button>