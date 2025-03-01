<x-layout>
    <x-slot:title>
        {{ $title }} - FoodFruit.uz
    </x-slot>
    <x-header>

    </x-header>
    <section>
        <div class="header-inner two">
            <div class="inner text-center">
                <h4 class="title text-white uppercase roboto-slab">FoodFruit</h4>
                <h5 class="text-white uppercase">Контакты</h5>
            </div>
            <div class="overlay bg-opacity-5"></div>
            <img src="images/contacts.jpg" alt="" class="img-responsive" />
        </div>
    </section>
    <!-- end header inner -->
    <div class="clearfix"></div>
    <section>
        <div class="pagenation-holder">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Контакты</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="pagenation_links"><a href="/">Главная</a><i> / </i> контакты</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end section-->
    <div class="clearfix"></div>
    <section class="sec-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-9">

                    <div class="smart-forms bmargin">
                        <h3 class=" roboto-slab">Связаться с нами</h3>
                        <p>Свяжитесь с нами для любых вопросов! Мы всегда готовы помочь с заказами, доставкой и
                            сотрудничеством. Заполните форму, и мы ответим вам в ближайшее время.</p>
                        <br/>
                        <br/>
                        <form method="post" action="php/smartprocess.php" id="smart-form">
                            <div>
                                <div class="section">
                                    <label class="field prepend-icon">
                                        <input type="text" name="sendername" id="sendername" class="gui-input"
                                               placeholder="Имя">
                                        <span class="field-icon"><i class="fa fa-user"></i></span> </label>
                                </div>
                                <!-- end section -->

                                <div class="section">
                                    <label class="field prepend-icon">
                                        <input type="email" name="emailaddress" id="emailaddress" class="gui-input"
                                               placeholder="Email">
                                        <span class="field-icon"><i class="fa fa-envelope"></i></span> </label>
                                </div>
                                <!-- end section -->

                                <div class="section colm colm6">
                                    <label class="field prepend-icon">
                                        <input type="tel" name="telephone" id="telephone" class="gui-input"
                                               placeholder="Телефон">
                                        <span class="field-icon"><i class="fa fa-phone-square"></i></span> </label>
                                </div>
                                <!-- end section -->

                                <div class="section">
                                    <label class="field prepend-icon">
                                        <input type="text" name="sendersubject" id="sendersubject" class="gui-input"
                                               placeholder="Тема">
                                        <span class="field-icon"><i class="fa fa-lightbulb-o"></i></span> </label>
                                </div>
                                <!-- end section -->

                                <div class="section">
                                    <label class="field prepend-icon">
                      <textarea class="gui-textarea" id="sendermessage" name="sendermessage"
                                placeholder="Сообщение"></textarea>
                                        <span class="field-icon"><i class="fa fa-comments"></i></span> <span
                                            class="input-hint">
                        <strong>Подсказка:</strong> Введите от 80 до 300 символов..</span> </label>
                                </div>
                                <!-- end section -->

                                <!--<div class="section">
                            <div class="smart-widget sm-left sml-120">
                                <label class="field">
                                    <input type="text" name="captcha" id="captcha" class="gui-input sfcode" maxlength="6" placeholder="Enter CAPTCHA">
                                </label>
                                <label class="button captcode">
                                    <img src="php/captcha/captcha.php?<?php echo time(); ?>" id="captchax" alt="captcha">
                                    <span class="refresh-captcha"><i class="fa fa-refresh"></i></span>
                                </label>
                            </div>
                        </div>-->

                                <div class="result"></div>
                                <!-- end .result  section -->

                            </div>
                            <!-- end .form-body section -->
                            <div class="form-footer">
                                <button type="submit" data-btntext-sending="Sending..."
                                        class="button btn-primary red-4">Отправить
                                </button>
                                <button type="reset" class="button"> Отмена</button>
                            </div>
                            <!-- end .form-footer section -->
                        </form>
                    </div>

                </div>
                <!--end left-->
            </div>
            <!--end right-->
        </div>
        </div>
    </section>
    <!-- end section -->
    <div class="clearfix"></div>

    <div class=" divider-line solid light opacity-6"></div>

    <div class="clearfix"></div>
    <x-footer>

    </x-footer>
    <!-- ============ JS FILES ============ -->

    <script type="text/javascript" src="js/universal/jquery.js"></script>
    <script src="js/bootstrap/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/mainmenu/jquery.sticky.js"></script>

    <script type="text/javascript" src="js/smart-forms/jquery.form.min.js"></script>
    <script type="text/javascript" src="js/smart-forms/jquery.validate.min.js"></script>
    <script type="text/javascript" src="js/smart-forms/additional-methods.min.js"></script>
    <script type="text/javascript" src="js/smart-forms/smart-form.js"></script>
    <script src="js/scripts/functions.js" type="text/javascript"></script>
</x-layout>


