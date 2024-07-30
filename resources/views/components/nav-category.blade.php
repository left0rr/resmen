@props(['active'=>false,'category'])
<li>
    <a  href="/menu/{{ $category->name }}" class="{{$active ? : '' }}" aria-current="{{$active ? 'page':'false'}}">
        <img src="{{$category->logo}}" alt="" class="resized-png">
        {{ $category->name }}
    </a>
</li>
