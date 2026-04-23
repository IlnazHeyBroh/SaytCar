<div>
    <label class="listing-form-label" for="title">Название автомобиля</label>
    <input id="title" name="title" class="listing-form-input" value="{{ old('title', $bb->title) }}" required>
</div>

<div>
    <label class="listing-form-label" for="brand">Марка</label>
    <select id="brand" name="brand" class="listing-form-input" required>
        <option value="">Выберите марку</option>
        @foreach ($brands as $brand)
            <option value="{{ $brand }}" {{ old('brand', $bb->brand) === $brand ? 'selected' : '' }}>
                {{ $brand }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label class="listing-form-label" for="price">Цена</label>
    <input id="price" type="number" min="0" name="price" class="listing-form-input" value="{{ old('price', $bb->price) }}" required>
</div>

<div>
    <label class="listing-form-label" for="user_id">Владелец</label>
    <select id="user_id" name="user_id" class="listing-form-input" required>
        <option value="">Выберите пользователя</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ (string) old('user_id', $bb->user_id) === (string) $user->id ? 'selected' : '' }}>
                {{ $user->name }} · {{ $user->email }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label class="listing-form-label" for="category_id">Категория</label>
    <select id="category_id" name="category_id" class="listing-form-input" required>
        <option value="">Выберите категорию</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ (string) old('category_id', $bb->category_id) === (string) $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label class="listing-form-label" for="status">Статус</label>
    <select id="status" name="status" class="listing-form-input">
        <option value="pending" {{ old('status', $bb->status ?: \App\Models\Bb::STATUS_APPROVED) === \App\Models\Bb::STATUS_PENDING ? 'selected' : '' }}>На рассмотрении</option>
        <option value="approved" {{ old('status', $bb->status ?: \App\Models\Bb::STATUS_APPROVED) === \App\Models\Bb::STATUS_APPROVED ? 'selected' : '' }}>Одобрено</option>
        <option value="rejected" {{ old('status', $bb->status ?: \App\Models\Bb::STATUS_APPROVED) === \App\Models\Bb::STATUS_REJECTED ? 'selected' : '' }}>Отклонено</option>
    </select>
</div>

<div class="admin-form-wide">
    <label class="listing-form-label" for="content">Описание</label>
    <textarea id="content" name="content" class="listing-form-input listing-form-textarea" rows="6" required>{{ old('content', $bb->content) }}</textarea>
</div>

<div class="admin-form-wide">
    <label class="listing-form-label" for="image">Фотография</label>
    <input id="image" type="file" name="image" class="listing-form-input listing-form-file" accept="image/png,image/jpeg,image/jpg,image/gif">
    @if ($bb->exists && $bb->image_url)
        <img src="{{ $bb->image_url }}" alt="{{ $bb->title }}" class="listing-form-preview-image mt-3">
    @endif
</div>

<div class="admin-form-wide admin-form-actions">
    <button type="submit" class="btn carhut-btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('admin.bbs.index') }}" class="btn btn-outline-light">Отмена</a>
</div>
