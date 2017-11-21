<div class="input input--image">
    <label for="{{$name}}">{{$label}}</label>
    <div class="preview-image">
        @if(!empty($value))
        <img src="{{asset($value)}}">
        @endif
    </div>
    <input class="input__field" type="file" accept="{{$accept}}" id="{{$name}}" name="{{$name}}" />
</div>
