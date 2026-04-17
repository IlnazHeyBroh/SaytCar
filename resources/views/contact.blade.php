@extends('layouts.app')
@section('title', 'Контакты')
@section('content')

<section class="carhut-hero" style="min-height: 40vh; padding: 4rem 0;">
    <div class="carhut-hero-bg"></div>
    <div class="container carhut-hero-inner">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="carhut-hero-title mb-3">Свяжитесь с нами</h1>
                <p class="carhut-hero-subtitle">
                    Есть вопросы? Мы всегда рады помочь! Свяжитесь с нами любым удобным способом.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="carhut-section">
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card-premium text-center h-100">
                    <div class="carhut-feature-icon mx-auto mb-3" style="font-size: 2rem;">📧</div>
                    <h5 class="mb-3">Email</h5>
                    <p class="text-soft mb-2">
                        <a href="mailto:info@carhut.ru" class="text-decoration-none">info@carhut.ru</a><br>
                        <a href="mailto:support@carhut.ru" class="text-decoration-none">support@carhut.ru</a>
                    </p>
                    <p class="text-soft small mb-0">Ответим в течение 24 часов</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-premium text-center h-100">
                    <div class="carhut-feature-icon mx-auto mb-3" style="font-size: 2rem;">📞</div>
                    <h5 class="mb-3">Телефон</h5>
                    <p class="text-soft mb-2">
                        <a href="tel:+74951234567" class="text-decoration-none">+7 (495) 123-45-67</a><br>
                        <a href="tel:+78001234567" class="text-decoration-none">8 (800) 123-45-67</a>
                    </p>
                    <p class="text-soft small mb-0">Пн-Пт: 9:00 - 20:00, Сб-Вс: 10:00 - 18:00</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-premium text-center h-100">
                    <div class="carhut-feature-icon mx-auto mb-3" style="font-size: 2rem;">📍</div>
                    <h5 class="mb-3">Адрес</h5>
                    <p class="text-soft mb-2">
                        г. Москва<br>
                        ул. Примерная, д. 1<br>
                        БЦ "Автомобильный", офис 501
                    </p>
                    <p class="text-soft small mb-0">Прием по предварительной записи</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="calculator-card">
                    <h2 class="h3 mb-4 text-center">Отправить сообщение</h2>
                    <p class="text-center text-soft mb-4">Заполните форму, и мы свяжемся с вами в ближайшее время</p>
                    
                    <form>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="contactName" class="form-label">Ваше имя *</label>
                                <input type="text" class="form-control" id="contactName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="contactEmail" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="contactEmail" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contactPhone" class="form-label">Телефон</label>
                            <input type="tel" class="form-control" id="contactPhone" placeholder="+7 (999) 123-45-67">
                        </div>
                        <div class="mb-3">
                            <label for="contactSubject" class="form-label">Тема *</label>
                            <div class="custom-dropdown">
                                <select id="contactSubject" required>
                                    <option value="">Выберите тему</option>
                                    <option>Вопрос о покупке</option>
                                    <option>Вопрос о продаже</option>
                                    <option>Техническая поддержка</option>
                                    <option>Партнерство</option>
                                    <option>Другое</option>
                                </select>
                                <div class="custom-dropdown-select">Выберите тему</div>
                                <div class="custom-dropdown-menu"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="contactMessage" class="form-label">Сообщение *</label>
                            <textarea class="form-control" id="contactMessage" rows="5" required 
                                      placeholder="Опишите ваш вопрос или проблему..."></textarea>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="contactAgree" required>
                            <label class="form-check-label text-soft small" for="contactAgree">
                                Я согласен с <a href="#" class="text-decoration-underline">политикой конфиденциальности</a> 
                                и обработкой персональных данных
                            </label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn carhut-btn-primary btn-lg">
                                Отправить сообщение
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="carhut-section-title text-center mb-4">Часто задаваемые вопросы</h2>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item" style="background: rgba(21, 21, 32, 0.8); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Как быстро я получу ответ?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-soft">
                                Мы стараемся отвечать на все запросы в течение 24 часов в рабочие дни. 
                                Для срочных вопросов рекомендуем позвонить по телефону.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item" style="background: rgba(21, 21, 32, 0.8); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Можно ли приехать в офис без записи?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-soft">
                                Мы рекомендуем предварительно записаться, чтобы гарантировать, что специалист 
                                будет доступен. Однако мы всегда стараемся помочь посетителям, если есть возможность.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item" style="background: rgba(21, 21, 32, 0.8); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Есть ли у вас мобильное приложение?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-soft">
                                Да, мы работаем над мобильным приложением. Пока вы можете использовать наш сайт, 
                                который полностью адаптирован для мобильных устройств.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="carhut-section carhut-section-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="carhut-section-title text-center mb-4" style="color: #1a1a2e;">Как нас найти</h2>
                <div class="card-premium" style="background: white; min-height: 400px; display: flex; align-items: center; justify-content: center;">
                    <div class="text-center">
                        <div class="mb-3" style="font-size: 4rem;">🗺️</div>
                        <p class="text-muted mb-0">Интерактивная карта будет здесь</p>
                        <p class="text-muted small">г. Москва, ул. Примерная, д. 1</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
