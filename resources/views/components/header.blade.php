<header id="igw-header">
    <div class="title">
        <h3>{!! $breadcrumbs !!}</h3>
    </div>
    <div class="actions">
        <nav id="igw-header-actions">
            <a href="{{ env('WEBSITE_URL') }}" target="_blank" class="view">
                <div class="circle"><img src="/igw/icons/glasses.svg"></div>
                <span>View website</span>
            </a>
            <a href="{{route('logout')}}" class="logout">
                <div class="circle"><img src="/igw/icons/logout.svg"></div>
                <span>Logout {{Auth::user()->name}}</span>
            </a>
        </nav>
    </div>
</header>
