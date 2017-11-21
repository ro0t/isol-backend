<aside id="igw-sidebar">
    <div class="logo"></div>
    <nav>
        <a href="{{route('home')}}" class="pages {{ isActive('/') }}"><span>Pages</span></a>
        <a href="{{route('news')}}" class="news {{ isActive('news') }}"><span>News</span></a>
        <a href="{{route('products')}}" class="products {{ isActive('product') }}"><span>Products</span></a>
        <a href="{{route('categories')}}" class="categories {{ isActive('categories') }}"><span>Product categories</span></a>
        <a href="{{route('manufacturers')}}" class="manufacturer {{ isActive('manufacturers') }}"><span>Manufacturers</span></a>
        @if(Auth::check() && Auth::user()->super_admin)
        <a href="{{route('users')}}" class="users {{ isActive('users') }}"><span>User manager</span></a>
        @endif
        <a href="{{route('settings')}}" class="settings {{ isActive('settings') }}"><span>Settings</span></a>
    </nav>
</aside>
