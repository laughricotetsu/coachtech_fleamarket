<form
    action="{{ route('items.update', $item->id) }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ old('name', $item->name) }}">

    <input type="number" name="price" value="{{ old('price', $item->price) }}">

    {{-- 現在の画像 --}}
    @if ($item->image)
        <img
            src="{{ asset('storage/' . $item->image) }}"
            width="150"
            alt="現在の画像"
        >
    @endif

    {{-- 新しい画像 --}}
    <input type="file" name="image">

    <button type="submit">更新</button>
</form>
