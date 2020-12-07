<a class="btn btn-primary btn-sm a-action" title="Редактирай Продукт" href="{{ route('products.edit', $product) }}">
    <i class="fa fa-pencil"></i>
</a>
<button class="btn btn-danger btn-sm delete-product" data-product="{{ $product->name }}" data-product-id="{{ $product->id }}" title="Изтрий Продукта">
    <i class="fa fa-trash"></i>
</button>
