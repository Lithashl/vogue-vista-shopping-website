<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="VogueVista navigation bar">

            <div class="container">
                <a class="navbar-brand" href="/">VogueVista<span>.</span></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsVogueVista" aria-controls="navbarsVogueVista" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsVogueVista">
                    <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                        <li class="nav-item <?php echo $active[0] ?>">
                            <a class="nav-link" href="\">Home</a>
                        </li>
                        <li><a class="nav-link <?php echo $active[1] ?>" href="about">About us</a></li>
                        <!-- <li><a class="nav-link <?php echo $active[2] ?>" href="service">Services</a></li> -->
                        <!-- <li><a class="nav-link <?php echo $active[3] ?>" href="blog">Blog</a></li>
                        <li><a class="nav-link <?php echo $active[4] ?>" href="contact">Contact us</a></li> -->
                    </ul>

                    <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                        <li class="dropdown">
                            <a class="nav-link" href="#" data-bs-toggle="dropdown" aria-expanded="false"><img src="images/user.svg"></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item">
                                    <a class="nav-link dropdown-text" href="admin/login">Login</a>
                                </li>
                                <li class="dropdown-item">
                                    <a class="nav-link dropdown-text" href="admin/register">Register</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="nav-link" href="cart"><img src="images/cart.svg"></a></li>
                    </ul>
                </div>
            </div>
        </nav>