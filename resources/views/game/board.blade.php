@extends('layouts.master')

@section('CONTENTS')
    <div class="flex justify-center" style="height: 1rem; margin-bottom: 0.5rem">
        <div class="text-gray-600 dark:text-gray-400 text-sm">
            {{ $statusMessage }}
        </div>
    </div>

    <div class="flex justify-center">
        <form action="{{ route('game.process') }}" method="post">
            <input id="action" type="hidden" name="action" value="{{ $action }}">
            <input id="x" type="hidden" name="x" value="">
            <input id="y" type="hidden" name="y" value="">
            <table style="border: #4a5568 2px solid; border-collapse: collapse;">
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
    </div>

    <div class="flex justify-center" style="height: 1rem; margin-top: 0.5rem">
        <div class="text-gray-600 dark:text-gray-400 text-sm">
            @if(session()->has('error')){{ session()->get('error') }}@endif
        </div>
    </div>

    <script>
        $(function(){
            $('.field').on('click', function () {
                const [x, y] = [$(this).data('position-x'), $(this).data('position-y')];
                $('#x').val(x);
                $('#y').val(y);
                $('form').submit();
            });
        });

        $(window).on('load', function () {
            const action =  $('#action').val();
            if (action === '') return false;

            let options;
            if (action === '01') {
                options = {
                    position: 'bottom',
                    title: '置ける場所がありません...',
                    showConfirmButton: true,
                    confirmButtonText: 'スキップする',
                    background: 'lightgray',
                    backdrop: `rgba(0,0,0,0)`
                };
            } else {
                options = {
                    position: 'bottom',
                    showConfirmButton: true,
                    confirmButtonText: '相手のターンへ',
                    background: 'lightgray',
                    backdrop: `rgba(0,0,0,0)`,
                };
            }

            Swal.fire(options).then(function () {
                $('form').submit();
            })
        })
    </script>
@endsection
