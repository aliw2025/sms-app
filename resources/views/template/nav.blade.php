<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Message API</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            @auth
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('index')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('history')}}">History</a>
                </li>
            </ul>

            <form method="POST" action="{{ route('logout') }}" class="d-flex ms-auto">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-outline-danger ms-2">Logout</button>
            </form>
            @endauth
        </div>
    </div>
</nav>