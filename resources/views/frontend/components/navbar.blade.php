<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container text-light">
        <img class="navbar-brand" src="{{ asset('frontend/logo.png') }}" alt="">

        <button class="navbar-toggler-dark d-lg-none bg-secondary" type="button-dark" data-bs-toggle="collapse"
            data-bs-target="#navmenu">
            <span class="navbar-toggler-icon bg-secondary"></span>
        </button>


        <div class="collapse navbar-collapse text-center" id="navmenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ route('home.index') }}" class="nav-link text-light">Home</a>
                </li>
                <li class="nav-item">
                    <a href="" data-bs-toggle="modal" data-bs-target="#register"
                        class="nav-link text-light">Admission</a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('form.purchase') }}" class="nav-link text-light">Admission</a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('fees.show') }}" class="nav-link text-light">Fees</a>
                </li>
                <li class="nav-item">
                    <a href="#gallery" class="nav-link text-light">Gallery</a>
                </li>
                <li class="nav-item">
                    <a href="#contact" class="nav-link text-light">Contact</a>
                </li>
                <li class="nav-item">
                    <a href="#about" class="nav-link text-light">About</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
