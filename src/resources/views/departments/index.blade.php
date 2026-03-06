<!DOCTYPE html>
<html>
<body>
<h1>部署一覧</h1>

@if(session('success')) <div style="background:#e6ffed;padding:8px;">{{ session('success') }}</div> @endif
@if(session('error')) <div style="background:#ffe6e6;padding:8px;">{{ session('error') }}</div> @endif

@can('create', \App\Models\Department::class)
  <p><a href="{{ route('departments.create') }}">＋ 部署追加</a></p>
@endcan
<table border="1" cellpadding="6">
  <tr>
    <th>部署名</th>
    <th>所属社員数</th>
    <th>操作</th>
  </tr>

  @foreach($departments as $department)
    <tr>
      <td>{{ $department->name }}</td>
      <td>{{ $department->employees_count }}</td>
      <td>
@can('update', $department)
  <a href="{{ route('departments.edit', $department) }}">編集</a>
@endcan

@can('delete', $department)
  <form method="POST" action="{{ route('departments.destroy', $department) }}" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('削除しますか？')">削除</button>
  </form>
@endcan
    </td>
    </tr>
  @endforeach
</table>

{{ $departments->links() }}

<p><a href="{{ route('employees.index') }}">← 社員一覧へ</a></p>
</body>
</html>