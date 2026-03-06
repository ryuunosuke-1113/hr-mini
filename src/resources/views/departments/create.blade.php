<!DOCTYPE html>
<html>
<body>
<h1>部署追加</h1>

@if ($errors->any())
  <div style="background:#ffe6e6;padding:8px;">
    <ul>
      @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('departments.store') }}">
  @csrf
  <div>
    <label>部署名</label>
    <input type="text" name="name" value="{{ old('name') }}">
  </div>
  <button type="submit">作成</button>
</form>

<p><a href="{{ route('departments.index') }}">戻る</a></p>
</body>
</html>