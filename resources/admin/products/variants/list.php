<?php layout('layouts.admin.master') ?>

<?php section('title', 'Variant list') ?>

<?php section('content') ?>
    <a href="{{ url('admin/product') }}">Danh sach san pham</a>
    <p>Variant list <a href="{{ url('admin/product/variant/create?product_id='.$product_id) }}">Them bien the moi</a></h1>
    <ul>
        @foreach($variants as $item)
        <li>
            {{ $item['product_variant_name'] }}
            [<a href="{{ url('admin/product/variant/update?product_id='.$item['product_id'].'&variant_id='.$item['product_variant_id']) }}">Sửa</a>]
            [<a href="{{ url('admin/product/variant/delete?product_id='.$item['product_id'].'&variant_id='.$item['product_variant_id']) }}">Xoá</a>]
        </li>
        @endforeach
    </ul>
<?php endsection() ?>