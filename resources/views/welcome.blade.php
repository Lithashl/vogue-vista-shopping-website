
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="favicon.png">

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />


        <!-- Bootstrap CSS -->
        @include ("css-link")

        <title>Welcome </title>
        </head>
<body class="antialiased">
    <!-- Navigation Bar -->
    <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="VogueVista navigation bar">
        <!-- Your navigation content here -->
        <!-- Example login, register, and home links -->
        <div class="container">
            <a class="navbar-brand" href="/">VogueVista<span>.</span></a>
            <!-- Rest of your navigation elements -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <!-- Login -->
                    @guest
                        <a class="nav-link" href="{{ route('login') }}">Log in</a>
                    @endguest
                </li>
                <li class="nav-item">
                    <!-- Register -->
                    @guest
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    @endguest
                </li>
                <li class="nav-item">
                    <!-- Home link -->
                    @auth
                        <a class="nav-link" href="{{ url('/home') }}">Home</a>
                    @endauth
                </li>
            </ul>
        </div>
    </nav>


        <!-- Start Hero Section -->
			<div class="hero">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
								<h1>VogueVista</h1>
								<p class="mb-4">Where fashion meets sophistication in every click.</p>
                                <p><a href="#products" class="btn btn-secondary me-2">Shop Now</a><a href="#" class="btn btn-white-outline">Explore</a></p>
							</div>
						</div>
						<div class="col-lg-7">
							<div class="hero-img-wrap">
								<img src="images/couch.png" class="img-fluid">
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- End Hero Section -->


        <!-- Start Footer Section -->
        <footer class="footer-section">
            <div class="container relative">

                <div class="sofa-img">
                    <img src="images/sofa.png" alt="Image" class="img-fluid">
                </div>

                <div class="row g-5 mb-5">
                    <div class="col-lg-4">
                        <div class="mb-4 footer-logo-wrap"><a href="#" class="footer-logo">VogueVista<span>.</span></a></div>
                        <p class="mb-4">VogueVista embodies a fusion of 'Vogue', synonymous with trendsetting style, and 'Vista', representing a panoramic view.</p>

                        <ul class="list-unstyled custom-social">
                            <li><a href="#"><span class="fa fa-brands fa-facebook-f"></span></a></li>
                            <li><a href="#"><span class="fa fa-brands fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fa fa-brands fa-instagram"></span></a></li>
                            <li><a href="#"><span class="fa fa-brands fa-linkedin"></span></a></li>
                        </ul>
                    </div>

                    <div class="col-lg-8">
                        <div class="row links-wrap">
                            <div class="col-6 col-sm-6 col-md-3">
                                <ul class="list-unstyled">
                                    <li><a href="#">About us</a></li>
                                    <li><a href="#">Services</a></li>
                                    <li><a href="#">Blog</a></li>
                                    <li><a href="#">Contact us</a></li>
                                </ul>
                            </div>

                            <div class="col-6 col-sm-6 col-md-3">
                                <ul class="list-unstyled">
                                    <li><a href="#">Support</a></li>
                                    <li><a href="#">Knowledge base</a></li>
                                    <li><a href="#">Live chat</a></li>
                                </ul>
                            </div>

                            <div class="col-6 col-sm-6 col-md-3">
                                <ul class="list-unstyled">
                                    <li><a href="#">Jobs</a></li>
                                    <li><a href="#">Our team</a></li>
                                    <li><a href="#">Leadership</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                </ul>
                            </div>

                            <div class="col-6 col-sm-6 col-md-3">
                                <ul class="list-unstyled">
                                    <li><a href="#">Nordic Chair</a></li>
                                    <li><a href="#">Kruzo Aero</a></li>
                                    <li><a href="#">Ergonomic Chair</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="border-top copyright">
                    <div class="row pt-4">
                        <div class="col-lg-6">
                            <p class="mb-2 text-center text-lg-start">Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a>  Distributed By <a href="https://themewagon.com">ThemeWagon</a> <!-- License information: https://untree.co/license/ -->
            </p>
                        </div>

                        <div class="col-lg-6 text-center text-lg-end">
                            <ul class="list-unstyled d-inline-flex ms-auto">
                                <li class="me-4"><a href="#">Terms &amp; Conditions</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>
        </footer>
        <!-- End Footer Section --> 


        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/tiny-slider.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
    </body>

</html>

