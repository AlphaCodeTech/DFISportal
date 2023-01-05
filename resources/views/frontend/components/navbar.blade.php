<section class="header">
    <div class="navbar">
        <div class="logo">
            <img src="{{ asset('frontend/logo.png') }}" alt="">
        </div>

        <div class="nav">
            <ul class="nav__menu">
                <li>
                    <div class="dropdown">
                        <div class="dropbtn">Menu</div>
                        <div class="dropdown-content">
                            <a href="{{ route('form.purchase') }}">Purchase Admission</a>
                            <a href="{{ route('form.purchase',['enabled' => true,'id' => session()->get('id')]) }}">Continue Registration</a>
                            <a href="{{ route('fees.verify') }}">Verify School Fees</a>

                        </div>
                    </div>
                </li>
                <li><a href="{{ route('fees.pay') }}">Pay Fees</a></li>
                <li> <a href="/">Programs</a></li>
                <li> <a href="#about">About</a></li>
                <li> <a href="#gallery">Gallery</a></li>
                <li> <a href="#result-checker">Result Checker</a></li>
                <li> <a href="#contact">Contact</a></li>
            </ul>
            <button id="open-menu-btn"><i class="uil uil-bars"></i></button>
            <button id="close-menu-btn"><i class="uil uil-multiply"></i></i></button>
        </div>
    </div>
</section>
<!--Section Header Ends-->
