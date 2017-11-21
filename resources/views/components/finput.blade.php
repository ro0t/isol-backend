<div class="input">
    <label for="{{$name}}">{{$label}}</label>
    <input class="input__field" type="{{$type}}" id="{{$name}}" name="{{$name}}" value="{{$value}}" list="list-{{$name}}" {{ $required ? 'required' : '' }} />
    @if(!empty($description))
    <span class="input__description">{{$description}}</span>
    @endif
</div>
