<!DOCTYPE html>
<html>
<body>
<h1>部署編集</h1>

@if ($errors->any())
  <div style="background:#ffe6e6;padding:8px;">
    <ul>
      @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('departments.update', $department) }}">
  @csrf
  @method('PUT')
  <div>
    <label>部署名</label>
    <input type="text" name="name" value="{{ old('name', $department->name) }}">
  </div>
  <button type="submit">更新</button>
</form>

<p><a href="{{ route('departments.index') }}">戻る</a></p>
</body>
</html>