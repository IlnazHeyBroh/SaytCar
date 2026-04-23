<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CarHut') · Car Marketplace</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/styles/main.css" rel="stylesheet" type="text/css">
</head>
<body class="carhut-body">
    <header class="carhut-header shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-dark carhut-navbar">
            <div class="container">
                <a class="navbar-brand fw-semibold d-flex align-items-center" href="{{ route('index') }}">
                    <span class="carhut-logo-icon me-2"></span>
                    CarHut
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav carhut-nav-links me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('index') }}">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('catalog') }}">Каталог</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blog') }}">Блог</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('brands') }}">Бренды</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">О нас</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Контакты</a>
                        </li>
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Мои объявления</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('favorites.index') }}">Избранное</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('messages.index') }}">Сообщения</a>
                            </li>
                            @if (Auth::user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Админка</a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <div class="carhut-nav-actions d-flex align-items-center gap-2">
                        <a href="{{ route('sell') }}" class="btn carhut-btn-secondary btn-sm d-none d-md-inline-flex">Продать авто</a>
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Вход</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn carhut-btn-primary btn-sm">Регистрация</a>
                            @endif
                        @else
                            <span class="carhut-user-label text-white-50 small me-2 d-none d-md-inline">
                                {{ Auth::user()->name ?? 'Профиль' }}
                            </span>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm">Выход</button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="carhut-main">
        @yield('content')
    </main>

    <footer class="carhut-footer text-white">
        <div class="container py-4 py-md-5">
            <div class="row gy-3">
                <div class="col-md-4">
                    <h5 class="fw-semibold mb-3">CarHut</h5>
                    <p class="small mb-0">Площадка для продажи и покупки автомобилей. Онлайн, в салоне и с любого устройства.</p>
                </div>
                <div class="col-6 col-md-3">
                    <h6 class="fw-semibold mb-3 small text-uppercase">Навигация</h6>
                    <ul class="list-unstyled small mb-0">
                        <li><a href="{{ route('index') }}">Главная</a></li>
                        <li><a href="{{ route('catalog') }}">Каталог</a></li>
                        <li><a href="{{ route('about') }}">О нас</a></li>
                        <li><a href="{{ route('contact') }}">Контакты</a></li>
                        @auth
                            <li><a href="{{ route('home') }}">Мои объявления</a></li>
                            <li><a href="{{ route('favorites.index') }}">Избранное</a></li>
                            <li><a href="{{ route('messages.index') }}">Сообщения</a></li>
                            @if (Auth::user()->isAdmin())
                                <li><a href="{{ route('admin.dashboard') }}">Админка</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h6 class="fw-semibold mb-3 small text-uppercase">Контакты</h6>
                    <ul class="list-unstyled small mb-0">
                        <li><a href="tel:+74951234567">+7 (495) 123-45-67</a></li>
                        <li><a href="mailto:info@carhut.ru">info@carhut.ru</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3">
                    <h6 class="fw-semibold mb-3 small text-uppercase">Дополнительно</h6>
                    <ul class="list-unstyled small mb-0">
                        <li><a href="{{ route('blog') }}">Блог</a></li>
                        <li><a href="{{ route('brands') }}">Бренды</a></li>
                        <li><a href="{{ route('team') }}">Команда</a></li>
                        <li><a href="{{ route('calculator') }}">Калькулятор</a></li>
                        <li><a href="{{ route('sell') }}">Продать авто</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary mt-4 pt-3 d-flex justify-content-between small text-white-50 flex-column flex-md-row gap-2">
                <span>© {{ date('Y') }} CarHut. Все права защищены.</span>
                <span>Laravel v{{ Illuminate\Foundation\Application::VERSION }}</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <button class="scroll-to-top" id="scrollToTop" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        ↑
    </button>

    <script>
        const scrollToTopBtn = document.getElementById('scrollToTop');

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.add('visible');
            } else {
                scrollToTopBtn.classList.remove('visible');
            }
        });

        const header = document.querySelector('.carhut-header');
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        (function() {
            'use strict';

            let initializedDropdowns = new WeakSet();

            function initCustomDropdowns() {
                const dropdowns = document.querySelectorAll('.custom-dropdown');

                dropdowns.forEach(function(dropdown) {
                    if (initializedDropdowns.has(dropdown)) {
                        return;
                    }

                    const select = dropdown.querySelector('select');
                    const customSelect = dropdown.querySelector('.custom-dropdown-select');
                    const menu = dropdown.querySelector('.custom-dropdown-menu');

                    if (!select || !customSelect || !menu) {
                        return;
                    }

                    initializedDropdowns.add(dropdown);
                    menu.innerHTML = '';

                    const selectedOption = select.options[select.selectedIndex];
                    if (selectedOption) {
                        const currentText = customSelect.textContent.trim();
                        if (!currentText || currentText === 'Выберите' || currentText === 'Выберите марку' || currentText === 'Выберите тему') {
                            customSelect.textContent = selectedOption.text;
                        }
                    }

                    for (let i = 0; i < select.options.length; i++) {
                        const option = select.options[i];
                        const item = document.createElement('button');
                        item.type = 'button';
                        item.className = 'custom-dropdown-item';
                        item.textContent = option.text;
                        item.dataset.index = i;

                        if (option.selected) {
                            item.classList.add('selected');
                        }

                        item.addEventListener('click', function(event) {
                            event.preventDefault();
                            event.stopPropagation();

                            select.selectedIndex = i;
                            if (option.value) {
                                select.value = option.value;
                            }

                            customSelect.textContent = option.text;
                            customSelect.classList.remove('active');
                            menu.classList.remove('show');

                            const allItems = menu.querySelectorAll('.custom-dropdown-item');
                            for (let j = 0; j < allItems.length; j++) {
                                allItems[j].classList.remove('selected');
                            }
                            item.classList.add('selected');

                            try {
                                const changeEvent = new Event('change', { bubbles: true });
                                select.dispatchEvent(changeEvent);
                            } catch (e) {
                                if (document.createEvent) {
                                    const evt = document.createEvent('HTMLEvents');
                                    evt.initEvent('change', true, true);
                                    select.dispatchEvent(evt);
                                }
                            }
                        });

                        menu.appendChild(item);
                    }

                    function handleSelectClick(event) {
                        event.preventDefault();
                        event.stopPropagation();

                        const isActive = customSelect.classList.contains('active');
                        const allActive = document.querySelectorAll('.custom-dropdown-select.active');

                        for (let k = 0; k < allActive.length; k++) {
                            if (allActive[k] !== customSelect) {
                                allActive[k].classList.remove('active');
                                const otherDropdown = allActive[k].closest('.custom-dropdown');
                                if (otherDropdown) {
                                    const otherMenu = otherDropdown.querySelector('.custom-dropdown-menu');
                                    if (otherMenu) {
                                        otherMenu.classList.remove('show');
                                    }
                                }
                            }
                        }

                        if (isActive) {
                            customSelect.classList.remove('active');
                            menu.classList.remove('show');
                        } else {
                            customSelect.classList.add('active');
                            menu.classList.add('show');
                        }
                    }

                    customSelect.addEventListener('click', handleSelectClick);
                    customSelect.addEventListener('mousedown', function(e) {
                        e.preventDefault();
                    });

                    select.addEventListener('change', function() {
                        const opt = select.options[select.selectedIndex];
                        if (opt) {
                            customSelect.textContent = opt.text;
                            const allItems = menu.querySelectorAll('.custom-dropdown-item');
                            for (let m = 0; m < allItems.length; m++) {
                                if (m === select.selectedIndex) {
                                    allItems[m].classList.add('selected');
                                } else {
                                    allItems[m].classList.remove('selected');
                                }
                            }
                        }
                    });
                });
            }

            function closeAllDropdowns() {
                const allActive = document.querySelectorAll('.custom-dropdown-select.active');
                for (let i = 0; i < allActive.length; i++) {
                    allActive[i].classList.remove('active');
                    const dropdown = allActive[i].closest('.custom-dropdown');
                    if (dropdown) {
                        const menu = dropdown.querySelector('.custom-dropdown-menu');
                        if (menu) {
                            menu.classList.remove('show');
                        }
                    }
                }
            }

            document.addEventListener('click', function(e) {
                if (!e.target.closest('.custom-dropdown')) {
                    closeAllDropdowns();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' || e.keyCode === 27) {
                    closeAllDropdowns();
                }
            });

            window.addEventListener('resize', function() {
                closeAllDropdowns();
            });

            function init() {
                initCustomDropdowns();
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(init, 50);
                });
            } else {
                setTimeout(init, 50);
            }

            setTimeout(init, 200);
            setTimeout(init, 1000);
            window.reinitDropdowns = init;
        })();

        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('catalog-filter-form');
            if (filterForm) {
                const selects = filterForm.querySelectorAll('select');
                selects.forEach(select => {
                    select.addEventListener('change', function() {
                        filterForm.submit();
                    });
                });
            }

            document.querySelectorAll('.custom-dropdown select').forEach(select => {
                select.addEventListener('change', function() {
                    const customSelect = this.closest('.custom-dropdown').querySelector('.custom-dropdown-select');
                    if (customSelect) {
                        const selectedOption = this.options[this.selectedIndex];
                        customSelect.textContent = selectedOption.text;
                    }
                });
            });
        });
    </script>
</body>
</html>
