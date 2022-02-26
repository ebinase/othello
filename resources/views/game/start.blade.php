@extends('layouts.master')

@section('CONTENTS')
    <table style="border: #4a5568 2px solid; border-collapse: collapse;">
    @foreach($board as $row)
        <tr>
            @foreach($row as $stone)
                <td style="border: #a0aec0 1px solid">
                @if($stone === 0)
                    {{'　'}}
                    @continue
                    @endif
                {{ $stone === '01' ? '◯' : '●' }}
                </td>
            @endforeach
        </tr>
    @endforeach
    </table>

@endsection
