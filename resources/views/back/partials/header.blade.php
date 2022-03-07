<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">


        <!-- Messages Dropdown Menu -->
        <form method="post" action="{{route('logout')}}">
            @csrf
            <button type="submit" class="btn btn-danger">Çıkış yap</button>
        </form>
        </li>
    </ul>
</nav>
