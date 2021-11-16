<?php layout('layouts.admin.master') ?>

<?php section('title', 'Update {{ $product["product_name"] }}') ?>

<?php section('content') ?>
    <a href="{{ url('admin/product') }}">Danh sach san pham</a>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" value="{{ $product['product_id'] }}" name="product_id">
        <img src="{{ asset('img/'.$product['product_image']) }}" alt="" width="100px">
        <p>
            <label for="product_image">product_image</label>
            <input type="file" name="product_image" id="product_image" accept="image/*"/>
            <span class="errors">{{ $errors['product_image'][0] ?? '' }}</span>
        </p>
        <p>
            <label for="product_name">product_name</label>
            <input type="text" name="product_name" id="product_name" value="{{ $product['product_name'] }}"/>
            <span class="errors">{{ $errors['product_name'][0] ?? '' }}</span>
        </p>
        <p>
            <label for="product_slug">product_slug</label>
            <input type="text" name="product_slug" id="product_slug" value="{{ $product['product_slug'] }}"/>
            <span class="errors">{{ $errors['product_slug'][0] ?? '' }}</span>
        </p>
        <p>
            <label for="product_description">product_description</label>
            <textarea name="product_description" id="product_description" cols="30" rows="10">{{ $product['product_description'] }}</textarea>
            <span class="errors">{{ $errors['product_description'][0] ?? '' }}</span>
        </p>
        <p>
            <label for="product_price">product_price</label>
            <input type="text" name="product_price" id="product_price" value="{{ $product['product_price'] }}"/>
            <span class="errors">{{ $errors['product_price'][0] ?? '' }}</span>
        </p>
        <p>
            <label for="product_discount">product_discount</label>
            <input type="text" name="product_discount" id="product_discount" value="{{ $product['product_discount'] }}"/>
            <span class="errors">{{ $errors['product_discount'][0] ?? '' }}</span>
        </p>
        <p>
            <label for="product_quantity">product_quantity</label>
            <input type="text" name="product_quantity" id="product_quantity" value="{{ $product['product_quantity'] }}"/>
            <span class="errors">{{ $errors['product_quantity'][0] ?? '' }}</span>
        </p>
        <p>
            <label for="category_id">category_id</label>
            <select name="category_id" id="category_id">
                <option></option>
                @foreach($categories as $item)
                <option value="{{ $item['category_id'] }}" {{ $item['category_id'] == $product['category_id'] ? 'selected' : '' }}>{{ $item['category_name'] }}</option>
                @endforeach
            </select>
            <span class="errors">{{ $errors['category_id'][0] ?? '' }}</span>
        </p>
        <p>
            <label for="brand_id">brand_id</label>
            <select name="brand_id" id="brand_id" value="{{ old('brand_id') }}">
                <option></option>
                @foreach($brands as $item)
                <option value="{{ $item['brand_id'] }}" {{ $item['brand_id'] == $product['brand_id'] ? 'selected' : '' }}>{{ $item['brand_name'] }}</option>
                @endforeach
            </select>
            <span class="errors">{{ $errors['brand_id'][0] ?? '' }}</span>
        </p>
        <p>
            <label>product_gifts</label>
            <select id="js_product_gifts" multiple>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
            <input type="hidden" name="product_gifts" id="js_product_gifts_value" value="{{ $product['product_gifts'] }}">
        </p>
        <p>
            <label for="product_hot">product_hot</label>
            <label for="product_hot">
                <input type="hidden" name="product_hot" value="0"/>
                <input type="checkbox" name="product_hot" id="product_hot" value="1" {{ $product['product_hot'] == 1 ? 'checked' : '' }}/>
                product_hot
            </label>
        </p>
        <p>
            <label for="is_variant">is_variant</label>
            <label for="is_variant">
                <input type="hidden" name="is_variant" value="0"/>
                <input type="checkbox" name="is_variant" id="is_variant" value="1" {{ $product['is_variant'] == 1 ? 'checked' : '' }}/>
                is_variant
            </label>
        </p>
        <p>
            <label for="product_status">product_status</label>
            <label for="product_status">
                <input type="hidden" name="product_status" value="0"/>
                <input type="checkbox" name="product_status" id="product_status" value="1" {{ $product['product_status'] == 1 ? 'checked' : '' }}/>
                product_status
            </label>
        </p>
        <p>
            <label for="product_content">product_content</label>
            <textarea name="product_content" id="product_content" cols="30" rows="10">{{ $product['product_content'] }}</textarea>
            <span class="errors">{{ $errors['product_content'][0] ?? '' }}</span>
        </p>
        <p>
            <button type="submit">Update</button>
        </p>
    </form>
<?php endsection() ?>

<?php section('scripts') ?>
    <script>
        var select_gifts = document.getElementById("js_product_gifts");
        select_gifts.addEventListener("change", function(e) {
            const options = e.target.options;
            const selectedValues = [];

            for (let i = 0; i < options.length; i++) {
                if (options[i].selected) {
                    selectedValues.push(options[i].value);
                }
            }
            document.getElementById("js_product_gifts_value").value = selectedValues;
        });
    </script>
<?php endsection() ?>