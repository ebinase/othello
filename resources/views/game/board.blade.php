@extends('layouts.master')

@section('CONTENTS')
    <form action="/">
        <table style="border: #4a5568 2px solid; border-collapse: collapse;">
            <input id="selected_field_id" type="hidden" name="selected_field_id" value="">
            @foreach($board as $rowNum => $rowData)
                <tr>
                    @foreach($rowData as $colNum => $stone)
                        <td style="border: #a0aec0 1px solid; width: 3rem; height: 3rem; text-align: center; vertical-align: center; font-size: x-large">
                            @if($stone === 0)
                                <a href="" class="field" data-position="{{ ($rowNum)*count($rowData) + $colNum }}" style="display: block; height: 100%; width: 100%"></a>
                                @continue
                            @endif
                            {{ $stone === '01' ? '◯' : '●' }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </form>
@endsection
