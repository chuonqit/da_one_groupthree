<?php layout('layouts.admin.master') ?>

<?php section('title', 'Update cau hinh may') ?>

<?php section('content') ?>
    <a href="{{ url('admin/product') }}">Danh sach san pham</a>
    <form action="" method="post">
        <input type="hidden" value="{{ $product_id }}">
        <p>
            <label for="display">display</label>
            <input type="text" name="display" id="display" value="{{ $config['display'] ?? old('display') }}"/>
        </p>
        <p>
            <label for="camera_front">camera_front</label>
            <input type="text" name="camera_front" id="camera_front" value="{{ $config['camera_front'] ?? old('camera_front') }}"/>
        </p>
        <p>
            <label for="camera_back">camera_back</label>
            <input type="text" name="camera_back" id="camera_back" value="{{ $config['camera_back'] ?? old('camera_back') }}"/>
        </p>
        <p>
            <label for="ram">ram</label>
            <input type="text" name="ram" id="ram" value="{{ $config['ram'] ?? old('ram') }}"/>
        </p>
        <p>
            <label for="storage">storage</label>
            <input type="text" name="storage" id="storage" value="{{ $config['storage'] ?? old('storage') }}"/>
        </p>
        <p>
            <label for="cpu">cpu</label>
            <input type="text" name="cpu" id="cpu" value="{{ $config['cpu'] ?? old('cpu') }}"/>
        </p>
        <p>
            <label for="gpu">gpu</label>
            <input type="text" name="gpu" id="gpu" value="{{ $config['gpu'] ?? old('gpu') }}"/>
        </p>
        <p>
            <label for="battery">battery</label>
            <input type="text" name="battery" id="battery" value="{{ $config['battery'] ?? old('battery') }}"/>
        </p>
        <p>
            <label for="sim">sim</label>
            <input type="text" name="sim" id="sim" value="{{ $config['sim'] ?? old('sim') }}"/>
        </p>
        <p>
            <label for="system">system</label>
            <input type="text" name="system" id="system" value="{{ $config['system'] ?? old('system') }}"/>
        </p>
        <p>
            <label for="made_in">made_in</label>
            <input type="text" name="made_in" id="made_in" value="{{ $config['made_in'] ?? old('made_in') }}"/>
        </p>
        <p>
            <button type="submit">Update</button>
        </p>
    </form>
<?php endsection() ?>