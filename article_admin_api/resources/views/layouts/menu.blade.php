<li class="nav-item">
    <a href="{{ route('stores.index') }}"
       class="nav-link {{ Request::is('stores*') ? 'active' : '' }}">
        <p>Stores</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('jobs.index') }}"
       class="nav-link {{ Request::is('jobs*') ? 'active' : '' }}">
        <p>Jobs</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('jobCates.index') }}"
       class="nav-link {{ Request::is('jobCates*') ? 'active' : '' }}">
        <p>Job Cates</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('appUsers.index') }}"
       class="nav-link {{ Request::is('appUsers*') ? 'active' : '' }}">
        <p>App Users</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('feedBack.index') }}"
       class="nav-link {{ Request::is('feedBack*') ? 'active' : '' }}">
        <p>Feed Back</p>
    </a>
</li>


