<footer class="footer">
    <div class="footer-middle">
        <div class="container">
            <div class="footer-ribbon">
                Get in touch
            </div>
            <!-- End .footer-ribbon -->
            <div class="row">
                <div class="col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">Contact Us</h4>
                        <ul class="contact-info">
                            <li>
                                <span class="contact-info-label">Address:</span>Royal Avenue, Islamabad, Pakistan
                            </li>
                            <li>
                                <span class="contact-info-label">Phone:</span>Toll Free <a href="tel:">(123)
                                    456-7890</a>
                            </li>
                            <li>
                                <span class="contact-info-label">Email:</span> <a href="mailto:mail@example.com">mail@gharpey.com</a>
                            </li>
                            <li>
                                <span class="contact-info-label">Working Days/Hours:</span> Mon - Sun / 9:00AM - 8:00PM
                            </li>
                        </ul>
                        <div class="social-icons">
                            <a href="#" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
                            <a href="#" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
                            <a href="#" class="social-icon" target="_blank"><i class="icon-linkedin"></i></a>
                        </div>
                        <!-- End .social-icons -->
                    </div>
                    <!-- End .widget -->
                </div>
                <!-- End .col-lg-3 -->

                <div class="col-lg-9">
                    <div class="widget widget-newsletter">
                        <h4 class="widget-title">Subscribe newsletter</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Get all the latest information on Events,Sales and Offers. Sign up for newsletter
                                    today</p>
                            </div>
                            <!-- End .col-md-6 -->

                            <div class="col-md-6">
                                <form action="#">
                                    <input type="email" class="form-control" placeholder="Email address" required>

                                    <input type="submit" class="btn" value="Subscribe">
                                </form>
                            </div>
                            <!-- End .col-md-6 -->
                        </div>
                        <!-- End .row -->
                    </div>
                    <!-- End .widget -->

                    <div class="row">
                        @auth('buyer')
                            <div class="col-md-5">
                                <div class="widget">
                                    <h4 class="widget-title">My Account</h4>

                                    <div class="row">
                                        <div class="col-sm-6 col-md-5">
                                            <ul class="links">
                                                <li><a href="about.html">About Us</a></li>
                                                <li><a href="contact.html">Contact Us</a></li>
                                                <li><a href="{{route('buyer.login')}}">Login</a></li>
                                            </ul>
                                        </div>
                                        <!-- End .col-sm-6 -->
                                        <div class="col-sm-6 col-md-5">
                                            <ul class="links">
                                                <li><a href="{{route('buyer.account.index')}}">My Account</a></li>
                                                <li><a href="{{route('buyer.account.orders.index')}}">Orders History</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- End .col-sm-6 -->
                                    </div>
                                    <!-- End .row -->
                                </div>
                                <!-- End .widget -->
                            </div>
                    @endauth
                    <!-- End .col-md-5 -->

                        <div class="col-md-7">
                            <div class="widget">
                                <h4 class="widget-title">Main Features</h4>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <ul class="links">
                                            <li><a href="#">Pakistan Top Selling Sites for Women Sellers</a></li>
                                            <li><a href="#">Unique Services</a></li>
                                            <li><a href="#">Unique Products</a></li>
                                        </ul>
                                    </div>
                                    <!-- End .col-sm-6 -->
                                    <div class="col-sm-6">
                                        <ul class="links">
                                            <li><a href="#">Cash On Delivery</a></li>
                                            <li><a href="#">24x7 Support</a></li>
                                        </ul>
                                    </div>
                                    <!-- End .col-sm-6 -->
                                </div>
                                <!-- End .row -->
                            </div>
                            <!-- End .widget -->
                        </div>
                        <!-- End .col-md-7 -->
                    </div>
                    <!-- End .row -->
                </div>
                <!-- End .col-lg-9 -->
            </div>
            <!-- End .row -->
        </div>
        <!-- End .container -->
    </div>
    <!-- End .footer-middle -->


    <!-- End .container -->
</footer>
