<?php layout('layouts.admin.master') ?>

<?php section('title', 'Them bien the san pham moi') ?>

<?php section('content') ?>
    <a href="{{ url('admin/product') }}">Danh sach san pham</a>
    <p>Variant list <a href="{{ url('admin/product/variant?product_id='.$product_id) }}">Danh sach bien the</a></h1>
    
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="{{ $product_id }}">
        <p>
            <label for="product_variant_image">product_variant_image</label>
            <input type="file" name="product_variant_image" id="product_variant_image" accept="image/*"/>
            <span class="errors">{{ $errors['product_variant_image'][0] ?? '' }}</span>
        </p>
        <p>
            <label for="product_variant_name">product_variant_name</label>
            <input type="text" name="product_variant_name" id="product_variant_name" value="{{ old('product_variant_name') }}"/>
            <span class="errors">{{ $errors['product_variant_name'][0] ?? '' }}</span>
        </p>
        <p>
            <label for="product_variant_slug">product_variant_slug</label>
            <input type="text" name="product_variant_slug" id="product_variant_slug" value="{{ old('product_variant_slug') }}"/>
            <span class="errors">{{ $errors['product_variant_slug'][0] ?? '' }}</span>
        </p>
        <p>
            <label for="product_variant_price">product_variant_price</label>
            <input type="text" name="product_variant_price" id="product_variant_price" value="{{ old('product_variant_price') }}"/>
            <span class="errors">{{ $errors['product_variant_price'][0] ?? '' }}</span>
        </p>
        <p>
            <label for="product_variant_discount">product_variant_discount</label>
            <input type="text" name="product_variant_discount" id="product_variant_price" value="{{ old('product_variant_discount') }}"/>
            <span class="errors">{{ $errors['product_variant_discount'][0] ?? '' }}</span>
        </p>
        <p>
            <button type="submit">Update</button>
        </p>
    </form>
<?php endsection() ?>