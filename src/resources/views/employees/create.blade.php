<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            社員追加
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-3" style="background:#ffe6e6;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('employees.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label>部署</label><br>
                        <select name="department_id">
                            <option value="">選択してください</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" @selected(old('department_id') == $dept->id)>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label>氏名</label><br>
                        <input type="text" name="name" value="{{ old('name') }}">
                    </div>

                    <div class="mb-4">
                        <label>Email</label><br>
                        <input type="email" name="email" value="{{ old('email') }}">
                    </div>

                    <div class="mb-4">
                        <label>入社日</label><br>
                        <input type="date" name="joined_on" value="{{ old('joined_on') }}">
                    </div>

                    <button type="submit">登録</button>
                </form>

                <div class="mt-4">
                    <a href="{{ route('employees.index') }}">一覧へ戻る</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>