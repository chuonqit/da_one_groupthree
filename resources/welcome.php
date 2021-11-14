<?php layout('layouts.client.master') ?>
<?php section('title', 'Trang chu') ?>
<?php section('content') ?>
    @if(!empty(session_get('message')))
        <p><strong>{{ session_get('message') }}</strong></p>
    @endif
    {! session_remove('message') !}
    
    <ul>
    @foreach($products as $item)
        <li>
            <a href="{{ url($item['cate_parent_slug'].'/'.$item['product_full_slug']) }}">
                {{ $item['product_full_name'] }} 
                @if($item['is_variant'] == 1) - [{{ $item['ram'].'-'.$item['storage'] }}] @endif 
                - {{ priceVND($item['product_price']) }} 
            </a>
        </li>
    @endforeach
    </ul>
<?php endsection() ?>


