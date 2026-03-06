<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                社員一覧
            </h2>

            <div class="flex items-center gap-2">
                <a href="{{ route('departments.index') }}"
                   class="inline-flex items-center px-3 py-2 rounded-md text-white bg-blue-600">
                    部署一覧
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-3 py-2 rounded-md text-white bg-red-600">
                        ログアウト
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- ここは確認用のデバッグ。不要なら消してOK --}}
                <div class="mb-4 p-2" style="background:#fee;">
                    login: {{ auth()->user()?->email }} /
                    is_admin: {{ auth()->user()?->is_admin ? '1' : '0' }}
                </div>

                @if(session('success'))
                    <div class="mb-4 p-2" style="background:#e6ffed;">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-2" style="background:#ffe6e6;">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- 検索フォーム --}}
                <form method="GET" action="{{ route('employees.index') }}" class="mb-4">
                    <input type="text" name="q" placeholder="氏名 or Emailで検索" value="{{ $q ?? '' }}">

                    <select name="department_id">
                        <option value="">全部署</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" @selected(($departmentId ?? '') == $dept->id)>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit">検索</button>
                    <a href="{{ route('employees.index') }}">クリア</a>
                </form>

                <p class="mb-4">
                    <a href="{{ route('employees.create') }}">＋ 社員追加</a>
                </p>

                <table border="1" cellpadding="6">
                    <tr>
                        <th>
                            <a href="{{ route('employees.index', array_merge(request()->query(), [
                                'sort' => 'name',
                                'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc'
                            ])) }}">
                                名前
                            </a>
                        </th>
                        <th>メール</th>
                        <th>部署</th>
                        <th>
                            <a href="{{ route('employees.index', array_merge(request()->query(), [
                                'sort' => 'joined_on',
                                'direction' => $sort === 'joined_on' && $direction === 'asc' ? 'desc' : 'asc'
                            ])) }}">
                                入社日
                            </a>
                        </th>
                        <th>操作</th>
                    </tr>

                    @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->department->name }}</td>
                            <td>{{ $employee->joined_on }}</td>
                            <td>
                                <a href="{{ route('employees.edit', $employee) }}">編集</a>

                                @can('delete', $employee)
                                    <form method="POST" action="{{ route('employees.destroy', $employee) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('削除しますか？')">
                                            削除
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div class="mt-4">
                    {{ $employees->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>