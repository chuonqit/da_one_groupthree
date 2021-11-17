<?php layout('layouts.admin.master') ?>

<?php section('title', 'Cai dat web') ?>

<?php section('content') ?>
    <h1>Options</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="option_id" value="{{ $options['option_id'] ?? '' }}">
        @if(!empty($options['logo']))
        <img src="{{ asset('img/'.$options['logo']) }}" alt="" width="100px">
        @endif
        <p>
            <label for="logo">logo</label>
            <input type="file" name="logo" id="logo" accept="image/*"/>
        </p>
        <hr>
        @if(!empty($options['favicon']))
        <img src="{{ asset('img/'.$options['favicon']) }}" alt="" width="100px">
        @endif
        <p>
            <label for="logo">favicon</label>
            <input type="file" name="favicon" id="favicon" accept="image/*"/>
        </p>
        <p>
            <label for="app_name">app_name</label>
            <input type="text" name="app_name" id="app_name" value="{{ $options['app_name'] ?? old('app_name') }}"/>
        </p>
        <p>
            <label for="hotline_1">hotline_1</label>
            <input type="text" name="hotline_1" id="hotline_1" value="{{ $options['hotline_1'] ?? old('hotline_1') }}"/>
        </p>
        <p>
            <label for="hotline_2">hotline_2</label>
            <input type="text" name="hotline_2" id="hotline_2" value="{{ $options['hotline_2'] ?? old('hotline_2') }}"/>
        </p>
        <p>
            <label for="hotline_3">hotline_3</label>
            <input type="text" name="hotline_3" id="hotline_3" value="{{ $options['hotline_3'] ?? old('hotline_3') }}"/>
        </p>
        <p>
            <label for="address">address</label>
            <input type="text" name="address" id="address" value="{{ $options['address'] ?? old('address') }}"/>
        </p>
        <p>
            <label for="email">email</label>
            <input type="text" name="email" id="email" value="{{ $options['email'] ?? old('email') }}"/>
        </p>
        <p>
            <label for="license">license</label>
            <input type="text" name="license" id="license" value="{{ $options['license'] ?? old('license') }}"/>
        </p>
        <p>
            <label for="is_maintenance">is_maintenance</label>
            <label for="is_maintenance">
                <input type="hidden" name="is_maintenance" value="0"/>
                <input type="checkbox" name="is_maintenance" id="is_maintenance" value="1" {{ !empty($options['is_maintenance']) ? ($options['is_maintenance'] == 1 ? 'checked' : '') : old('license') }}/>
                is_maintenance
            </label>
        </p>
        <p>
            <button type="submit">Update</button>
        </p>
    </form>
<?php endsection() ?>