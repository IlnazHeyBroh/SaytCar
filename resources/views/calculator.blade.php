@extends('layouts.app')
@section('title', 'Калькулятор автокредита')
@section('content')

<section class="carhut-hero" style="min-height: 40vh; padding: 4rem 0;">
    <div class="carhut-hero-bg"></div>
    <div class="container carhut-hero-inner">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="carhut-hero-title mb-3">Калькулятор автокредита</h1>
                <p class="carhut-hero-subtitle">
                    Рассчитайте ежемесячный платеж и общую стоимость кредита на автомобиль
                </p>
            </div>
        </div>
    </div>
</section>

<section class="carhut-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row g-4">
                    <!-- Calculator Form -->
                    <div class="col-lg-6">
                        <div class="calculator-card">
                            <h2 class="h4 mb-4">Параметры кредита</h2>
                            
                            <form id="loanCalculator">
                                <div class="mb-4">
                                    <label class="form-label mb-2">Стоимость автомобиля (₽)</label>
                                    <input type="number" id="carPrice" class="calculator-input w-100" 
                                           value="2000000" min="100000" step="10000" required>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-soft">100 000 ₽</small>
                                        <small class="text-soft">10 000 000 ₽</small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label mb-2">Первоначальный взнос (₽)</label>
                                    <input type="number" id="downPayment" class="calculator-input w-100" 
                                           value="500000" min="0" step="10000" required>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-soft">0 ₽</small>
                                        <small class="text-soft" id="maxDownPayment">2 000 000 ₽</small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label mb-2">Срок кредита</label>
                                    <div class="custom-dropdown">
                                        <select id="loanTerm" class="calculator-input" required>
                                            <option value="12">12 месяцев</option>
                                            <option value="24">24 месяца</option>
                                            <option value="36" selected>36 месяцев</option>
                                            <option value="48">48 месяцев</option>
                                            <option value="60">60 месяцев</option>
                                            <option value="72">72 месяца</option>
                                            <option value="84">84 месяца</option>
                                        </select>
                                        <div class="custom-dropdown-select">36 месяцев</div>
                                        <div class="custom-dropdown-menu"></div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label mb-2">Процентная ставка (% годовых)</label>
                                    <input type="number" id="interestRate" class="calculator-input w-100" 
                                           value="12" min="5" max="30" step="0.1" required>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-soft">5%</small>
                                        <small class="text-soft">30%</small>
                                    </div>
                                </div>

                                <button type="button" onclick="calculateLoan()" class="btn carhut-btn-primary w-100 btn-lg">
                                    Рассчитать
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Results -->
                    <div class="col-lg-6">
                        <div class="calculator-card">
                            <h2 class="h4 mb-4">Результаты расчета</h2>
                            
                            <div id="results" style="display: none;">
                                <div class="mb-4 p-4 rounded-4" style="background: rgba(102, 126, 234, 0.1); border: 1px solid rgba(102, 126, 234, 0.3);">
                                    <div class="small text-soft mb-2">Ежемесячный платеж</div>
                                    <div class="h2 mb-0" id="monthlyPayment" style="background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">0 ₽</div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-6">
                                        <div class="p-3 rounded-3" style="background: rgba(21, 21, 32, 0.5);">
                                            <div class="small text-soft mb-1">Сумма кредита</div>
                                            <div class="h5 mb-0" id="loanAmount">0 ₽</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 rounded-3" style="background: rgba(21, 21, 32, 0.5);">
                                            <div class="small text-soft mb-1">Переплата</div>
                                            <div class="h5 mb-0" id="totalInterest">0 ₽</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 p-3 rounded-3" style="background: rgba(21, 21, 32, 0.5);">
                                    <div class="small text-soft mb-2">Общая сумма выплат</div>
                                    <div class="h4 mb-0" id="totalPayment">0 ₽</div>
                                </div>

                                <div class="alert alert-info" style="background: rgba(79, 172, 254, 0.1); border: 1px solid rgba(79, 172, 254, 0.3); color: #4facfe;">
                                    <small>
                                        <strong>Примечание:</strong> Расчет является приблизительным. 
                                        Финальные условия кредита определяются банком после рассмотрения заявки.
                                    </small>
                                </div>
                            </div>

                            <div id="noResults" class="text-center py-5">
                                <div class="mb-3" style="font-size: 4rem;">📊</div>
                                <p class="text-soft">Заполните форму и нажмите "Рассчитать"</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="row g-4 mt-4">
                    <div class="col-md-4">
                        <div class="card-premium text-center h-100">
                            <div class="carhut-feature-icon mx-auto mb-3" style="font-size: 2rem;">💳</div>
                            <h5 class="mb-3">Гибкие условия</h5>
                            <p class="text-soft small mb-0">
                                Выберите срок кредита от 1 до 7 лет с минимальной процентной ставкой
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-premium text-center h-100">
                            <div class="carhut-feature-icon mx-auto mb-3" style="font-size: 2rem;">✅</div>
                            <h5 class="mb-3">Быстрое одобрение</h5>
                            <p class="text-soft small mb-0">
                                Решение по заявке в течение 1 часа. Минимум документов для оформления
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-premium text-center h-100">
                            <div class="carhut-feature-icon mx-auto mb-3" style="font-size: 2rem;">🛡️</div>
                            <h5 class="mb-3">Безопасность</h5>
                            <p class="text-soft small mb-0">
                                Защита персональных данных и прозрачные условия кредитования
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CTA -->
                <div class="mt-5 text-center">
                    <div class="cta-section">
                        <h3 class="h4 mb-3 text-white">Готовы оформить кредит?</h3>
                        <p class="text-white-50 mb-4">Оставьте заявку, и наш менеджер свяжется с вами</p>
                        <a href="{{ route('contact') }}" class="btn btn-light btn-lg">Оставить заявку</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function calculateLoan() {
    const carPrice = parseFloat(document.getElementById('carPrice').value) || 0;
    const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
    const loanTerm = parseInt(document.getElementById('loanTerm').value) || 36;
    const interestRate = parseFloat(document.getElementById('interestRate').value) || 12;

    // Validate
    if (downPayment >= carPrice) {
        alert('Первоначальный взнос не может быть больше или равен стоимости автомобиля');
        return;
    }

    const loanAmount = carPrice - downPayment;
    const monthlyRate = interestRate / 100 / 12;
    const numberOfPayments = loanTerm;

    // Calculate monthly payment using annuity formula
    let monthlyPayment = 0;
    if (monthlyRate > 0) {
        monthlyPayment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, numberOfPayments)) / 
                        (Math.pow(1 + monthlyRate, numberOfPayments) - 1);
    } else {
        monthlyPayment = loanAmount / numberOfPayments;
    }

    const totalPayment = monthlyPayment * numberOfPayments;
    const totalInterest = totalPayment - loanAmount;

    // Update UI
    document.getElementById('monthlyPayment').textContent = formatCurrency(monthlyPayment);
    document.getElementById('loanAmount').textContent = formatCurrency(loanAmount);
    document.getElementById('totalInterest').textContent = formatCurrency(totalInterest);
    document.getElementById('totalPayment').textContent = formatCurrency(totalPayment);

    // Show results
    document.getElementById('results').style.display = 'block';
    document.getElementById('noResults').style.display = 'none';
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('ru-RU', {
        style: 'currency',
        currency: 'RUB',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
}

// Update max down payment when car price changes
document.getElementById('carPrice').addEventListener('input', function() {
    const maxDown = parseFloat(this.value) - 10000;
    document.getElementById('maxDownPayment').textContent = formatCurrency(maxDown);
});

// Auto-calculate on input change
document.getElementById('loanCalculator').addEventListener('input', function() {
    calculateLoan();
});
</script>

@endsection

