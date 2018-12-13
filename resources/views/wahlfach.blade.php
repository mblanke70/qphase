@extends('layouts.app')

@section('title', 'Kurswahlen')

@section('heading')
    <h2>{{ $schwerpunkt->name }}</h2>
@endsection

@section('choices')

    <h2>Gewählte Fächer bzw. Kurse</h2>

    <div class="table-responsive">

        <table class="table table-bordered table-striped table-dark table-sm">
           <tr>
                <th scope="col">Typ</th>
                <th scope="col">Fach</th>
                <th scope="col">Lernfeld</th>
                <th scope="col">Stunden</th>
                <th scope="col">Halbjahre</th>
                <th scope="col">Einbringung</th>
            </tr>

        @foreach($matrix as $fachwahl)
            <tr>
                <td scope="col">
                    @if( $fachwahl['typ'] == 'wf')
                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $fachwahl['fach']->code }}').submit();">
                            <i class="fa fa-fw fa-trash" style="color:white"></i>
                        </a>
                       
                        <form id="delete-form-{{ $fachwahl['fach']->code }}" action="{{ url($stufe->code) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="wahlfach" value="{{ $fachwahl['fach']->code }}" />
                        </form>
                    @else
                        {{ $fachwahl['typ'] }}
                    @endif
                </td>
                <td>{{ $fachwahl['fach']->name }}</td>
                <td>
                    @if( isset($fachwahl['fach']->lf) )
                        {{ chr(65 + $fachwahl['fach']->lf) }}
                    @endif
                </td>
                <td>{{ $fachwahl['stunden'] }}</td>
                <td>
                    @if($fachwahl['halbjahre'] == 2)
                    <form action="{{ url($stufe->code.'/'.$fachwahl['fach']->code) }}" method="POST">
                        {{ csrf_field() }}

                        <div class="form-check form-check-inline">
                            <input type="radio" id="halbjahre[{{$fachwahl['typ']}}]" name="halbjahre" value="2" class="form-check-input" @if( $fachwahl['halbjahre'] == 2) checked="checked" @endif>
                            <label class="form-check-label" for="halbjahre[{{$fachwahl['typ']}}]">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="halbjahre[{{$fachwahl['typ']}}]" name="halbjahre" value="4" class="form-check-input" @if( $fachwahl['halbjahre'] == 4) checked="checked" @endif>
                            <label class="form-check-label" for="halbjahre[{{$fachwahl['typ']}}]">4</label>
                        </div>
                    </form>
                    @else
                        {{ $fachwahl['halbjahre'] }}
                    @endif     
                </td>
                <td>{{ $fachwahl['einbringung'] }} Kurse</td>
            </tr>
        @endforeach

            <tr>
                <td scope="col"></td>
                <td></td>
                <td style="text-align: right;">Summe:</td>
                <td colspan="2">
                    @if(isset($summe1)) {{ $summe1 }} Kurse @endif
                    @if(isset($summe2)) ({{ $summe2 }} Stunden) @endif
                </td>
            </tr>

        </table>
        
    </div>

@endsection

@section('content')

    <h3>{{ $stufe->name }}</h3>

    <form action="{{ url($stufe->code) }}" method="POST" role="form">

        {{ csrf_field() }}

        @if(isset($optionen))

            <div class="form-group">
                <select class="custom-select" name="wahlfach">
                    <option selected>Bitte auswählen...</option>

                @foreach ($optionen as $fach)
                    <option value="{{ $fach->code }}">{{ $fach->name }}</option>
                @endforeach

                </select>
            </div>

        @endif

        <div>
            <button type="submit" class="btn btn-primary">Hinzufügen</button>
        </div>

    </form>

@endsection

@section('footer')
    <p>
        <a href="{{url('/')}}" class="btn btn-danger" role="button">Neustart</a>
    </p>
@endsection

@section('js')
    <script>
        $(document).ready( function() {
            $('input[type=radio]').on('change', function(){
                $(this).closest('form').submit();
            });
        });
    </script>
@stop