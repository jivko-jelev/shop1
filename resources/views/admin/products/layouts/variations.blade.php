<div class="error-div">
    <input type="text" class="form-control" name="variation" placeholder="Вариация" value="{{ $product->variation->name }}">
</div>
@foreach($product->variation->subVariations as $subvariation)
    <div class="error-div">
        <div class="input-group">
            <input type="text" class="form-control" name="subvariation[{{ $subvariation->id }}]" placeholder="Стойност"
                   value="{{ $subvariation->name }}">
            <span class="input-group-btn">
                            <button type="button" class="btn btn-primary add-subvariation" title="Добави податрибут">
                                  <i class="fa fa-plus" aria-hidden="true"></i> 
                            </button> 
                            <button type="button" class="btn btn-danger delete-subvariation" title="Изтрий"
                                    data-route="{{ route('subvariation.destroy', $subvariation->id) }}"
                                    data-title="{{ $subvariation->name }}">
                                  <i class="fa fa-minus" aria-hidden="true"></i> 
                            </button> 
                       </span>
        </div>
    </div>
@endforeach
<script>
    document.getElementById('variations').style.display = "inherit";
</script>