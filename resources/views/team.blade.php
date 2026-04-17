@extends('layouts.app')
@section('title', 'Наша команда')
@section('content')

<section class="carhut-hero" style="min-height: 40vh; padding: 4rem 0;">
    <div class="carhut-hero-bg"></div>
    <div class="container carhut-hero-inner">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="carhut-hero-title mb-3">Наша команда</h1>
                <p class="carhut-hero-subtitle">
                    Профессионалы, которые помогут вам найти идеальный автомобиль
                </p>
            </div>
        </div>
    </div>
</section>

<section class="carhut-section">
    <div class="container">
        <!-- Team Members -->
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="team-card">
                    <div class="team-avatar">👨‍💼</div>
                    <h4 class="h5 mb-2">Алексей Иванов</h4>
                    <p class="text-soft small mb-3">CEO & Основатель</p>
                    <p class="text-soft small mb-0">
                        Более 15 лет опыта в автомобильном бизнесе. Создал CarHut с целью 
                        сделать покупку и продажу авто простыми и безопасными.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="team-card">
                    <div class="team-avatar">👩‍💼</div>
                    <h4 class="h5 mb-2">Мария Петрова</h4>
                    <p class="text-soft small mb-3">Менеджер по продажам</p>
                    <p class="text-soft small mb-0">
                        Помогает клиентам найти идеальный автомобиль. Знает все о каждой модели 
                        и всегда готова дать профессиональный совет.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="team-card">
                    <div class="team-avatar">👨‍🔧</div>
                    <h4 class="h5 mb-2">Дмитрий Сидоров</h4>
                    <p class="text-soft small mb-3">Технический эксперт</p>
                    <p class="text-soft small mb-0">
                        Проводит техническую экспертизу автомобилей. Обеспечивает качество 
                        и безопасность каждой сделки.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="team-card">
                    <div class="team-avatar">👩‍💻</div>
                    <h4 class="h5 mb-2">Анна Козлова</h4>
                    <p class="text-soft small mb-3">UI/UX Дизайнер</p>
                    <p class="text-soft small mb-0">
                        Создает удобный и красивый интерфейс платформы. Делает процесс 
                        покупки автомобиля максимально комфортным.
                    </p>
                </div>
            </div>
        </div>

        <!-- Additional Team Members -->
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="team-card">
                    <div class="team-avatar">👨‍💼</div>
                    <h4 class="h5 mb-2">Сергей Волков</h4>
                    <p class="text-soft small mb-3">Финансовый консультант</p>
                    <p class="text-soft small mb-0">
                        Помогает выбрать оптимальную программу кредитования и рассчитать 
                        выгодные условия покупки.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="team-card">
                    <div class="team-avatar">👩‍💼</div>
                    <h4 class="h5 mb-2">Елена Смирнова</h4>
                    <p class="text-soft small mb-3">Менеджер по клиентскому сервису</p>
                    <p class="text-soft small mb-0">
                        Обеспечивает высокий уровень сервиса и решает любые вопросы клиентов. 
                        Всегда на связи и готова помочь.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="team-card">
                    <div class="team-avatar">👨‍💻</div>
                    <h4 class="h5 mb-2">Игорь Новиков</h4>
                    <p class="text-soft small mb-3">Разработчик</p>
                    <p class="text-soft small mb-0">
                        Разрабатывает и поддерживает платформу. Обеспечивает стабильную работу 
                        и постоянное улучшение сервиса.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="team-card">
                    <div class="team-avatar">👩‍🎨</div>
                    <h4 class="h5 mb-2">Ольга Морозова</h4>
                    <p class="text-soft small mb-3">Маркетинг-менеджер</p>
                    <p class="text-soft small mb-0">
                        Продвигает бренд и создает контент. Помогает клиентам узнать о новых 
                        возможностях и предложениях.
                    </p>
                </div>
            </div>
        </div>

        <!-- Why Our Team -->
        <section class="carhut-section carhut-section-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="carhut-section-title mb-3" style="color: #1a1a2e;">Почему наша команда</h2>
                    <p class="text-muted">Профессионализм, опыт и преданность делу</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card-premium text-center h-100" style="background: white;">
                            <div class="carhut-feature-icon mx-auto mb-3" style="font-size: 2rem;">🎓</div>
                            <h5 class="mb-3" style="color: #1a1a2e;">Опыт</h5>
                            <p class="text-muted small mb-0">
                                Средний стаж работы в автомобильной индустрии — более 10 лет. 
                                Мы знаем все тонкости рынка.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-premium text-center h-100" style="background: white;">
                            <div class="carhut-feature-icon mx-auto mb-3" style="font-size: 2rem;">🤝</div>
                            <h5 class="mb-3" style="color: #1a1a2e;">Подход</h5>
                            <p class="text-muted small mb-0">
                                Индивидуальный подход к каждому клиенту. Мы понимаем, что 
                                каждый случай уникален.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-premium text-center h-100" style="background: white;">
                            <div class="carhut-feature-icon mx-auto mb-3" style="font-size: 2rem;">💯</div>
                            <h5 class="mb-3" style="color: #1a1a2e;">Результат</h5>
                            <p class="text-muted small mb-0">
                                99% довольных клиентов. Мы гордимся каждым успешным результатом 
                                и стремимся к совершенству.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Join Our Team -->
        <section class="carhut-section">
            <div class="container">
                <div class="cta-section">
                    <h2 class="h3 mb-3 text-white">Присоединяйтесь к команде</h2>
                    <p class="text-white-50 mb-4">
                        Мы всегда ищем талантливых и мотивированных профессионалов. 
                        Если вы разделяете наши ценности — давайте работать вместе!
                    </p>
                    <a href="{{ route('contact') }}" class="btn btn-light btn-lg">Связаться с нами</a>
                </div>
            </div>
        </section>
    </div>
</section>

@endsection

