<form
    action="{{ route('items.store') }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf

    <input type="text" name="name" placeholder="商品名">

    <input type="number" name="price" placeholder="価格">

    <input type="file" name="image">

    <button type="submit">登録</button>
</form>
