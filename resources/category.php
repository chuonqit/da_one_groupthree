<?php layout('layouts.client.master') ?>
<?php section('title', '{{ $cate_title }}') ?>
<?php section('content') ?>
    <h1>{{ $cate_title }}</h1>
    @if (!empty($products))
        @foreach($products as $item)
            <li>
                <a href="{{ url($item['cate_parent_slug'].'/'.$item['product_full_slug']) }}">
                    {{ $item['product_full_name'] }}
                    @if($item['is_variant'] == 1) - [{{ $item['ram'].'-'.$item['storage'] }}] @endif 
                    - {{ priceVND($item['product_price']) }} 
                </a>
            </li>
        @endforeach
    @else
        <strong>Khong co san pham</strong>
    @endif
<?php endsection() ?>