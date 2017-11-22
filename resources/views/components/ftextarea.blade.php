<div class="input textarea html" data-options="{{$options}}">
    <label for="{{$name}}">{{$label}}</label>
    <textarea id="{{$name}}" name="{{$name}}" {{$required ? 'required' : ''}}>{!!$value ? $value : '<p></p>'!!}</textarea>
</div>
