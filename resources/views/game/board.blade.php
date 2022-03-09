@extends('layouts.master')

@section('CONTENTS')
    <div class="flex justify-center" style="height: 1rem; margin-bottom: 0.5rem">
        <div class="text-gray-600 dark:text-gray-400 text-sm">
            {{ $statusMessage }}
        </div>
    </div>

    <form action="{{ route('game.process') }}" method="post">
        <table style="border: #4a5568 2px solid; border-collapse: collapse;">
            <input id="x" type="hidden" name="x" value="">
            <input id="y" type="hidden" name="y" value="">
            @csrf
            @foreach($board as $rowNum => $rowData)
                <tr>
                    @foreach($rowData as $colNum => $stone)
                        <td style="border: #a0aec0 1px solid; width: 3rem; height: 3rem; text-align: center; vertical-align: center; font-size: x-large" class="field" data-position-x="{{ $rowNum + 1 }}" data-position-y="{{ $colNum + 1 }}">
                            @if($stone === 0)
{{--                                <a href="#" class="field" data-position-x="{{ $rowNum + 1 }}" data-position-y="{{ $colNum + 1 }}" style="display: block; height: 100%; width: 100%"></a>--}}
                                @continue
                            @endif
                            {{ $stone === '01' ? '◯' : '●' }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </form>

    <div class="flex justify-center" style="height: 1rem; margin-top: 0.5rem">
        <div class="text-gray-600 dark:text-gray-400 text-sm">
            @if(session()->has('error')){{ session()->get('error') }}@endif
        </div>
    </div>

    <script>
        $(function(){
            $('.field').on('click', function () {
                const [x, y] = [$(this).data('position-x'), $(this).data('position-y')];
                console.log(x,y)
                $('#x').val(x);
                $('#y').val(y);
                $('form').submit();
            })
        });
    </script>
@endsection
