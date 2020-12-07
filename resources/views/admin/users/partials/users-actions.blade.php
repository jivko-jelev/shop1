<div class="text-center">
    <a class="btn btn-primary btn-sm a-action" title="Редактирай Потребител" href="{{ route('users.edit', $user) }}">
        <i class="fa fa-pencil"></i>
    </a>
    <button class="btn btn-danger btn-sm delete-user" id="{{ "delete-user-$user->id" }}" data-username="{{ $user->name }}"
            data-user-id="{{ $user->id }}" title="Изтрий Потребителя">
        <i class="fa fa-trash"></i>
    </button>
</div>