@extends('layouts.home')

@section('content')

<div class="container">
<center>
    <div class="filler">
<svg width="200" height="200">
    <filter id="innerShadow" x="-20%" y="-20%" width="140%" height="140%" >
        <feGaussianBlur in="SourceGraphic" stdDeviation="3" result="blur"/>
        <feOffset in="blur" dx="2.5" dy="2.5"/>
    </filter>

    <g>
        <circle id="shadow" style="fill:rgba(0,0,0,0.1)" cx="97" cy="100" r="87" filter="url(#innerShadow)"></circle>
        <circle id="circle" style="stroke: #E8EAF6; stroke-width: 4px; fill:#212121" cx="100" cy="100" r="80"></circle>
    </g>
    <g>
        <line x1="100" y1="100" x2="100" y2="55" transform="rotate(80 100 100)" style="stroke-width: 3px; stroke: #E8EAF6;" id="hourhand">
            <animatetransform attributeName="transform"
                              attributeType="XML"
                              type="rotate"
                              dur="43200s"
                              repeatCount="indefinite"/>
        </line>
        <line x1="100" y1="100" x2="100" y2="40" style="stroke-width: 4px; stroke: #E8EAF6;" id="minutehand">
            <animatetransform attributeName="transform"
                              attributeType="XML"
                              type="rotate"
                              dur="3600s"
                              repeatCount="indefinite"/>
        </line>
        <line x1="100" y1="100" x2="100" y2="30" style="stroke-width: 2px; stroke: #E8EAF6;" id="secondhand">
            <animatetransform attributeName="transform"
                              attributeType="XML"
                              type="rotate"
                              dur="60s"
                              repeatCount="indefinite"/>
        </line>
    </g>
    <circle id="center" style="fill:#1A237E; stroke: #E8EAF6; stroke-width: 2px;" cx="100" cy="100" r="3"></circle>
</svg>
</div>
</center>

</div>
	<script src="{{asset('js/js/clock.js')}}"></script>
@endsection

