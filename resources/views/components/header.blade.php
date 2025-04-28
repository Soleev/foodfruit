<div class="site_wrapper">
    <div class="topbar dark topbar-padding">
        <div class="container">
            <div class="topbar-left-items">
                <ul class="toplist toppadding pull-left paddtop1">
                    <li class="rightl">Отдел продаж</li>
                    <li>+998 500 200 745</li>

                </ul>
            </div>
            <!--end left-->
            <div class="topbar-right-items pull-right">
                <ul class="toplist toppadding">
                    <li><a href="#"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;</a></li>
                    <li><a href="https://facebook.com/"><i class="fa-brands fa-facebook"></i></a></li>
                    <li><a href="https://instagram.com/"><i class="fa-brands fa-instagram"></i></a></li>
                    <li class="last"><a href="#"><i class="fa-brands fa-telegram"></i></a></li>

                </ul>
            </div>
        </div>
    </div>
    <div class="topbar white">
        <div class="container">
            <div class="topbar-left-items">
                <div class="margin-top1"></div>
                <ul class="toplist toppadding pull-left paddtop1">
                    @if (Route::has('login'))
                        <nav class="flex items-center justify-end gap-4">
                            @auth
                                <li class="lineright">
                                    <a
                                        href="{{ url('/cabinet') }}"
                                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                                    >
                                        Кабинет

                                    </a>
                                </li>
                            @else
                                <li class="lineright">
                                    <a
                                        href="{{ route('login') }}"
                                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                                    >
                                        Логин
                                    </a>
                                </li>
                                @if (Route::has('register'))
                                    <li>
                                        <a
                                            href="{{ route('register') }}"
                                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                            Регистрация
                                        </a>
                                    </li>
                                @endif
                            @endauth
                        </nav>
                    @endif

                </ul>
            </div>
            <!--end left-->

            <div class="topbar-middle-logo no-bgcolor"><a href="/"><img src="images/logo.jpg" alt=""/></a></div>
            <!--end middle-->

            <div class="topbar-right-items pull-right">
                <div class="margin-top1"></div>
                <ul class="toplist toppadding">

                    <li class="lineright"><a href="#">Доставка</a></li>
                    <li class="last"><a href="#">Корзина</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div id="header">
        <div class="container">
            <div class="navbar red-2 navbar-default yamm">
                <div class="navbar-header">
                    <button type="button" data-toggle="collapse" data-target="#navbar-collapse-grid"
                            class="navbar-toggle two three"><span class="icon-bar"></span><span class="icon-bar"></span><span
                            class="icon-bar"></span></button>
                </div>
                <div id="navbar-collapse-grid" class="navbar-collapse collapse">
                    <ul class="nav red-2 navbar-nav">
                        <li><a href="/" class="dropdown-toggle active">Главная</a></li>

                        <li><a href="about" class="dropdown-toggle">О нас</a></li>

                        <li class="dropdown yamm-fw"><a href="catalog" class="dropdown-toggle">Каталог</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <!-- Content container to add padding -->
                                    <div class="yamm-content">
                                        <div class="row">
                                            <ul class="col-sm-6 col-md-3 list-unstyled ">
                                                <li>
                                                    <p> Продукты </p>
                                                </li>
                                                {{--<li><a href="shop-women.html"><i class="fa fa-angle-right"></i> &nbsp; Dresses</a></li>
                                                <li><a href="shop-women.html"><i class="fa fa-angle-right"></i> &nbsp; Shirts And Tops</a>
                                                </li>
                                                <li><a href="shop-women.html"><i class="fa fa-angle-right"></i> &nbsp; Jeans</a></li>
                                                <li><a href="shop-women.html"><i class="fa fa-angle-right"></i> &nbsp; T-Shirts</a></li>
                                                <li><a href="shop-women.html"><i class="fa fa-angle-right"></i> &nbsp; Premium Wear</a></li>--}}
                                            </ul>
                                            <ul class="col-sm-6 col-md-3 list-unstyled ">
                                                <li>
                                                    <p> Фрукты </p>
                                                </li>
                                                {{--<li><a href="shop-women.html"><i class="fa fa-angle-right"></i> &nbsp; Flats</a></li>
                                                <li><a href="shop-women.html"><i class="fa fa-angle-right"></i> &nbsp; Heels</a></li>
                                                <li><a href="shop-women.html"><i class="fa fa-angle-right"></i> &nbsp; Boots</a></li>
                                                <li><a href="shop-women.html"><i class="fa fa-angle-right"></i> &nbsp; Casual Shoes</a></li>
                                                <li><a href="shop-women.html"><i class="fa fa-angle-right"></i> &nbsp; Sports Shoes</a></li>--}}
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>


                        <li><a href="contacts" class="dropdown-toggle">Контакты</a></li>
                    </ul>
                    <br/>
                    <a href="Sales-and-deals" class="dropdown-toggle pull-right btn btn-red btn-xround">Акции</a>
                </div>
            </div>
        </div>
    </div>
    <!--end menu-->
    <div class="clearfix"></div>
