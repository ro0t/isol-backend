<div class="input input--image">
    <label for="{{$name}}">{{$label}}</label>
    @if(isset($value[$name]))
    <div style="padding: 12px 0;"><a href="{{asset($value[$name])}}" target="_blank">View file</a></div>
    @endif
    <input class="input__field" type="file" accept="{{$accept}}" id="{{$name}}" name="{{$name}}" />
</div>
