<div class="text-center">
<a class="btn btn-primary btn-sm" title="Редактирай Категорията" href="{{ route('categories.edit', $category) }}">
    <i class="fa fa-pencil"></i></a>
<button class="btn btn-danger btn-sm delete-category" data-route="{{ route('categories.destroy', $category) }}"
        data-title="{{ $category->title }}"
        title="Изтрий Категорията">
    <i class="fa fa-trash"></i>
</button>
</div>