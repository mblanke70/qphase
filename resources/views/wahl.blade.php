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
                <th scope="col">Std.</th>
                <th scope="col">Hj.</th>
                <th scope="col">Einbringung</th>
            </tr>

        @foreach($matrix as $fachwahl)
            <tr>
                <td scope="col">{{ $fachwahl['typ'] }}</td>
                <td>
                    {{ $fachwahl['fach']->name }}

                    @if($fachwahl['fach']->kf != null)
                        (KF)
                    @endif

                </td>
                <td>
                    @if( isset($fachwahl['fach']->lf) )
                        {{ chr(65 + $fachwahl['fach']->lf) }}
                    @endif
                </td>
                <td>{{ $fachwahl['stunden'] }}</td>
                <td>{{ $fachwahl['halbjahre'] }}</td>
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
    
    <p>
    Lernfelder : {{ "A: ".$lernfelder[0]." B: ".$lernfelder[1]." C: ".$lernfelder[2] }}
    </p>


@endsection

@section('content')

    <h3>{{ $stufe->name }}</h3>

    @if(isset($warnung))

        <div class="alert alert-danger pb-0">
            <ul>
            @foreach($warnung as $w)
                <li>{{ $w }}</li>
            @endforeach        
            </ul>
        </div>
        
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
    @endif
    
    <form action="{{ url($stufe->code) }}" method="POST" role="form">

        {{ csrf_field() }}

        @if(isset($optionen))

            <div class="row">
            @foreach ($optionen->chunk(7) as $chunk)
                <div class="col-md-6">
                @foreach ($chunk as $fach)
                
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="{{ $fach->code }}" name="{{ $stufe->code }}" value="{{ $fach->code }}" class="custom-control-input">
                            <label class="custom-control-label" for="{{ $fach->code }}">
                                {{ $fach->name }}
                            </label>
                        </div>
                    </div>

                @endforeach
                </div>
            @endforeach
            </div>

        @endif

        <div>
            <input type="submit" name="btn" class="btn btn-primary" value="Zurück">
            <input type="submit" name="btn" class="btn btn-primary" value="Weiter">
        </div>

    </form>

@endsection

@section('footer')
    <p>
        <a href="{{url('/')}}" class="btn btn-danger" role="button">Neustart</a>
    </p>
@endsection